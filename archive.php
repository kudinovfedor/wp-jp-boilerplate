<?php get_header(); ?>

<main class="main">

    <article class="container">

        <?php if (have_posts()) : ?>

            <?php the_archive_title('<h1 class="text-center">', '</h1>'); ?>
            <?php the_archive_description('<p class="text-center">', '</p>'); ?>

            <div class="row js-ajax-posts" itemscope itemtype="http://schema.org/Blog">

                <?php while (have_posts()) : the_post(); ?>

                    <?php $image = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
                    <script type="application/ld+json">
                        {
                            "@context": "http://schema.org",
                            "@type": "BlogPosting",
                            "mainEntityOfPage": {
                                "@type": "WebPage",
                                "@id": "<?php the_permalink(); ?>"
                            },
                            "headline": "<?php the_title(); ?>",
                            "image": "<?php echo $image; ?>",
                            "datePublished": "<?php echo get_the_date('c'); ?>",
                            "dateModified": "<?php the_modified_date('c'); ?>",
                            "author": {
                                "@type": "Person",
                                "name": "<?php the_author(); ?>"
                            },
                            "publisher": {
                                "@type": "Organization",
                                "name": "<?php bloginfo('name'); ?>",
                                "logo": {
                                    "@type": "ImageObject",
                                    "url": "<?php echo get_logo_url(); ?>"
                                }
                            },
                            "articleSection": "<?php the_category(', '); ?>",
                            "description": "<?php the_excerpt(); ?>",
                            "articleBody": "<?php the_content(); ?>"
                        }
                    </script>

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
                            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d.m.Y'); ?></time>
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

            <div class="text-center">
                <?php jp_pagination(); ?>
                <br>
                <?php jp_load_more(); ?>
            </div>

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
