    </div><!-- /END WRAPPER -->

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <?php get_template_part('template-parts/navigation/menu', 'footer'); ?>
            <div class="copyright text-center"><?php copyright(); ?></div>
        </div>
    </footer>
    <!-- /END FOOTER -->

    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WPFooter",
            "copyrightYear": "<?php echo date('Y'); ?>",
            "copyrightHolder": "<?php bloginfo('name'); ?>"
        }
    </script>

    <?php scroll_top(); ?>

    <span class="blackout js-blackout"></span>

    <div class="is-hide"><?php svg_sprite(); ?></div>

    <?php //get_template_part('template-parts/cookie-consent'); ?>

    <?php wp_footer(); ?>

    </body>
</html>
