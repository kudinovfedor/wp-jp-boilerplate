</div><!-- .wrapper -->

<footer class="footer" itemscope itemtype="http://schema.org/WPFooter">
    <div class="container">
        <?php get_template_part('template-parts/navigation/menu', 'footer'); ?>
        <div class="copyright text-center"><?php copyright(); ?></div>
    </div>
</footer>

<?php scroll_top(); ?>

<span class="blackout js-blackout"></span>

<div class="is-hide"><?php svg_sprite(); ?></div>

<?php wp_footer(); ?>

</body>
</html>
