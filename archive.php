<?php get_header(); ?>

<main class="main">

    <article class="container">

        <?php if (have_posts()) : ?>

            <?php the_archive_title('<h1 class="text-center">', '</h1>'); ?>
            <?php the_archive_description('<p class="text-center">', '</p>'); ?>

            <div class="row">

                <?php while (have_posts()) : the_post(); ?>

                    <section id="post-<?php the_ID(); ?>" <?php post_class('col-md-4'); ?>>

                        <h2>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } ?>

                        <?php the_excerpt(); ?>

                        <a class="btn btn-default btn-sm" href="<?php the_permalink(); ?>"><?php _e('Read more'); ?></a>

                    </section>

                <?php endwhile; ?>

            </div>

            <?php the_posts_pagination(); ?>

        <?php else : ?>

            <h1><?php _e('Nothing Found', 'joompress'); ?></h1>
            <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.',
                    'joompress'); ?></p>

        <?php endif; ?>

    </article>

</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
