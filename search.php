<?php get_header(); ?>

<main class="main">

    <article class="container">

        <?php if (have_posts()) : ?>

            <h1 class="text-center">
                <?php printf(__('Search Results for: %s', 'joompress'), '<span>' . get_search_query() . '</span>'); ?>
            </h1>

            <div class="row">

                <?php while (have_posts()) : the_post(); ?>

                    <section id="post-<?php the_ID(); ?>" <?php post_class('col-md-4'); ?>>

                        <h2>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <?php if (has_post_thumbnail()) { ?>
                            <figure><?php the_post_thumbnail('medium'); ?></figure>
                        <?php } ?>

                        <?php the_excerpt(); ?>

                        <p>
                            <a class="btn btn-default btn-sm" href="<?php the_permalink(); ?>"><?php _e('Read more', 'joompress'); ?></a>
                        </p>

                    </section>

                <?php endwhile; ?>

            </div>

            <?php the_posts_pagination(); ?>

        <?php else : ?>

            <h1><?php _e('Nothing Found', 'joompress'); ?></h1>
            <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.',
                    'joompress'); ?></p>
            <?php get_search_form(); ?>

        <?php endif; ?>

    </article>

</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
