<?php
/**
 * ACF Local Field Groups — Dan O'Hare Profile Page
 *
 * Registers all ACF field groups for the Dan page using acf_add_local_field_group().
 * Requires: Advanced Custom Fields Free (no ACF Pro features used).
 *
 * ACF Free features used (all compatible with ACF Free):
 *   - text, textarea, image (return_type: array), url, repeater
 *
 * ACF Pro features used: NONE
 *
 * Location rule: page_template == page-dan.php
 * (The page-dan.php template registers itself via "Template Name" comment.)
 */

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

/* ============================================================
   Shared location rule — all groups target the Dan page template
   ============================================================ */
$dan_location = array(
    array(
        array(
            'param'    => 'page_template',
            'operator' => '==',
            'value'    => 'page-dan.php',
        ),
    ),
);

/* ============================================================
   1. HERO
   ============================================================ */
acf_add_local_field_group( array(
    'key'                   => 'group_dan_hero',
    'title'                 => 'Dan — Hero',
    'fields'                => array(
        array(
            'key'           => 'field_dan_name',
            'label'         => 'Name',
            'name'          => 'dan_name',
            'type'          => 'text',
            'instructions'  => 'Full name displayed as the page H1.',
            'required'      => 1,
        ),
        array(
            'key'           => 'field_dan_roles',
            'label'         => 'Roles',
            'name'          => 'dan_roles',
            'type'          => 'repeater',
            'instructions'  => 'Up to 3 role entries displayed beside the orange left border.',
            'min'           => 0,
            'max'           => 3,
            'layout'        => 'table',
            'sub_fields'    => array(
                array(
                    'key'       => 'field_dan_role_title',
                    'label'     => 'Role Title',
                    'name'      => 'role_title',
                    'type'      => 'text',
                    'required'  => 1,
                    'wrapper'   => array( 'width' => '50' ),
                ),
                array(
                    'key'       => 'field_dan_role_org',
                    'label'     => 'Organisation',
                    'name'      => 'role_org',
                    'type'      => 'text',
                    'required'  => 1,
                    'wrapper'   => array( 'width' => '50' ),
                ),
            ),
        ),
        array(
            'key'           => 'field_dan_bio_lead',
            'label'         => 'Bio — Lead Paragraph',
            'name'          => 'dan_bio_lead',
            'type'          => 'textarea',
            'instructions'  => 'Displayed in 18px SemiBold below the roles.',
            'rows'          => 3,
        ),
        array(
            'key'           => 'field_dan_bio_sub',
            'label'         => 'Bio — Sub Paragraph',
            'name'          => 'dan_bio_sub',
            'type'          => 'textarea',
            'instructions'  => 'Displayed in 16px Regular below the lead paragraph.',
            'rows'          => 4,
        ),
        array(
            'key'           => 'field_dan_credentials',
            'label'         => 'Credential Badges',
            'name'          => 'dan_credentials',
            'type'          => 'repeater',
            'instructions'  => 'Yellow badges displayed in a row at the bottom of the left column.',
            'min'           => 0,
            'layout'        => 'table',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_credential_label',
                    'label'    => 'Credential Label',
                    'name'     => 'credential_label',
                    'type'     => 'text',
                    'required' => 1,
                ),
            ),
        ),
        array(
            'key'           => 'field_dan_portrait',
            'label'         => 'Portrait Photo',
            'name'          => 'dan_portrait',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'instructions'  => 'Portrait displayed in the right column of the hero.',
        ),
        array(
            'key'           => 'field_dan_header_illustration',
            'label'         => 'Header Illustration (decorative)',
            'name'          => 'dan_header_illustration',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'thumbnail',
            'instructions'  => 'Decorative illustrated asset positioned at the top-right corner of the hero.',
        ),
    ),
    'location'              => $dan_location,
    'menu_order'            => 10,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen'        => array( 'the_content', 'excerpt', 'discussion', 'comments', 'revisions', 'slug', 'author', 'format', 'page_attributes', 'featured_image', 'categories', 'tags', 'send-trackbacks' ),
) );

/* ============================================================
   2. STATS BAR
   ============================================================ */
acf_add_local_field_group( array(
    'key'                   => 'group_dan_stats',
    'title'                 => 'Dan — Stats',
    'fields'                => array(
        array(
            'key'           => 'field_dan_stats_eyebrow',
            'label'         => 'Eyebrow Label',
            'name'          => 'dan_stats_eyebrow',
            'type'          => 'text',
            'instructions'  => 'Small orange label above the stats heading.',
        ),
        array(
            'key'           => 'field_dan_stats_heading',
            'label'         => 'Heading',
            'name'          => 'dan_stats_heading',
            'type'          => 'text',
            'instructions'  => '40px SemiBold heading for the stats bar.',
        ),
        array(
            'key'           => 'field_dan_stats',
            'label'         => 'Stats',
            'name'          => 'dan_stats',
            'type'          => 'repeater',
            'instructions'  => 'Each stat is displayed as a coloured card.',
            'min'           => 0,
            'layout'        => 'table',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_stat_number',
                    'label'    => 'Number',
                    'name'     => 'stat_number',
                    'type'     => 'text',
                    'instructions' => 'e.g. "12+" or "50K+"',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '20' ),
                ),
                array(
                    'key'      => 'field_dan_stat_label',
                    'label'    => 'Label',
                    'name'     => 'stat_label',
                    'type'     => 'text',
                    'instructions' => 'e.g. "MP meetings"',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '25' ),
                ),
                array(
                    'key'      => 'field_dan_stat_sublabel',
                    'label'    => 'Sub-label',
                    'name'     => 'stat_sublabel',
                    'type'     => 'text',
                    'instructions' => 'e.g. "Policy & parliamentary engagement"',
                    'wrapper'  => array( 'width' => '35' ),
                ),
                array(
                    'key'      => 'field_dan_stat_bg_colour',
                    'label'    => 'Card Background Colour',
                    'name'     => 'stat_bg_colour',
                    'type'     => 'text',
                    'instructions' => 'Hex colour for the card background, e.g. #E5C957',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '20' ),
                ),
            ),
        ),
    ),
    'location'              => $dan_location,
    'menu_order'            => 20,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
) );

/* ============================================================
   3. ABOUT DAN
   ============================================================ */
acf_add_local_field_group( array(
    'key'                   => 'group_dan_about',
    'title'                 => 'Dan — About',
    'fields'                => array(
        array(
            'key'           => 'field_dan_about_eyebrow',
            'label'         => 'Eyebrow Label',
            'name'          => 'dan_about_eyebrow',
            'type'          => 'text',
            'instructions'  => 'Small plum-coloured label above the heading.',
        ),
        array(
            'key'           => 'field_dan_about_heading',
            'label'         => 'Heading',
            'name'          => 'dan_about_heading',
            'type'          => 'text',
            'instructions'  => '40px SemiBold section heading.',
        ),
        array(
            'key'           => 'field_dan_about_col1',
            'label'         => 'Body Text — Column 1',
            'name'          => 'dan_about_col1',
            'type'          => 'wysiwyg',
            'tabs'          => 'visual',
            'toolbar'       => 'basic',
            'media_upload'  => 0,
            'instructions'  => 'Left body column. 18px Regular.',
        ),
        array(
            'key'           => 'field_dan_about_col2',
            'label'         => 'Body Text — Column 2',
            'name'          => 'dan_about_col2',
            'type'          => 'wysiwyg',
            'tabs'          => 'visual',
            'toolbar'       => 'basic',
            'media_upload'  => 0,
            'instructions'  => 'Right body column. 18px Regular.',
        ),
        array(
            'key'           => 'field_dan_about_illustration',
            'label'         => 'About Illustration',
            'name'          => 'dan_about_illustration',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'instructions'  => 'Decorative illustration displayed on the left (~522px wide), bleeding to the page edge.',
        ),
    ),
    'location'              => $dan_location,
    'menu_order'            => 30,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
) );

/* ============================================================
   4. MEDIA COVERAGE
   ============================================================ */
acf_add_local_field_group( array(
    'key'                   => 'group_dan_media',
    'title'                 => 'Dan — Media Coverage',
    'fields'                => array(
        array(
            'key'           => 'field_dan_media_eyebrow',
            'label'         => 'Eyebrow Label',
            'name'          => 'dan_media_eyebrow',
            'type'          => 'text',
        ),
        array(
            'key'           => 'field_dan_media_heading',
            'label'         => 'Heading',
            'name'          => 'dan_media_heading',
            'type'          => 'text',
        ),
        array(
            'key'           => 'field_dan_media_subheading',
            'label'         => 'Sub-heading',
            'name'          => 'dan_media_subheading',
            'type'          => 'textarea',
            'rows'          => 3,
            'instructions'  => '18px Regular paragraph below the main heading.',
        ),
        array(
            'key'           => 'field_dan_media_articles',
            'label'         => 'Articles',
            'name'          => 'dan_media_articles',
            'type'          => 'repeater',
            'instructions'  => 'Media article cards. Shown 3 at a time.',
            'min'           => 0,
            'layout'        => 'block',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_media_article_outlet',
                    'label'    => 'Outlet Name',
                    'name'     => 'article_outlet',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '50' ),
                ),
                array(
                    'key'      => 'field_dan_media_article_headline',
                    'label'    => 'Headline',
                    'name'     => 'article_headline',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '50' ),
                ),
                array(
                    'key'      => 'field_dan_media_article_image',
                    'label'    => 'Article Image',
                    'name'     => 'article_image',
                    'type'     => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'thumbnail',
                    'wrapper'  => array( 'width' => '50' ),
                ),
                array(
                    'key'      => 'field_dan_media_article_url',
                    'label'    => 'Article URL',
                    'name'     => 'article_url',
                    'type'     => 'url',
                    'wrapper'  => array( 'width' => '50' ),
                ),
            ),
        ),
        array(
            'key'           => 'field_dan_media_logos',
            'label'         => 'Media Outlet Logos',
            'name'          => 'dan_media_logos',
            'type'          => 'repeater',
            'instructions'  => 'Logo strip displayed below the article cards.',
            'min'           => 0,
            'layout'        => 'table',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_media_logo_image',
                    'label'    => 'Logo Image',
                    'name'     => 'logo_image',
                    'type'     => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'thumbnail',
                    'required' => 1,
                ),
            ),
        ),
    ),
    'location'              => $dan_location,
    'menu_order'            => 40,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
) );

/* ============================================================
   5. POLICY & SYSTEMS
   ============================================================ */
acf_add_local_field_group( array(
    'key'                   => 'group_dan_policy',
    'title'                 => 'Dan — Policy & Systems',
    'fields'                => array(
        array(
            'key'           => 'field_dan_policy_eyebrow',
            'label'         => 'Eyebrow Label',
            'name'          => 'dan_policy_eyebrow',
            'type'          => 'text',
        ),
        array(
            'key'           => 'field_dan_policy_heading',
            'label'         => 'Heading',
            'name'          => 'dan_policy_heading',
            'type'          => 'text',
        ),
        array(
            'key'           => 'field_dan_policy_description',
            'label'         => 'Description',
            'name'          => 'dan_policy_description',
            'type'          => 'textarea',
            'rows'          => 4,
            'instructions'  => '18px Regular text in the left column.',
        ),
        array(
            'key'           => 'field_dan_policy_items',
            'label'         => 'Policy Items',
            'name'          => 'dan_policy_items',
            'type'          => 'repeater',
            'instructions'  => 'List of policy/work items shown in the right column.',
            'min'           => 0,
            'layout'        => 'block',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_policy_item_title',
                    'label'    => 'Title',
                    'name'     => 'item_title',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '40' ),
                ),
                array(
                    'key'      => 'field_dan_policy_item_desc',
                    'label'    => 'Description',
                    'name'     => 'item_description',
                    'type'     => 'text',
                    'wrapper'  => array( 'width' => '45' ),
                ),
                array(
                    'key'      => 'field_dan_policy_item_url',
                    'label'    => 'Link URL',
                    'name'     => 'item_url',
                    'type'     => 'url',
                    'wrapper'  => array( 'width' => '15' ),
                ),
            ),
        ),
    ),
    'location'              => $dan_location,
    'menu_order'            => 50,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
) );

/* ============================================================
   6. PODCAST
   ============================================================ */
acf_add_local_field_group( array(
    'key'                   => 'group_dan_podcast',
    'title'                 => 'Dan — Podcast',
    'fields'                => array(
        array(
            'key'           => 'field_dan_podcast_eyebrow',
            'label'         => 'Eyebrow Label',
            'name'          => 'dan_podcast_eyebrow',
            'type'          => 'text',
            'instructions'  => 'Small blue label above the podcast heading.',
        ),
        array(
            'key'           => 'field_dan_podcast_heading',
            'label'         => 'Heading',
            'name'          => 'dan_podcast_heading',
            'type'          => 'text',
        ),
        array(
            'key'           => 'field_dan_podcast_description',
            'label'         => 'Description',
            'name'          => 'dan_podcast_description',
            'type'          => 'textarea',
            'rows'          => 4,
        ),
        array(
            'key'           => 'field_dan_podcast_artwork',
            'label'         => 'Podcast Artwork',
            'name'          => 'dan_podcast_artwork',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'instructions'  => 'Square artwork image, displayed at 365×365px.',
        ),
        array(
            'key'           => 'field_dan_podcast_stats',
            'label'         => 'Podcast Stats',
            'name'          => 'dan_podcast_stats',
            'type'          => 'repeater',
            'instructions'  => 'Stats shown in a row with right-border separators.',
            'min'           => 0,
            'max'           => 4,
            'layout'        => 'table',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_podcast_stat_number',
                    'label'    => 'Number',
                    'name'     => 'stat_number',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '40' ),
                ),
                array(
                    'key'      => 'field_dan_podcast_stat_label',
                    'label'    => 'Label',
                    'name'     => 'stat_label',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '60' ),
                ),
            ),
        ),
        array(
            'key'           => 'field_dan_podcast_episodes',
            'label'         => 'Featured Episodes',
            'name'          => 'dan_podcast_episodes',
            'type'          => 'repeater',
            'instructions'  => 'Featured episodes listed below the podcast info.',
            'min'           => 0,
            'layout'        => 'block',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_ep_ref',
                    'label'    => 'Episode Reference',
                    'name'     => 'ep_ref',
                    'type'     => 'text',
                    'instructions' => 'e.g. "E1:"',
                    'wrapper'  => array( 'width' => '15' ),
                ),
                array(
                    'key'      => 'field_dan_ep_title',
                    'label'    => 'Episode Title',
                    'name'     => 'ep_title',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '50' ),
                ),
                array(
                    'key'      => 'field_dan_ep_url',
                    'label'    => 'Episode URL',
                    'name'     => 'ep_url',
                    'type'     => 'url',
                    'wrapper'  => array( 'width' => '35' ),
                ),
                array(
                    'key'      => 'field_dan_ep_platforms',
                    'label'    => 'Streaming Platforms',
                    'name'     => 'ep_platforms',
                    'type'     => 'repeater',
                    'instructions' => 'Platform badge images (e.g. Apple Podcasts, Spotify).',
                    'min'      => 0,
                    'layout'   => 'table',
                    'sub_fields' => array(
                        array(
                            'key'      => 'field_dan_ep_platform_image',
                            'label'    => 'Platform Image',
                            'name'     => 'platform_image',
                            'type'     => 'image',
                            'return_format' => 'array',
                            'preview_size'  => 'thumbnail',
                            'required' => 1,
                            'wrapper'  => array( 'width' => '50' ),
                        ),
                        array(
                            'key'      => 'field_dan_ep_platform_url',
                            'label'    => 'Platform URL',
                            'name'     => 'platform_url',
                            'type'     => 'url',
                            'wrapper'  => array( 'width' => '50' ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'location'              => $dan_location,
    'menu_order'            => 60,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
) );

/* ============================================================
   7. SIGNATURE TALKS
   ============================================================ */
acf_add_local_field_group( array(
    'key'                   => 'group_dan_talks',
    'title'                 => 'Dan — Signature Talks',
    'fields'                => array(
        array(
            'key'           => 'field_dan_talks_eyebrow',
            'label'         => 'Eyebrow Label',
            'name'          => 'dan_talks_eyebrow',
            'type'          => 'text',
            'instructions'  => 'Displayed in white on the pink background.',
        ),
        array(
            'key'           => 'field_dan_talks_heading',
            'label'         => 'Heading',
            'name'          => 'dan_talks_heading',
            'type'          => 'text',
        ),
        array(
            'key'           => 'field_dan_talks',
            'label'         => 'Talks',
            'name'          => 'dan_talks',
            'type'          => 'repeater',
            'instructions'  => 'Talk cards displayed in a 3-column grid.',
            'min'           => 0,
            'layout'        => 'block',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_talk_topic',
                    'label'    => 'Topic Tag',
                    'name'     => 'talk_topic',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '30' ),
                ),
                array(
                    'key'      => 'field_dan_talk_description',
                    'label'    => 'Description',
                    'name'     => 'talk_description',
                    'type'     => 'textarea',
                    'rows'     => 3,
                    'wrapper'  => array( 'width' => '45' ),
                ),
                array(
                    'key'      => 'field_dan_talk_audience',
                    'label'    => 'Audience',
                    'name'     => 'talk_audience',
                    'type'     => 'text',
                    'wrapper'  => array( 'width' => '25' ),
                ),
            ),
        ),
        array(
            'key'           => 'field_dan_talks_cta_text',
            'label'         => 'CTA Text',
            'name'          => 'dan_talks_cta_text',
            'type'          => 'text',
            'instructions'  => '18px SemiBold text above the CTA button.',
        ),
        array(
            'key'           => 'field_dan_talks_cta_url',
            'label'         => 'CTA URL',
            'name'          => 'dan_talks_cta_url',
            'type'          => 'url',
        ),
    ),
    'location'              => $dan_location,
    'menu_order'            => 70,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
) );

/* ============================================================
   8. THOUGHT PIECES
   ============================================================ */
acf_add_local_field_group( array(
    'key'                   => 'group_dan_thoughts',
    'title'                 => 'Dan — Thought Pieces',
    'fields'                => array(
        array(
            'key'           => 'field_dan_thoughts_eyebrow',
            'label'         => 'Eyebrow Label',
            'name'          => 'dan_thoughts_eyebrow',
            'type'          => 'text',
            'instructions'  => 'Green accent label.',
        ),
        array(
            'key'           => 'field_dan_thoughts_heading',
            'label'         => 'Heading',
            'name'          => 'dan_thoughts_heading',
            'type'          => 'text',
        ),
        array(
            'key'           => 'field_dan_thoughts_articles',
            'label'         => 'Thought Pieces',
            'name'          => 'dan_thoughts_articles',
            'type'          => 'repeater',
            'min'           => 0,
            'layout'        => 'block',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_thoughts_article_topic',
                    'label'    => 'Topic',
                    'name'     => 'article_topic',
                    'type'     => 'text',
                    'wrapper'  => array( 'width' => '25' ),
                ),
                array(
                    'key'      => 'field_dan_thoughts_article_title',
                    'label'    => 'Title',
                    'name'     => 'article_title',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '40' ),
                ),
                array(
                    'key'      => 'field_dan_thoughts_article_url',
                    'label'    => 'URL',
                    'name'     => 'article_url',
                    'type'     => 'url',
                    'wrapper'  => array( 'width' => '35' ),
                ),
                array(
                    'key'      => 'field_dan_thoughts_article_image',
                    'label'    => 'Image',
                    'name'     => 'article_image',
                    'type'     => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'thumbnail',
                ),
                array(
                    'key'      => 'field_dan_thoughts_article_desc',
                    'label'    => 'Description',
                    'name'     => 'article_description',
                    'type'     => 'textarea',
                    'rows'     => 3,
                ),
            ),
        ),
    ),
    'location'              => $dan_location,
    'menu_order'            => 80,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
) );

/* ============================================================
   9. WORKING TOGETHER (Collaborations)
   ============================================================ */
acf_add_local_field_group( array(
    'key'                   => 'group_dan_collabs',
    'title'                 => 'Dan — Working Together',
    'fields'                => array(
        array(
            'key'           => 'field_dan_collab_eyebrow',
            'label'         => 'Eyebrow Label',
            'name'          => 'dan_collab_eyebrow',
            'type'          => 'text',
        ),
        array(
            'key'           => 'field_dan_collab_heading',
            'label'         => 'Heading',
            'name'          => 'dan_collab_heading',
            'type'          => 'text',
        ),
        array(
            'key'           => 'field_dan_collabs',
            'label'         => 'Collaborations',
            'name'          => 'dan_collabs',
            'type'          => 'repeater',
            'instructions'  => 'Collaboration cards shown in a 3-column grid.',
            'min'           => 0,
            'layout'        => 'block',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_collab_logo',
                    'label'    => 'Partner Logo',
                    'name'     => 'collab_logo',
                    'type'     => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'thumbnail',
                    'wrapper'  => array( 'width' => '25' ),
                ),
                array(
                    'key'      => 'field_dan_collab_role',
                    'label'    => 'Role Label',
                    'name'     => 'collab_role',
                    'type'     => 'text',
                    'instructions' => 'Orange label, e.g. "Advisor"',
                    'wrapper'  => array( 'width' => '25' ),
                ),
                array(
                    'key'      => 'field_dan_collab_title',
                    'label'    => 'Title',
                    'name'     => 'collab_title',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '25' ),
                ),
                array(
                    'key'      => 'field_dan_collab_description',
                    'label'    => 'Description',
                    'name'     => 'collab_description',
                    'type'     => 'textarea',
                    'rows'     => 3,
                    'wrapper'  => array( 'width' => '25' ),
                ),
            ),
        ),
    ),
    'location'              => $dan_location,
    'menu_order'            => 90,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
) );

/* ============================================================
   10. TESTIMONIALS
   ============================================================ */
acf_add_local_field_group( array(
    'key'                   => 'group_dan_testimonials',
    'title'                 => 'Dan — Testimonials',
    'fields'                => array(
        array(
            'key'           => 'field_dan_testimonials_eyebrow',
            'label'         => 'Eyebrow Label',
            'name'          => 'dan_testimonials_eyebrow',
            'type'          => 'text',
            'instructions'  => 'Small blue label above the testimonials heading.',
        ),
        array(
            'key'           => 'field_dan_testimonials_heading',
            'label'         => 'Heading',
            'name'          => 'dan_testimonials_heading',
            'type'          => 'text',
        ),
        array(
            'key'           => 'field_dan_testimonials',
            'label'         => 'Testimonials',
            'name'          => 'dan_testimonials',
            'type'          => 'repeater',
            'instructions'  => 'Testimonial cards displayed in a CSS-columns masonry layout.',
            'min'           => 0,
            'layout'        => 'block',
            'sub_fields'    => array(
                array(
                    'key'      => 'field_dan_quote_text',
                    'label'    => 'Quote',
                    'name'     => 'quote_text',
                    'type'     => 'textarea',
                    'rows'     => 4,
                    'required' => 1,
                ),
                array(
                    'key'      => 'field_dan_quote_name',
                    'label'    => 'Name',
                    'name'     => 'quote_name',
                    'type'     => 'text',
                    'required' => 1,
                    'wrapper'  => array( 'width' => '33' ),
                ),
                array(
                    'key'      => 'field_dan_quote_title',
                    'label'    => 'Title / Role',
                    'name'     => 'quote_title',
                    'type'     => 'text',
                    'wrapper'  => array( 'width' => '33' ),
                ),
                array(
                    'key'      => 'field_dan_quote_org',
                    'label'    => 'Organisation',
                    'name'     => 'quote_org',
                    'type'     => 'text',
                    'wrapper'  => array( 'width' => '34' ),
                ),
            ),
        ),
    ),
    'location'              => $dan_location,
    'menu_order'            => 100,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
) );
