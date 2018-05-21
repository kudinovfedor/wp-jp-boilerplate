<?php get_header(); ?>

<main class="main">

    <div class="container">

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('template-parts/post/content', get_post_format()); ?>

            <?php endwhile; ?>

        <?php else : ?>

            <?php get_template_part('template-parts/post/content', 'none'); ?>

        <?php endif; ?>

    </div>

</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
