<?php
error_reporting(E_ERROR | E_PARSE);
// Minimal environment to render event template and ensure nested templates receive data.

// Stub WordPress and TEC functions used in templates.
function tribe_get_post_class($classes, $post_id) {
    $classes[] = 'post-' . $post_id;
    return $classes;
}
function tribe_classes($classes) {
    echo 'class="' . esc_attr(implode(' ', array_filter($classes))) . '"';
}
function esc_url($url) { return $url; }
function esc_html($text) { return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }
function esc_attr($text) { return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }
function esc_html_x($text) { return esc_html($text); }
function do_action($hook, ...$args) { /* no-op for test */ }
function is_front_page() { return false; }
function is_home() { return false; }
function has_term($term, $taxonomy, $post_id) {
    return $term === 'on-demand';
}

// Minimal DateTime utilities used by date-tag template.
class Stub_DateTime extends DateTime {
    public function format_i18n($format) { return $this->format($format); }
}
class Tribe__Date_Utils {
    const DBDATEFORMAT = 'Y-m-d H:i:s';
}

// Simple collection to mimic TEC venue collection.
class VenueCollection implements Countable, ArrayAccess {
    private $venues = [];
    public function __construct($venues) { $this->venues = $venues; }
    public function count(): int { return count($this->venues); }
    public function offsetExists($offset): bool { return isset($this->venues[$offset]); }
    #[\ReturnTypeWillChange]
    public function offsetGet($offset) { return $this->venues[$offset]; }
    public function offsetSet($offset, $value): void { $this->venues[$offset] = $value; }
    public function offsetUnset($offset): void { unset($this->venues[$offset]); }
}

// Template loader mimicking TEC's $this->template() behaviour.
class EDP_Tribe_Template {
    public function template($template, $data = []) {
        $path = __DIR__ . '/../tribe/events/v2/' . $template . '.php';
        if (!file_exists($path)) {
            return;
        }
        extract($data);
        include $path;
    }
}

// Build a fake event object with minimal properties used by templates.
$event = (object) [
    'ID'        => 1,
    'title'     => 'Sample Event',
    'permalink' => 'https://example.com/event',
    'featured'  => false,
    'dates'     => (object) [ 'start_display' => new Stub_DateTime('2030-01-02 10:00:00') ],
    'venues'    => new VenueCollection([(object) ['post_title' => 'Online', 'city' => 'London']]),
];

$tpl = new EDP_Tribe_Template();
$event_date_attr = '';
$tpl->template('list/event', [
    'event'        => $event,
    'is_past'      => false,
    'request_date' => null,
    'slug'         => 'test',
]);
