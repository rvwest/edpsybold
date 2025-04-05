<?php
/**
 * Template listing excerpt view.
 *
 * @package BDP/Templates/Excerpt
 */

$__template__ = array( 'blocks' => array( 'before', 'after' ) );
?>
<div class="<?php echo esc_attr( $listing_css_class ); ?>">
<a href="<?php the_permalink() ?>" id="<?php echo esc_attr( $listing_css_id ); ?>" >

	
		<?php
	echo $blocks['before'];
	
	if ( in_array( 'excerpt', wpbdp_get_option( 'display-sticky-badge' ) ) ) {
		echo $sticky_tag;
	}?>


	<?php wpbdp_x_part( 'excerpt_content' ); ?>
<!-- ?php	echo $blocks['after'];

	echo wpbdp_the_listing_actions();
	?-->

</a>
</div>
