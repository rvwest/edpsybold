<?php
/**
 * Template: External Links Clicked card for WP Statistics single-post view.
 * Included by mytheme_wps_external_links_card() in functions.php.
 * Variables in scope: $results (array of stdClass), $sql (string), $total_clicks (int).
 */

if (defined('WP_DEBUG') && WP_DEBUG && empty($results)) {
    echo '<!-- mytheme_wps_external_links_card SQL: ' . esc_html($sql) . ' -->';
}
?>
<span id="mytheme-wps-ext-clicks-total" data-total="<?php echo esc_attr($total_clicks); ?>" hidden></span>
<div class="wps-card" id="mytheme-external-links-card">
    <div class="wps-card__title">
        <h2>
            <?php esc_html_e('External Links Clicked', 'edpsybold'); ?>
            <span class="wps-tooltip" title="<?php esc_attr_e('Outbound links clicked by visitors on this post during the selected date range.', 'edpsybold'); ?>">
                <i class="wps-tooltip-icon info"></i>
            </span>
        </h2>
    </div>
    <div class="inside">
        <?php if (empty($results)) : ?>
            <div class="o-wrap o-wrap--no-data wps-center">
                <?php esc_html_e('No external link clicks recorded for this period.', 'edpsybold'); ?>
            </div>
        <?php else : ?>
            <div class="o-table-wrapper">
                <table width="100%" class="o-table wps-new-table">
                    <thead>
                        <tr>
                            <th class="wps-pd-l"><?php esc_html_e('Link Text', 'edpsybold'); ?></th>
                            <th class="wps-pd-l"><?php esc_html_e('URL', 'edpsybold'); ?></th>
                            <th class="wps-pd-l"><?php esc_html_e('Clicks', 'edpsybold'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row) : ?>
                            <tr>
                                <td class="wps-pd-l"><?php echo esc_html(!empty($row->link_text) ? $row->link_text : '—'); ?></td>
                                <td class="wps-pd-l">
                                    <a href="<?php echo esc_url($row->url); ?>"
                                       title="<?php echo esc_attr($row->url); ?>"
                                       target="_blank" rel="noopener noreferrer">
                                        <?php echo esc_html($row->url); ?>
                                    </a>
                                </td>
                                <td class="wps-pd-l"><?php echo esc_html($row->clicks); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
