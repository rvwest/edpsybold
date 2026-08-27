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
 * The archive listing shows every post carrying the tag, as normal —
 * including older posts that predate the campaign. The in-article
 * treatment (inserted block + styled tag) is scoped separately to just
 * the posts chosen in tag_cta_posts, so tagging an old post after the
 * fact doesn't retroactively pull it into a live campaign.
 *
 * ACF Pro features used: NONE (true_false, wysiwyg, image, relationship —
 * all in ACF Free)
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
            'key'               => 'field_tag_cta_posts',
            'label'             => 'Campaign posts',
            'name'              => 'tag_cta_posts',
            'type'              => 'relationship',
            'instructions'      => 'Choose which blog posts tagged with this tag are part of the campaign — including unpublished drafts, so campaign styling is already in place when they go live. Only these posts get the promo block and styled tag when opened directly; the tag\'s archive listing still shows every tagged post as normal.',
            'post_type'         => array('post'),
            'filters'           => array('search'),
            'return_format'     => 'id',
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

/**
 * Scope the tag_cta_posts relationship field's left-hand "available posts"
 * list to just the posts already carrying the tag being edited (instead of
 * every post on the site), and include unpublished statuses so drafts can
 * be added to a campaign and already have the styling in place once
 * published.
 */
add_filter( 'acf/fields/relationship/query/key=field_tag_cta_posts', function ( $args, $field, $post_id ) {
    if ( is_string( $post_id ) && strpos( $post_id, 'term_' ) === 0 ) {
        $term_id = (int) substr( $post_id, 5 );
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'post_tag',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        );
    }

    $args['post_status'] = array( 'publish', 'future', 'draft', 'pending', 'private' );

    return $args;
}, 10, 3 );
