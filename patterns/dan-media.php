<?php
/**
 * Pattern: Dan — Media Coverage
 *
 * Light background. Top row: heading block (left) + prev/next carousel nav (right).
 * 3-column article card grid. Logo strip below with border-top.
 *
 * ACF fields: dan_media_eyebrow, dan_media_heading, dan_media_subheading,
 *             dan_media_articles (repeater: article_outlet, article_headline, article_image, article_url),
 *             dan_media_logos (repeater: logo_image)
 */

$eyebrow = get_field('dan_media_eyebrow');
$heading = get_field('dan_media_heading');
$subheading = get_field('dan_media_subheading');
$articles = get_field('dan_media_articles');
$logos = get_field('dan_media_logos');
?>
<section class="dan-media edp-fullwidth" aria-label="Media coverage">
    <div class="dan-inner">

        <div class="dan-media__top">
            <div class="dan-media__top-left">
                <?php if ($eyebrow): ?>
                    <p class="dan-media__eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <?php if ($heading): ?>
                    <h2 class="dan-media__heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading): ?>
                    <p class="dan-media__subheading"><?php echo wp_kses_post($subheading); ?></p>
                <?php endif; ?>
            </div>

            <?php if ($articles && count($articles) > 3): ?>
                <div class="dan-media__nav" aria-label="Article carousel navigation">
                    <button class="dan-media__nav-btn" aria-label="Previous articles"
                        data-carousel-prev="dan-media-carousel">
                        <i class="far fa-arrow-left" aria-hidden="true"></i>
                    </button>
                    <button class="dan-media__nav-btn" aria-label="Next articles" data-carousel-next="dan-media-carousel">
                        <i class="far fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </div>
            <?php endif; ?>
        </div><!-- .dan-media__top -->

        <?php if ($articles): ?>
            <div class="dan-media__cards" id="dan-media-carousel">
                <?php foreach (array_slice($articles, 0, 3) as $article):
                    $img = isset($article['article_image']) ? $article['article_image'] : null;
                    $url = isset($article['article_url']) ? $article['article_url'] : '';
                    ?>


                    <article class="type-post">
                        <a href="<?php echo esc_url($url); ?>" rel="bookmark">
                            <div class="archive-article-img">
                                <?php if ($img): ?>
                                    <div class="article-item--image">
                                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>"
                                            class="dan-media__card-img" loading="lazy" />
                                    </div>
                                <?php endif; ?>
                            </div>


                            <?php if ($article['article_headline']): ?>
                                <h2 class="entry-title">
                                    <?php echo esc_html($article['article_headline']); ?>
                                </h2>
                            <?php endif; ?>
                            <?php if ($article['article_outlet']): ?>
                                <p class="dan-media__card-outlet">
                                    <?php echo esc_html($article['article_outlet']); ?>
                                </p>
                            <?php endif; ?>

                        </a>

                        </header>
                    </article>





                <?php endforeach; ?>
            </div><!-- .dan-media__cards -->
        <?php endif; ?>

        <?php if ($logos): ?>
            <div class="dan-media__logos" aria-label="Featured in">
                <?php foreach ($logos as $logo):
                    $img = isset($logo['logo_image']) ? $logo['logo_image'] : null;
                    if (!$img)
                        continue;
                    ?>
                    <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>"
                        class="dan-media__logo-item" loading="lazy" />
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div><!-- .dan-inner -->
</section><!-- .dan-media -->