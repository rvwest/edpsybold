#!/usr/bin/env python3
from __future__ import annotations
import re
from pathlib import Path
from typing import List, Tuple

BASE_DIR = Path(__file__).resolve().parent.parent / "css"
ENTRY_FILE = BASE_DIR / "edpsy-bold-style.css"
LEGACY_FILE = BASE_DIR / "edpsy-bold-style--legacy.css"

COMMENT_RE = re.compile(r"/\*[^*]*\*+(?:[^/*][^*]*\*+)*/", re.S)
IMPORT_RE = re.compile(r"@import\s+url\(['\"]([^'\"]+)['\"]\)\s*;", re.I)
CONTEXT_AT_RULES = {"@media", "@supports", "@layer", "@document"}


def strip_comments(css: str) -> str:
    return COMMENT_RE.sub("", css)


def normalize_whitespace(css: str) -> str:
    return css.replace("\r\n", "\n")


def split_selector_list(selector: str) -> List[str]:
    parts: List[str] = []
    buf: List[str] = []
    depth_round = depth_square = depth_curly = 0
    in_string: str | None = None
    i = 0
    while i < len(selector):
        ch = selector[i]
        if in_string:
            buf.append(ch)
            if ch == in_string and selector[i - 1] != '\\':
                in_string = None
            i += 1
            continue
        if ch in ('"', "'"):
            buf.append(ch)
            in_string = ch
            i += 1
            continue
        if ch == '(':
            depth_round += 1
        elif ch == ')':
            depth_round = max(depth_round - 1, 0)
        elif ch == '[':
            depth_square += 1
        elif ch == ']':
            depth_square = max(depth_square - 1, 0)
        elif ch == '{':
            depth_curly += 1
        elif ch == '}':
            depth_curly = max(depth_curly - 1, 0)
        if ch == ',' and depth_round == depth_square == depth_curly == 0:
            part = ''.join(buf).strip()
            if part:
                parts.append(part)
            buf = []
            i += 1
            continue
        buf.append(ch)
        i += 1
    part = ''.join(buf).strip()
    if part:
        parts.append(part)
    return parts


def combine_selectors(parent: List[str], current: List[str]) -> List[str]:
    if not parent:
        return current
    combined: List[str] = []
    for p in parent:
        for c in current:
            if '&' in c:
                combined.append(c.replace('&', p))
            else:
                stripped = c.strip()
                if stripped.startswith((':', '::', '>', '+', '~')):
                    combined.append(p + stripped)
                else:
                    combined.append(f"{p} {stripped}".strip())
    return combined


def read_block(css: str, start: int) -> Tuple[str, int]:
    assert css[start] == '{'
    depth = 1
    i = start + 1
    in_string: str | None = None
    while i < len(css):
        ch = css[i]
        if in_string:
            if ch == in_string and css[i - 1] != '\\':
                in_string = None
            i += 1
            continue
        if ch in ('"', "'"):
            in_string = ch
            i += 1
            continue
        if ch == '{':
            depth += 1
        elif ch == '}':
            depth -= 1
            if depth == 0:
                return css[start + 1:i], i + 1
        i += 1
    raise ValueError('Unclosed block')


def skip_whitespace(css: str, start: int) -> int:
    while start < len(css) and css[start] in ' \t\n\r':
        start += 1
    return start


def read_until(css: str, start: int, stop_chars: str) -> Tuple[str, int]:
    buf: List[str] = []
    i = start
    depth_round = depth_square = 0
    in_string: str | None = None
    while i < len(css):
        ch = css[i]
        if in_string:
            buf.append(ch)
            if ch == in_string and css[i - 1] != '\\':
                in_string = None
            i += 1
            continue
        if ch in ('"', "'"):
            buf.append(ch)
            in_string = ch
            i += 1
            continue
        if ch == '(':
            depth_round += 1
        elif ch == ')':
            depth_round = max(depth_round - 1, 0)
        elif ch == '[':
            depth_square += 1
        elif ch == ']':
            depth_square = max(depth_square - 1, 0)
        elif depth_round == depth_square == 0 and ch in stop_chars:
            return ''.join(buf).strip(), i
        buf.append(ch)
        i += 1
    return ''.join(buf).strip(), i


def split_block_items(block: str):
    items = []
    i = 0
    length = len(block)
    while i < length:
        i = skip_whitespace(block, i)
        if i >= length:
            break
        if block[i] == '@':
            prelude, pos = read_until(block, i, '{;')
            if pos < length and block[pos] == ';':
                items.append(('at-rule', prelude, None))
                i = pos + 1
            else:
                inner, new_pos = read_block(block, pos)
                items.append(('at-rule-block', prelude, inner))
                i = new_pos
            continue
        token, pos = read_until(block, i, '{;')
        if pos >= length:
            break
        if block[pos] == ';':
            items.append(('decl', token.strip(), None))
            i = pos + 1
        else:
            inner, new_pos = read_block(block, pos)
            items.append(('rule', token.strip(), inner))
            i = new_pos
    return items


def indent(text: str) -> str:
    lines = text.split('\n')
    return '\n'.join(('    ' + line if line else '') for line in lines)


def wrap_with_at_stack(content: str, at_stack: List[str]) -> str:
    wrapped = content
    for at_rule in reversed(at_stack):
        wrapped = f"{at_rule.strip()} {{\n{indent(wrapped)}\n}}"
    return wrapped


def emit_rule(selectors: List[str], declarations: List[str], at_stack: List[str], output: List[str]):
    if not selectors or not declarations:
        return
    decl_lines = '\n'.join(f"    {decl.strip().rstrip(';')}" + ';' for decl in declarations)
    rule_text = f"{', '.join(selectors)} {{\n{decl_lines}\n}}"
    output.append(wrap_with_at_stack(rule_text, at_stack))


def emit_at_rule(line: str, at_stack: List[str], output: List[str]):
    text = f"{line.strip()};"
    output.append(wrap_with_at_stack(text, at_stack))


def emit_at_rule_block(token: str, inner: str, selectors: List[str], at_stack: List[str], output: List[str]):
    rule_name = token.strip().split(None, 1)[0].lower()
    if rule_name in CONTEXT_AT_RULES:
        flatten_block(inner, selectors, at_stack + [token.strip()], output)
    else:
        block_text = f"{token.strip()} {{\n{indent(inner.strip())}\n}}"
        output.append(wrap_with_at_stack(block_text, at_stack))


def flatten_block(block: str, selectors: List[str], at_stack: List[str], output: List[str]):
    declarations: List[str] = []
    for kind, token, inner in split_block_items(block):
        if kind == 'decl':
            declarations.append(token)
        elif kind == 'rule':
            child_selectors = split_selector_list(token)
            combined = combine_selectors(selectors, child_selectors)
            flatten_block(inner, combined, at_stack, output)
        elif kind == 'at-rule':
            emit_at_rule(token, at_stack, output)
        elif kind == 'at-rule-block':
            emit_at_rule_block(token, inner, selectors, at_stack, output)
    if declarations and selectors:
        emit_rule(selectors, declarations, at_stack, output)


def flatten_stylesheet(css: str, at_stack: List[str], output: List[str]):
    i = 0
    length = len(css)
    while i < length:
        i = skip_whitespace(css, i)
        if i >= length:
            break
        if css[i] == '@':
            prelude, pos = read_until(css, i, '{;')
            if pos < length and css[pos] == ';':
                output.append(wrap_with_at_stack(prelude.strip() + ';', at_stack))
                i = pos + 1
            else:
                inner, new_pos = read_block(css, pos)
                name = prelude.strip().split(None, 1)[0].lower()
                if name in CONTEXT_AT_RULES:
                    flatten_stylesheet(inner, at_stack + [prelude.strip()], output)
                else:
                    block_text = f"{prelude.strip()} {{\n{indent(inner.strip())}\n}}"
                    output.append(wrap_with_at_stack(block_text, at_stack))
                i = new_pos
        else:
            selector_text, pos = read_until(css, i, '{')
            inner, new_pos = read_block(css, pos)
            selectors = split_selector_list(selector_text.strip())
            flatten_block(inner, selectors, at_stack, output)
            i = new_pos


def gather_sources(entry: Path) -> str:
    combined: List[str] = []
    fontawesome_imports: List[str] = []
    seen: set[Path] = set()
    seen_imports: set[str] = set()

    def handle_file(path: Path):
        if path in seen or not path.exists():
            return
        seen.add(path)
        content = normalize_whitespace(path.read_text(encoding='utf-8'))
        imports = list(IMPORT_RE.finditer(content))
        body = IMPORT_RE.sub('', content)
        for match in imports:
            url = match.group(1)
            if url.startswith('fontawesome'):
                if url not in seen_imports:
                    fontawesome_imports.append(f"@import url('{url}');")
                    seen_imports.add(url)
            else:
                target = (path.parent / url).resolve()
                handle_file(target)
        combined.append(strip_comments(body))

    handle_file(entry)
    return '\n'.join(fontawesome_imports + combined)


def main():
    raw_css = gather_sources(ENTRY_FILE)
    flattened: List[str] = []
    flatten_stylesheet(raw_css, [], flattened)
    output = '\n\n'.join(line for line in flattened if line.strip()) + '\n'
    LEGACY_FILE.write_text(output, encoding='utf-8')


if __name__ == '__main__':
    main()
