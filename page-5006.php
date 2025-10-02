<?php
/**
 * Polish version
 * The template for displaying all pages.
 * 
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 */
get_header(); ?>
<!-- file: page-5006.php -->
<?php if (have_posts()):
	while (have_posts()):
		the_post(); ?>
		<?php if (is_singular('wpbdp_listing')): ?>
			<!-- var: post a jobs page -->
			<?php the_content(); ?>

		<?php else: ?>
			<!-- var: regular page -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> lang="pl">
				<header class="header">
					<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
					<?php edit_post_link(); ?>
					<?php get_page_promo(); ?>
				</header>
				<div class="entry-content" itemprop="mainContentOfPage">
					<?php if (has_post_thumbnail()) {
						the_post_thumbnail('full', array('itemprop' => 'image'));
					} ?>
					<?php the_content(); ?>
					<div class="entry-links"><?php wp_link_pages(); ?></div>
				</div>
			</article>
		<?php endif; ?>
	<?php endwhile; endif; ?>

<?php get_footer(); ?>
<!-- file end: page-5006.php -->