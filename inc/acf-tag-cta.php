<?php
/**
 * ACF Local Field Group — Tag Campaign Promo Blocks
 *
 * Adds fields to every post_tag term edit screen (Blog > Tags) so admins
 * can turn on a promo campaign for that tag and edit its text/link/image
 * without touching code. Several tags can have this active at the same
 * time. Two separate text fields are provided because the block appears
 * in two different contexts with different copy:
 *   - tag_cta_text      — at the top of the tag's archive page
 *   - tag_cta_blog_text — inserted into the body of tagged blog posts
 *
 * ACF Pro features used: NONE (true_false, wysiwyg, image — all in ACF Free)
 *
 * Location rule: taxonomy == post_tag
 */

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

acf_add_local_field_group( array(
    'key'      => 'group_tag_cta',
    'title'    => 'Tag Campaign — Promo Blocks',
    'fields'   => array(
        array(
            'key'           => 'field_tag_cta_active',
            'label'         => 'Show promo campaign',
            'name'          => 'tag_cta_active',
            'type'          => 'true_false',
            'instructions'  => 'Display the promo block at the top of this tag\'s archive page, and inside the body of posts tagged with it.',
            'ui'            => 1,
            'default_value' => 0,
        ),
        array(
            'key'               => 'field_tag_cta_text',
            'label'             => 'Archive page banner text',
            'name'              => 'tag_cta_text',
            'type'              => 'wysiwyg',
            'instructions'      => 'Text shown in the banner at the top of this tag\'s archive page. Use the toolbar to add a link.',
            'tabs'              => 'visual',
            'toolbar'           => 'basic',
            'media_upload'      => 0,
            'delay'             => 1,
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_tag_cta_active',
                        'operator' => '==',
                        'value'    => '1',
                    ),
                ),
            ),
        ),
        array(
            'key'               => 'field_tag_cta_blog_text',
            'label'             => 'Blog post banner text',
            'name'              => 'tag_cta_blog_text',
            'type'              => 'wysiwyg',
            'instructions'      => 'Text shown in the block inserted after the first paragraph of any blog post tagged with this tag. Use the toolbar to add a link.',
            'tabs'              => 'visual',
            'toolbar'           => 'basic',
            'media_upload'      => 0,
            'delay'             => 1,
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_tag_cta_active',
                        'operator' => '==',
                        'value'    => '1',
                    ),
                ),
            ),
        ),
        array(
            'key'               => 'field_tag_cta_image',
            'label'             => 'Promo image',
            'name'              => 'tag_cta_image',
            'type'              => 'image',
            'return_format'     => 'array',
            'preview_size'      => 'medium',
            'instructions'      => 'Image shown in both the archive banner and the blog post block. Defaults to the swirls illustration if left blank.',
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_tag_cta_active',
                        'operator' => '==',
                        'value'    => '1',
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param'    => 'taxonomy',
                'operator' => '==',
                'value'    => 'post_tag',
            ),
        ),
    ),
) );
