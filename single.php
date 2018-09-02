<?php get_header(); ?>

<main class="main">

    <div class="container">

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('template-parts/post/content', get_post_format()); ?>

                <?php if (comments_open() || get_comments_number()) {
                    comments_template();
                } ?>

                <?php the_post_navigation([
                    'prev_text' => __('Previous Post', 'joompress'),
                    'next_text' => __('Next Post', 'joompress'),
                ]); ?>

            <?php endwhile; ?>

        <?php else : ?>

            <?php get_template_part('template-parts/post/content', 'none'); ?>

        <?php endif; ?>

    </div>

</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
