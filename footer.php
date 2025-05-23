<!-- file: footer.php -->
</main>
</div>
<?php include get_template_directory() . '/signup.php'; ?>

<footer id="footer" role="contentinfo" class="edp-fullwidth">
    <div class="footer-container grid12">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/edpsy-logo-light.svg"
            alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="footer-logo" />
        <div id="copyright">
            &copy; <?php echo esc_html(date_i18n(__('Y', 'edpsybold'))); ?>
            <?php echo esc_html(get_bloginfo('name')); ?>
        </div>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>

</html>
<!-- file end: footer.php -->