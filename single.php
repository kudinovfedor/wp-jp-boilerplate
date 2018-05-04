<?php get_header(); ?>

<?php if (have_posts()) : ?>

  <main class="main">

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part('template-parts/post/content', get_post_format()); ?>

    <?php endwhile; ?>

  </main>

<?php else : ?>

  <h1><?php _e('Nothing Found', 'joompress'); ?></h1>
  <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'joompress'); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
