<?php get_header(); ?>

<?php //echo __FILE__; ?>

<?php if(have_posts()) : ?>

  <main id="content" class="main container" itemscope itemtype="http://schema.org/Blog">
    <meta itemprop="description" content="<?php bloginfo('description'); ?>">

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part('template-parts/archive/content', get_post_format()); ?>

    <?php endwhile; ?>

  </main>

<?php else : ?>

  <p><?php _e('', 'joompress'); ?></p>

<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
