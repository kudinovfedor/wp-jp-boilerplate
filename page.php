<?php get_header(); ?>

<main class="main">

    <div class="container">

        <?php while (have_posts()) : the_post(); ?>

            <?php get_template_part('template-parts/page/content', 'page'); ?>

            <?php if (comments_open() || get_comments_number()) {
                comments_template();
            } ?>

            <?php wp_link_pages(array(
                'before'           => '<p>' . __('Pages:', 'joompress'),
                'after'            => '</p>',
                'nextpagelink'     => __('Next page', 'joompress'),
                'previouspagelink' => __('Previous page', 'joompress'),
            )); ?>

        <?php endwhile; ?>

    </div>

</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
