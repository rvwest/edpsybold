<?php
/**
 * Pattern: Dan — Working Together (Collaborations)
 *
 * Light background. Heading at top-left (341px). Then a 3-column grid of
 * collaboration cards. Each card: logo, role label, title, description.
 *
 * ACF fields: dan_collab_eyebrow, dan_collab_heading,
 *             dan_collabs (repeater: collab_logo, collab_role, collab_title, collab_description)
 */

$eyebrow = get_field( 'dan_collab_eyebrow' );
$heading = get_field( 'dan_collab_heading' );
$collabs = get_field( 'dan_collabs' );
?>
<section class="dan-collabs" aria-label="Working together">
<div class="dan-inner">

    <div class="dan-collabs__header">
        <?php if ( $eyebrow ) : ?>
            <p class="dan-collabs__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
        <?php endif; ?>
        <?php if ( $heading ) : ?>
            <h2 class="dan-collabs__heading"><?php echo esc_html( $heading ); ?></h2>
        <?php endif; ?>
    </div>

    <?php if ( $collabs ) : ?>
        <div class="dan-collabs__grid">
            <?php foreach ( $collabs as $collab ) :
                $logo = isset( $collab['collab_logo'] ) ? $collab['collab_logo'] : null;
            ?>
                <div class="dan-collab-card">
                    <?php if ( $logo ) : ?>
                        <img
                            src="<?php echo esc_url( $logo['url'] ); ?>"
                            alt="<?php echo esc_attr( $logo['alt'] ); ?>"
                            class="dan-collab-card__logo"
                            loading="lazy"
                        />
                    <?php endif; ?>
                    <div class="dan-collab-card__body">
                        <?php if ( $collab['collab_role'] ) : ?>
                            <p class="dan-collab-card__role"><?php echo esc_html( $collab['collab_role'] ); ?></p>
                        <?php endif; ?>
                        <?php if ( $collab['collab_title'] ) : ?>
                            <h3 class="dan-collab-card__title"><?php echo esc_html( $collab['collab_title'] ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $collab['collab_description'] ) : ?>
                            <p class="dan-collab-card__desc"><?php echo wp_kses_post( $collab['collab_description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div><!-- .dan-collab-card -->
            <?php endforeach; ?>
        </div><!-- .dan-collabs__grid -->
    <?php endif; ?>

</div><!-- .dan-inner -->
</section><!-- .dan-collabs -->
