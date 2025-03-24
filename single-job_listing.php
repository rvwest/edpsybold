<?php
/**
 * The Template for displaying all single job posts.
 */

get_header(); ?>

<?php if (have_posts()):
	while (have_posts()):
		the_post(); ?>
		<?php get_template_part('entry'); ?>
		<?php if (comments_open() && !post_password_required()) {
			comments_template('', true);
		} ?>
	<?php endwhile; endif; ?>
<footer class="footer">
	<?php get_template_part('nav', 'below-single'); ?>
</footer>
<?php get_footer(); ?>

<div class="job-page edp-single-job-post main-wrapper-item category-<?php foreach (get_the_category() as $cat) {
	echo $cat->slug . '  ';
} ?>">
	<?php if (have_posts()): ?>
		<?php while (have_posts()):
			the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">

				<div class="container post-wrap">
					<div class="row-fluid">
						<div id="container" class="span10 center-col">
							<div class="title-sub-logo">
								<div class=" span10 center-col no-gutter-l">
									<?php $logo = get_the_company_logo($post, $size); ?>
									<?php if (has_post_thumbnail($post)): ?>
										<?php the_company_logo(); ?>
									<?php endif; ?>
									<h1 class="title "><?php the_title(); ?></h1>
									<h2 class="name">
										<?php if ($website = get_the_company_website()): ?>
											<a class="company-name"
												href="<?php echo esc_url($website); ?>"><?php the_company_name(); ?></a>
										<?php else: ?>
											<?php the_company_name(); ?>
										<?php endif; ?>
									</h2>

								</div>


							</div>



							<!-- skepost-meta -->
							<div id="container" class="span10 center-col">
								<div id="content">
									<div class="skepost clearfix">
										<?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'advertica-lite')); ?>
										<?php wp_link_pages(array('before' => '<p><strong>' . __('Pages :', 'advertica-lite') . '</strong>', 'after' => '</p>', __('number', 'advertica-lite'), )); ?>





									</div>
									<!-- skepost -->

									<div class="wpjm-submit-block ">
										<a href="/jobs" class="button secondary see-all-jobs">See all jobs</a>
									</div>
									<div class="clearfix"></div>
									<br />
									<?php if (is_active_sidebar('post_cta_2')): ?>
										<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
											<?php dynamic_sidebar('post_cta_2'); ?>
										</div><!-- #primary-sidebar -->
									<?php endif; ?>

								</div>
								<p class="body-footnote"><i class="fad fa-check"></i> We follow the <a
										href="https://www.asa.org.uk/type/non_broadcast/code_section/20.html">CAP Code for
										employment ads</a>.</p>
								<!-- post -->
							<?php endwhile; ?>
						<?php else: ?>

							<div class="post">
								<h2><?php _e('Post Does Not Exist', 'advertica-lite'); ?></h2>
							</div>
						<?php endif; ?>
					</div><!-- content -->

				</div>


			</div><!-- container -->



		</div>
	</div>
</div>
</div>
<?php get_footer(); ?>