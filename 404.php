<?php get_header(); ?>

<article>
  <h1><?php _e('Oops! That page can&rsquo;t be found.', 'joompress'); ?></h1>
  <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'joompress'); ?></p>
  <?php get_search_form(); ?>
</article>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
