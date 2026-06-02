<?php
/**
 * Template Name: Dan O'Hare Profile
 * Description: Founder profile and media enquiries page for Dr Dan O'Hare.
 *
 * WordPress will also auto-select this template for any page with slug "dan"
 * via the page-{slug}.php template hierarchy. Assigning the "Dan O'Hare Profile"
 * template explicitly in the page editor is recommended so ACF fields are visible.
 */

get_header();

if ( ! function_exists( 'get_field' ) ) {
    // ACF not active — output a placeholder so the page is not blank
    echo '<p style="padding:2rem;">ACF is required for this page.</p>';
    get_footer();
    return;
}
?>

<?php get_template_part( 'patterns/dan-hero' ); ?>
<?php get_template_part( 'patterns/dan-stats' ); ?>
<?php get_template_part( 'patterns/dan-about' ); ?>
<?php get_template_part( 'patterns/dan-media' ); ?>
<?php get_template_part( 'patterns/dan-policy' ); ?>
<?php get_template_part( 'patterns/dan-podcast' ); ?>
<?php get_template_part( 'patterns/dan-talks' ); ?>
<?php get_template_part( 'patterns/dan-thought-pieces' ); ?>
<?php get_template_part( 'patterns/dan-collaborations' ); ?>
<?php get_template_part( 'patterns/dan-testimonials' ); ?>

<?php get_footer(); ?>
