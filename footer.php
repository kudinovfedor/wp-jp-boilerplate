</div><!-- .wrapper -->

<footer class="footer" itemscope itemtype="http://schema.org/WPFooter">
    <div class="container">
        <?php get_template_part('template-parts/navigation/menu', 'footer'); ?>
        <div class="copyright text-center"><?php copyright(); ?></div>
    </div>
</footer>

<?php scroll_top(); ?>

<?php if (is_customize_preview()) { ?>
    <button class="customizer-edit" data-control='{ "name":"jp_scroll_top_display" }'>
        <?php esc_html_e('Edit Scroll Top', 'joompress'); ?>
    </button>
    <button class="customizer-edit" data-control='{ "name":"jp_analytics_google_placed" }'>
        <?php esc_html_e('Edit Analytics Tracking Code', 'joompress'); ?>
    </button>
    <button class="customizer-edit" data-control='{ "name":"jp_login_logo" }'>
        <?php esc_html_e('Edit Login Logo', 'joompress'); ?>
    </button>
<?php } ?>

<span class="blackout js-blackout"></span>

<div class="is-hide"><?php svg_sprite(); ?></div>

<?php wp_footer(); ?>

</body>
</html>
