<?php $image = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Article",
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
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h1><?php the_title(); ?></h1>

    <p>
        <time datetime="<?php echo get_the_date( 'c' ); ?>"><?php the_date( 'd.m.Y' ) ?></time>
    </p>

    <?php if (has_post_thumbnail()) { ?>
        <figure><?php the_post_thumbnail('post-thumbnail'); ?></figure>
    <?php } ?>

    <div><?php the_content(); ?></div>

</article>
