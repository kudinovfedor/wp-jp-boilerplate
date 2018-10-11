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
<article id="post-<?php the_ID(); ?>" <?php post_class('col-sm-6 col-md-4'); ?>>
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

    <div><?php the_excerpt(); ?></div>

    <p>
        <a class="btn btn-default btn-sm" href="<?php the_permalink(); ?>"><?php _e('Read more', 'joompress'); ?></a>
    </p>

</article>
