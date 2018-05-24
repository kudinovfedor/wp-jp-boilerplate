<?php get_header(); ?>

<main class="main">

    <article class="container">

        <?php if (have_posts()) : ?>

            <?php the_archive_title('<h1 class="text-center">', '</h1>'); ?>
            <?php the_archive_description('<p class="text-center">', '</p>'); ?>

            <div class="row">

                <?php while (have_posts()) : the_post(); ?>

                    <section id="post-<?php the_ID(); ?>" <?php post_class('col-sm-6 col-md-4'); ?>>

                        <?php edit_post_link(); ?>
                        <?php delete_post_link(); ?>

                        <h2>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <?php if (has_post_thumbnail()) { ?>
                            <figure><?php the_post_thumbnail('medium'); ?></figure>
                        <?php } ?>

                        <p>
                            <time datetime="<?php the_time('c'); ?>"><?php the_time('d.m.Y'); ?></time>
                            <br>
                            <span><?php _e('Categories', 'joompress'); ?>: <?php the_category(', '); ?></span>
                            <br>
                            <?php the_tags(sprintf('<span>%s: ', __('Tags', 'joompress')), ', ', '</span>'); ?>
                        </p>

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
            <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.',
                    'joompress'); ?></p>

            <?php get_search_form(); ?>

        <?php endif; ?>

    </article>

</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
