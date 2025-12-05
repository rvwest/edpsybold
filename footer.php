<!-- file: footer.php -->
</main>
</div>
<?php include get_template_directory() . '/signup.php'; ?>

<footer id="footer" role="contentinfo" class="edp-fullwidth">
	<div class="footer-container">
		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/edpsy-logo-light.svg"
			alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="footer-logo" />

		<div class="footer-content">
			<p class="footer-social">
				<a href="/educated-guess-podcast" class="footer-bluesky-svg"><i class="fas fa-podcast"></i></a> |
				<a href="https://bsky.app/profile/edpsy.bsky.social" class="footer-bluesky-svg"><img
						src="<?php echo get_template_directory_uri(); ?>/images/bluesky.svg"
						class="footer-img-svg"></i></a> |
				<a href="https://www.facebook.com/edpsy.org.uk/"><i class="fab fa-facebook"></i></a> |
				<a href="https://www.linkedin.com/company/edpsy/about/"><i class="fab fa-linkedin"></i></a> |

				<!--<a href="https://threads.net/edpsyuk" style="vertical-align: middle;"><img height="22px"
								src="<?php echo get_template_directory_uri(); ?>/images/threads.svg"
								class="footer-img-svg"></a> |-->
				<a href="mailto:hello@edpsy.org.uk" class="footer-mail"><i class="fal fa-envelope"></i>
					hello@edpsy.org.uk</a>
			</p>

			<p class="footer-message"><a href="/community-guidelines">Community guidelines</a> <a
					href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Reusing our content</a> <a
					href="/cookies">Cookies and privacy</a></p>




		</div>
		<div class="footer-right">
			<a href="https://ecologi.com/edpsyltd" target="_blank" rel="noopener noreferrer"
				title="View our Ecologi profile">
				<img alt="We offset our carbon footprint via Ecologi"
					src="https://api.ecologi.com/badges/cpw/60292431878cf1001cb5ce58?white=true&landscape=true"
					style="width:100%;" class="footer-ecologi" />
			</a>
		</div>

	</div>
	<div class="footer-container footer-container--two">
		<div class="foot-legal">
			<div>edpsy ltd,
				<span>Piccadilly Business Centre, </span><span>Aldow Enterprise Park,</span><span>Manchester,
					England,
				</span><span>M12 6AE</span>
			</div>
			<div><span>Company number: 12669513</span> <span>(registered in England and Wales)</div>
		</div>
	</div>

</footer>
</div>
<?php wp_footer(); ?>
</body>

</html>
<!-- file end: footer.php -->