<?php get_header(); ?>

<main id="content" class="main">

    <div class="container">

        <?php if (have_posts()) : ?>

            <?php if (is_singular()) {

                while (have_posts()) : the_post();

                    get_template_part('template-parts/page/content', 'page');

                endwhile;

            } else { ?>

                <div itemscope itemtype="http://schema.org/Blog">
                    <meta itemprop="description" content="<?php bloginfo('description'); ?>">

                    <div class="row js-ajax-posts">

                        <?php while (have_posts()) : the_post(); ?>

                            <?php get_template_part('template-parts/archive/content', get_post_format()); ?>

                        <?php endwhile; ?>

                    </div>

                    <div class="text-center">
                        <?php jp_pagination(); ?>
                        <br>
                        <?php jp_load_more(); ?>
                    </div>
                </div>

            <?php } ?>

        <?php else : ?>

            <article>

                <h1><?php _e('Nothing Found', 'joompress'); ?></h1>
                <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.',
                        'joompress'); ?></p>

                <?php get_search_form(); ?>

            </article>

        <?php endif; ?>
    </div>

</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
