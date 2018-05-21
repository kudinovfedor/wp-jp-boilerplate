<?php get_header(); ?>

<main class="main">

    <div class="container">

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('template-parts/page/content', 'page'); ?>

            <?php endwhile; ?>

        <?php else : ?>

            <h1><?php _e('Nothing Found', 'joompress'); ?></h1>
            <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'joompress'); ?></p>

        <?php endif; ?>

    </div>

</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
