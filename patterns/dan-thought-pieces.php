<?php
/**
 * Pattern: Dan — Thought Pieces
 *
 * Same card layout as the Media Coverage section, but with green accent colour
 * for eyebrow and topic labels, plus a brief description below the card title.
 * "Read piece" link instead of "Read article".
 *
 * ACF fields: dan_thoughts_eyebrow, dan_thoughts_heading,
 *             dan_thoughts_articles (repeater: article_topic, article_title,
 *               article_description, article_image, article_url)
 */

$eyebrow  = get_field( 'dan_thoughts_eyebrow' );
$heading  = get_field( 'dan_thoughts_heading' );
$articles = get_field( 'dan_thoughts_articles' );
?>
<section class="dan-thoughts" aria-label="Thought pieces">

    <div class="dan-thoughts__top">
        <div class="dan-thoughts__top-left">
            <?php if ( $eyebrow ) : ?>
                <p class="dan-thoughts__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $heading ) : ?>
                <h2 class="dan-thoughts__heading"><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>
        </div>

        <?php if ( $articles && count( $articles ) > 3 ) : ?>
            <div class="dan-thoughts__nav" aria-label="Thought pieces carousel navigation">
                <button class="dan-thoughts__nav-btn" aria-label="Previous thought pieces" data-carousel-prev="dan-thoughts-carousel">
                    <i class="far fa-arrow-left" aria-hidden="true"></i>
                </button>
                <button class="dan-thoughts__nav-btn" aria-label="Next thought pieces" data-carousel-next="dan-thoughts-carousel">
                    <i class="far fa-arrow-right" aria-hidden="true"></i>
                </button>
            </div>
        <?php endif; ?>
    </div><!-- .dan-thoughts__top -->

    <?php if ( $articles ) : ?>
        <div class="dan-thoughts__cards" id="dan-thoughts-carousel">
            <?php foreach ( array_slice( $articles, 0, 3 ) as $article ) :
                $img = isset( $article['article_image'] ) ? $article['article_image'] : null;
                $url = isset( $article['article_url'] ) ? $article['article_url'] : '';
            ?>
                <article class="dan-thoughts__card">
                    <?php if ( $img ) : ?>
                        <img
                            src="<?php echo esc_url( $img['url'] ); ?>"
                            alt="<?php echo esc_attr( $img['alt'] ); ?>"
                            class="dan-thoughts__card-img"
                            loading="lazy"
                        />
                    <?php endif; ?>

                    <?php if ( ! empty( $article['article_topic'] ) ) : ?>
                        <p class="dan-thoughts__card-topic"><?php echo esc_html( $article['article_topic'] ); ?></p>
                    <?php endif; ?>

                    <?php if ( $article['article_title'] ) : ?>
                        <h3 class="dan-thoughts__card-title"><?php echo esc_html( $article['article_title'] ); ?></h3>
                    <?php endif; ?>

                    <?php if ( ! empty( $article['article_description'] ) ) : ?>
                        <p class="dan-thoughts__card-desc"><?php echo wp_kses_post( $article['article_description'] ); ?></p>
                    <?php endif; ?>

                    <?php if ( $url ) : ?>
                        <a
                            href="<?php echo esc_url( $url ); ?>"
                            class="dan-thoughts__card-link"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            Read piece <i class="far fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div><!-- .dan-thoughts__cards -->
    <?php endif; ?>

</section><!-- .dan-thoughts -->
