<?php
/**
 * Pattern: Dan — Hero
 *
 * Full-width dark background section with Dan's name, roles, bio,
 * credential badges, portrait photo, and decorative illustration.
 *
 * Decorative illustration (top-right corner):
 *   Uses the ACF field dan_header_illustration if set.
 *   Fallback placeholder: <!-- dan-illustration: header-top-right -->
 *   Suggested asset from theme: images/edpsy-swirls-16-rh.svg or edpsy-swirls-21.svg
 *
 * ACF fields: dan_name, dan_roles, dan_bio_lead, dan_bio_sub,
 *             dan_credentials, dan_portrait, dan_header_illustration
 */

$name            = get_field( 'dan_name' );
$roles           = get_field( 'dan_roles' );
$bio_lead        = get_field( 'dan_bio_lead' );
$bio_sub         = get_field( 'dan_bio_sub' );
$credentials     = get_field( 'dan_credentials' );
$portrait        = get_field( 'dan_portrait' );
$header_illus    = get_field( 'dan_header_illustration' );
?>
<section class="dan-hero" aria-label="Introduction">

    <?php if ( $header_illus ) : ?>
        <img
            src="<?php echo esc_url( $header_illus['url'] ); ?>"
            alt=""
            class="dan-hero__illustration"
            aria-hidden="true"
        />
    <?php else : ?>
        <img
            src="<?php echo esc_url( get_template_directory_uri() . '/images/edpsy-swirls-21.svg' ); ?>"
            alt=""
            class="dan-hero__illustration"
            aria-hidden="true"
        />
    <?php endif; ?>

    <div class="dan-hero__left">

        <?php if ( $name ) : ?>
            <h1 class="dan-hero__name"><?php echo esc_html( $name ); ?></h1>
        <?php endif; ?>

        <?php if ( $roles ) : ?>
            <div class="dan-hero__roles" aria-label="Roles">
                <?php foreach ( $roles as $role ) : ?>
                    <p class="dan-hero__role-item">
                        <span class="dan-hero__role-title"><?php echo esc_html( $role['role_title'] ); ?>,</span>
                        <span class="dan-hero__role-org"><?php echo esc_html( $role['role_org'] ); ?></span>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $bio_lead ) : ?>
            <p class="dan-hero__bio-lead"><?php echo wp_kses_post( $bio_lead ); ?></p>
        <?php endif; ?>

        <?php if ( $bio_sub ) : ?>
            <p class="dan-hero__bio-sub"><?php echo wp_kses_post( $bio_sub ); ?></p>
        <?php endif; ?>

        <?php if ( $credentials ) : ?>
            <div class="dan-hero__credentials" aria-label="Credentials">
                <?php foreach ( $credentials as $cred ) : ?>
                    <span class="dan-hero__badge"><?php echo esc_html( $cred['credential_label'] ); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div><!-- .dan-hero__left -->

    <?php if ( $portrait ) : ?>
        <div class="dan-hero__right">
            <img
                src="<?php echo esc_url( $portrait['url'] ); ?>"
                alt="<?php echo esc_attr( $portrait['alt'] ); ?>"
                class="dan-hero__portrait"
            />
        </div>
    <?php endif; ?>

</section><!-- .dan-hero -->
