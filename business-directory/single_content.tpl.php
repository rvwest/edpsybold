<?php
/** 
 * Listing detail view rendering template 
 * 
 * @package BDP/Templates/Single Content 
 */

function edp_render_meta_field_array($fields, $field_key, $label)
{
    if (!empty($fields->{$field_key}->raw) && is_array($fields->{$field_key}->raw)) {
        echo '<div class="wpbdp-field-display"><span class="field-label">' . esc_html($label) . '</span><div class="value">';
        foreach ($fields->{$field_key}->raw as $item) {
            echo '<p>' . esc_html($item) . '</p>';
        }
        echo '</div></div>';
    }
}
?>
<!-- file: business-directory/single_content.tpl.php-->
<article id="post-<?php the_ID(); ?>" <?php post_class(grid12); ?>>
    <header class="header">

        <div class="name-inst-year">
            <div class="edp-wpbdp-name"><?php echo $fields->name->raw; ?></div>
            <div class="wpbdp-year-inst-block">

                <?php echo $fields->institution->raw[0]; ?><br />
                <?php echo $fields->year->raw; ?>

            </div>
        </div>
        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>

        <?php echo $fields->subtitle->html; ?>
    </header>




    <div class="meta-slice">
        <div class="meta-img-l"></div>

        <div class="edp-thesis-meta">
            <div class="wpbdp-metadata-block">
                <?php edp_render_meta_field_array($fields, 'methodology', 'Methodology'); ?>
                <?php edp_render_meta_field_array($fields, 'participants', 'Participants'); ?>
                <?php edp_render_meta_field_array($fields, 'data_collection', 'Data collection'); ?>
                <?php edp_render_meta_field_array($fields, 'data_analysis', 'Data analysis'); ?>
                <?php if ($fields->full_text_thesis->html > "" | $fields->published_paper->html > "" | $fields->blog__news_story->html > "" | $fields->website->html > ""): ?>
                    <div class="wpbdp-further-reading-block">
                        <div class="wpbdp-field-display">
                            <span class="field-label">Further reading</span>
                            <div class="value">
                            <?php endif; ?>

                            <?php if ($fields->full_text_thesis->html > ""): ?>

                                <p> <a href="<?php echo $fields->full_text_thesis->raw[0]; ?>">Full text
                                        thesis</a>


                                <?php endif; ?>
                                <?php if ($fields->published_paper->html > ""): ?>
                                <p>
                                    <a href="<?php echo $fields->published_paper->raw[0]; ?>">Published paper</a>
                                </p>

                            <?php endif; ?>

                            <?php if ($fields->blog__news_story->html > ""): ?>

                                <a href="<?php echo $fields->blog__news_story->raw[0]; ?>">Blog / news story</a>

                            <?php endif; ?>

                            <?php if ($fields->website->html > ""): ?>
                                <?php
                                $website_url = $fields->website->raw[0];
                                $website_label = isset($fields->website->raw[1]) && !empty($fields->website->raw[1])
                                    ? $fields->website->raw[1]
                                    : (parse_url($website_url)['host'] ?? '');
                                ?>
                                <p><a href="<?php echo esc_url($website_url); ?>">
                                        <?php echo esc_html($website_label); ?></a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="meta-img-r"></div>
    </div>

    <div class="entry-content" itemprop="mainContentOfPage">
        <?php if (has_post_thumbnail()) {
            the_post_thumbnail('full', array('itemprop' => 'image'));
        } ?>






        <div class="edp-thesis-abstract">
            <h2>Abstract</h2>
            <?php echo wpautop($fields->abstract->raw); ?>

        </div>

        <?php // echo $fields->html; ?>
        <?php if ($fields->share_email->value == 'Yes'): ?>
            <h3 class="wpbdp-contact"><a href="mailto:<?php echo $fields->email->raw; ?>">Email
                    <?php echo $fields->name->raw; ?></a></h3>

        <?php endif; ?>
        <div class="entry-links"><?php wp_link_pages(); ?></div>
    </div>
</article>
<!-- file end: business-directory/single_content.tpl.php-->