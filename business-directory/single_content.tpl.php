<?php /** * Listing detail view rendering template * * @package BDP/Templates/Single Content */ ?>
<!-- file: business-directory/single_content.tpl.php-->
<article id="post-<?php the_ID(); ?>" <?php post_class(grid12); ?>>
    <header class="header">
        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>

        <?php echo $fields->subtitle->html; ?>
        <div class="name-inst-year">
            <?php echo $fields->name->raw; ?>
            <div class="wpbdp-year-inst-block">

                <?php echo $fields->institution->raw[0]; ?><br />
                <?php echo $fields->year->raw; ?>

            </div>
        </div>
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

                        <?php endif; ?>

                        <?php if ($fields->full_text_thesis->html > ""): ?>

                            <div class="value"><a href="<?php echo $fields->full_text_thesis->raw[0]; ?>">Full text
                                    thesis</a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($fields->published_paper->html > ""): ?>
                        <li>
                            <a href="<?php echo $fields->published_paper->raw[0]; ?>">Published paper</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($fields->blog__news_story->html > ""): ?>
                        <li>
                            <a href="<?php echo $fields->blog__news_story->raw[0]; ?>">Blog / news story</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($fields->website->html > ""): ?>
                        <li>
                            <?php echo $fields->website->html; ?>
                        </li>

                    <?php endif; ?>
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