<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4'); ?>
         itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

    <meta itemscope itemprop="mainEntityOfPage"
          itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>" content="<?php the_title(); ?>">

    <meta itemprop="dateModified" content="<?php the_modified_date('c'); ?>">

    <?php /*
    <div itemprop="articleBody"><?php the_content(); ?></div>
    */ ?>

    <meta itemprop="author" content="<?php the_author(); ?>">

    <meta itemprop="image" content="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium')[0]; ?>">

    <h2 itemprop="headline">
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>

    <time itemprop="datePublished" datetime="<?php the_time('c'); ?>"><?php the_time('d.m.Y'); ?></time>

    <span itemprop="articleSection"><?php the_category(','); ?></span>

    <?php /*
    $id    = get_post_thumbnail_id(get_the_ID());
    $image = wp_get_attachment_image_src($id, 'medium');
    list($src, $width, $height) = $image;
    $alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
    ?>

    <?php if (has_post_thumbnail()) {
        //the_post_thumbnail('medium');
        ?>
        <figure itemscope itemtype="https://schema.org/ImageObject">
            <img itemprop="image" alt="<?php echo $alt; ?>" src=<?php echo $src; ?>>
            <meta itemprop="width" content="<?php echo $width; ?>">
            <meta itemprop="height" content="<?php echo $height; ?>">
            <?php if ( ! empty($alt)) { ?>
                <figcaption class="screen-reader-text" itemprop="caption"><?php echo $alt; ?></figcaption>
            <?php } ?>
        </figure>
    <?php } */?>

    <div itemprop="description"><?php the_excerpt(); ?></div>

    <a class="btn btn-default btn-sm" href="<?php the_permalink(); ?>"><?php _e('Read more'); ?></a>

</article>
