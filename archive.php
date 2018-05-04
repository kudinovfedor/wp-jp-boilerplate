<?php get_header(); ?>

<?php if (have_posts()) : ?>

  <article>
    <h1><?php the_archive_title(); ?></h1>
    <p><?php the_archive_description(); ?></p>
  </article>

  <?php while (have_posts()) : the_post(); ?>

    <section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

      <h1><?php the_title(); ?></h1>

      <?php if (has_post_thumbnail()) : ?>

        <div class=""></div>

      <?php endif; ?>

      <?php the_content(); ?>

    </section>

  <?php endwhile; ?>

  <?php the_posts_pagination(); ?>

<?php else : ?>

  <h1><?php _e('Nothing Found', 'joompress'); ?></h1>
  <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'joompress'); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
