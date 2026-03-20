<?php
/**
 * Pattern: Dan — Podcast
 *
 * Light background. Upper row: podcast artwork + info (eyebrow, heading, description, stats).
 * A border-bottom separates the upper row from the featured episodes list.
 *
 * ACF fields: dan_podcast_eyebrow, dan_podcast_heading, dan_podcast_description,
 *             dan_podcast_artwork, dan_podcast_stats (repeater: stat_number, stat_label),
 *             dan_podcast_episodes (repeater: ep_ref, ep_title, ep_url,
 *               ep_platforms (repeater: platform_image, platform_url))
 */

$eyebrow     = get_field( 'dan_podcast_eyebrow' );
$heading     = get_field( 'dan_podcast_heading' );
$description = get_field( 'dan_podcast_description' );
$artwork     = get_field( 'dan_podcast_artwork' );
$stats       = get_field( 'dan_podcast_stats' );
$episodes    = get_field( 'dan_podcast_episodes' );
?>
<section class="dan-podcast" aria-label="Podcast">
<div class="dan-inner">

    <div class="dan-podcast__upper">

        <?php if ( $artwork ) : ?>
            <img
                src="<?php echo esc_url( $artwork['url'] ); ?>"
                alt="<?php echo esc_attr( $artwork['alt'] ); ?>"
                class="dan-podcast__artwork"
                loading="lazy"
            />
        <?php endif; ?>

        <div class="dan-podcast__info">
            <?php if ( $eyebrow ) : ?>
                <p class="dan-podcast__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $heading ) : ?>
                <h2 class="dan-podcast__heading"><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>
            <?php if ( $description ) : ?>
                <p class="dan-podcast__description"><?php echo wp_kses_post( $description ); ?></p>
            <?php endif; ?>

            <?php if ( $stats ) : ?>
                <div class="dan-podcast__stats" aria-label="Podcast statistics">
                    <?php foreach ( $stats as $stat ) : ?>
                        <div class="dan-podcast__stat">
                            <?php if ( $stat['stat_number'] ) : ?>
                                <p class="dan-podcast__stat-number"><?php echo esc_html( $stat['stat_number'] ); ?></p>
                            <?php endif; ?>
                            <?php if ( $stat['stat_label'] ) : ?>
                                <p class="dan-podcast__stat-label"><?php echo esc_html( $stat['stat_label'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div><!-- .dan-podcast__info -->

    </div><!-- .dan-podcast__upper -->

    <?php if ( $episodes ) : ?>
        <div class="dan-podcast__lower">
            <h3 class="dan-podcast__episodes-heading">Featured episodes</h3>
            <div class="dan-podcast__episode-list" role="list">
                <?php foreach ( $episodes as $episode ) :
                    $platforms = isset( $episode['ep_platforms'] ) ? $episode['ep_platforms'] : array();
                ?>
                    <div class="dan-podcast__episode" role="listitem">
                        <p class="dan-podcast__ep-title">
                            <?php if ( $episode['ep_ref'] ) : ?>
                                <span class="dan-podcast__ep-ref"><?php echo esc_html( $episode['ep_ref'] ); ?></span>
                            <?php endif; ?>
                            <?php if ( $episode['ep_url'] ) : ?>
                                <a href="<?php echo esc_url( $episode['ep_url'] ); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php echo esc_html( $episode['ep_title'] ); ?>
                                </a>
                            <?php else : ?>
                                <?php echo esc_html( $episode['ep_title'] ); ?>
                            <?php endif; ?>
                        </p>

                        <?php if ( $platforms ) : ?>
                            <div class="dan-podcast__ep-platforms" aria-label="Listen on">
                                <?php foreach ( $platforms as $platform ) :
                                    $pimg = isset( $platform['platform_image'] ) ? $platform['platform_image'] : null;
                                    $purl = isset( $platform['platform_url'] ) ? $platform['platform_url'] : '';
                                    if ( ! $pimg ) continue;
                                ?>
                                    <?php if ( $purl ) : ?>
                                        <a
                                            href="<?php echo esc_url( $purl ); ?>"
                                            class="dan-podcast__platform-link"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            aria-label="<?php echo esc_attr( $pimg['alt'] ); ?>"
                                        >
                                    <?php endif; ?>
                                        <img
                                            src="<?php echo esc_url( $pimg['url'] ); ?>"
                                            alt="<?php echo esc_attr( $pimg['alt'] ); ?>"
                                            class="dan-podcast__platform-img"
                                            loading="lazy"
                                        />
                                    <?php if ( $purl ) : ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div><!-- .dan-podcast__episode -->
                <?php endforeach; ?>
            </div><!-- .dan-podcast__episode-list -->
        </div>
    <?php endif; ?>

</div><!-- .dan-inner -->
</section><!-- .dan-podcast -->
