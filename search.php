<?php get_header(); ?>

<section class="container">

    <?php if (have_posts()) : ?>

        <h1><?php printf(__('Search Results for: %s', 'joompress'), '<span>' . get_search_query() . '</span>'); ?></h1>

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <h2><?php the_title(); ?></h2>
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('post-thumbnail');
                } ?>
                <?php the_excerpt(); ?>

            </article>

        <?php endwhile; ?>

        <?php the_posts_pagination(); ?>

    <?php else : ?>

        <h1><?php _e('Nothing Found', 'joompress'); ?></h1>
        <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.',
                'joompress'); ?></p>
        <?php get_search_form(); ?>

    <?php endif; ?>

</section>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
