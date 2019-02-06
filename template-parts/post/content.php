<?php

$categories = get_the_terms(get_the_ID(), 'category');

$sections = [];

foreach ($categories as $category) {
    $sections[] = $category->name;
}

$section = esc_html(join(', ', $sections));
$image = esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full'));
?>
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
        "datePublished": "<?php the_date('c'); ?>",
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
        "articleSection": "<?php echo $section; ?>",
        "description": "<?php echo strip_tags(get_the_excerpt()); ?>"
    }
</script>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <h1><?php the_title(); ?></h1>

    <p>
        <time datetime="<?php echo get_the_date( 'c' ); ?>"><?php the_date( 'd.m.Y' ); ?></time>
        <span><?php _e('Categories', 'joompress'); ?>: <?php the_category(', '); ?></span>
        <?php the_tags(sprintf('<span>%s: ', __('Tags', 'joompress')), ', ', '</span>'); ?>
    </p>

    <?php if (has_post_thumbnail()) { ?>
        <figure><?php the_post_thumbnail('post-thumbnail'); ?></figure>
    <?php } ?>

    <div><?php the_content(); ?></div>

</article>
