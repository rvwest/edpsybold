<?php
/** 
 * Listing detail view rendering template 
 * 
 * @package BDP/Templates/Single Content 
 */

function edp_render_meta_field_array($fields, $field_key, $label)
{
    if (isset($fields->{$field_key}) && isset($fields->{$field_key}->raw) && is_array($fields->{$field_key}->raw) && !empty($fields->{$field_key}->raw)) {
        echo '<div class="wpbdp-field-display"><span class="field-label">' . esc_html($label) . '</span><div class="value">';
        foreach ($fields->{$field_key}->raw as $item) {
            if ($item !== '' && $item !== null) {
                echo '<p>' . esc_html($item) . '</p>';
            }
        }
        echo '</div></div>';
    }
}
?>
<!-- file: business-directory/single_content.tpl.php-->
<article <?php post_class('grid12'); ?> id="post-<?php the_ID(); ?>">
    <header class="header">

        <div class="name-inst-year">
            <div class="edp-wpbdp-name"><?php echo isset($fields->name->raw) ? esc_html($fields->name->raw) : ''; ?>
            </div>
            <div class="wpbdp-year-inst-block">
                <?php if (!empty($fields->institution->raw[0])): ?>
                    <?php echo esc_html($fields->institution->raw[0]); ?><br />
                <?php endif; ?>
                <?php if (!empty($fields->year->raw)): ?>
                    <?php echo esc_html($fields->year->raw); ?>
                <?php endif; ?>
            </div>
        </div>
        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>

        <?php if (!empty($fields->subtitle->html)) {
            echo $fields->subtitle->html;
        } ?>
    </header>




    <div class="meta-slice">
        <div class="meta-img-l"></div>

        <div class="edp-thesis-meta">
            <div class="wpbdp-metadata-block">
                <?php edp_render_meta_field_array($fields, 'methodology', 'Methodology'); ?>
                <?php edp_render_meta_field_array($fields, 'participants', 'Participants'); ?>
                <?php edp_render_meta_field_array($fields, 'data_collection', 'Data collection'); ?>
                <?php edp_render_meta_field_array($fields, 'data_analysis', 'Data analysis'); ?>
                <?php
                $has_full = !empty($fields->full_text_thesis->raw[0] ?? '');
                $has_paper = !empty($fields->published_paper->raw[0] ?? '');
                $has_blog = !empty($fields->blog__news_story->raw[0] ?? '');
                $has_site = !empty($fields->website->raw[0] ?? '');
                $has_any = $has_full || $has_paper || $has_blog || $has_site;
                ?>
                <?php if ($has_any): ?>
                    <div class="wpbdp-further-reading-block">
                        <div class="wpbdp-field-display">
                            <span class="field-label">Further reading</span>
                            <div class="value">
                                <?php if ($has_full): ?>
                                    <p><a href="<?php echo esc_url($fields->full_text_thesis->raw[0]); ?>">Full text thesis</a>
                                    </p>
                                <?php endif; ?>

                                <?php if ($has_paper): ?>
                                    <p><a href="<?php echo esc_url($fields->published_paper->raw[0]); ?>">Published paper</a>
                                    </p>
                                <?php endif; ?>

                                <?php if ($has_blog): ?>
                                    <p><a href="<?php echo esc_url($fields->blog__news_story->raw[0]); ?>">Blog / news story</a>
                                    </p>
                                <?php endif; ?>

                                <?php if ($has_site): ?>
                                    <?php
                                    $website_url = $fields->website->raw[0];
                                    $website_label = isset($fields->website->raw[1]) && !empty($fields->website->raw[1])
                                        ? $fields->website->raw[1]
                                        : (parse_url($website_url)['host'] ?? 'Website');
                                    ?>
                                    <p><a
                                            href="<?php echo esc_url($website_url); ?>"><?php echo esc_html($website_label); ?></a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
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
            <?php if (!empty($fields->abstract->raw)) {
                echo wpautop($fields->abstract->raw);
            } ?>

        </div>

        <?php // echo $fields->html; ?>
        <?php if (!empty($fields->share_email->value) && strtolower($fields->share_email->value) === 'yes' && !empty($fields->email->raw)): ?>
            <h3 class="wpbdp-contact"><a href="mailto:<?php echo esc_attr($fields->email->raw); ?>">Email
                    <?php echo isset($fields->name->raw) ? esc_html($fields->name->raw) : ''; ?></a></h3>
        <?php endif; ?>
        <div class="entry-links"><?php wp_link_pages(); ?></div>
    </div>
</article>
<!-- file end: business-directory/single_content.tpl.php-->