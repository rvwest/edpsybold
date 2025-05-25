<?php /** * Listing detail view rendering template * * @package BDP/Templates/Single Content */ ?>
<!-- file: business-directory/single_content.tpl.php-->
<article id="post-<?php the_ID(); ?>" <?php post_class(grid12); ?>>
    <header class="header">

        <div class="name-inst-year">
            <?php echo $fields->name->raw; ?>
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
                <?php echo $fields->methodology->html; ?>
                <?php echo $fields->participants->html; ?>
                <?php echo $fields->data_collection->html; ?>
                <?php echo $fields->data_analysis->html; ?>
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
                                $parsed_url = parse_url($website_url);

                                // Start with just the domain
                                $display_url = $parsed_url['host'] ?? '';

                                // Add first part of path, if available
                                if (!empty($parsed_url['path'])) {
                                    $path_parts = explode('/', trim($parsed_url['path'], '/'));
                                    if (!empty($path_parts[0])) {
                                        $display_url .= '/' . $path_parts[0] . '...';
                                    }
                                }
                                ?>
                                <p><a href="<?php echo $website_url; ?>">Website: <?php echo $display_url; ?></a></p>


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





    </div>
    <div class="edp-thesis-abstract">
        <h2>Abstract</h2>
        <?php echo wpautop($fields->abstract->raw); ?>

    </div>

    <?php // echo $fields->html; ?>
    <?php if ($fields->share_email->value == 'Yes'): ?>
        <h2 class="wpbdp-contact">Contact <?php echo $fields->name->raw; ?></h2>
        <?php echo $fields->email->html; ?>
    <?php endif; ?>


    <div class="entry-links"><?php wp_link_pages(); ?></div>
    </>
</article>
<!-- file end: business-directory/single_content.tpl.php-->