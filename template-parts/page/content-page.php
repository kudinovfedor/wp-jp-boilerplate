<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">

    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>" content="<?php the_title(); ?>">

    <meta itemprop="author" content="<?php the_author() ?>">

    <h1 itemprop="headline"><?php the_title(); ?></h1>

    <p>
        <time itemprop="datePublished" datetime="<?php the_time( 'c' ); ?>"><?php the_time( 'd.m.Y' ) ?></time>
        <meta itemprop="dateModified" content="<?php the_modified_date( 'c' ); ?>">

        <span itemprop="articleSection"><?php the_category( ',' ) ?></span>
    </p>

    <?php if (has_post_thumbnail()) { ?>
        <figure><?php the_post_thumbnail('post-thumbnail'); ?></figure>
    <?php } ?>

    <div itemprop="articleBody"><?php the_content(); ?></div>

    <?php if (comments_open() || get_comments_number()) comments_template(); ?>

    <?php wp_link_pages(array(
        'before' => '<p>' . __('Pages:', 'joompress'),
        'after' => '</p>',
        'nextpagelink' => __('Next page', 'joompress'),
        'previouspagelink' => __('Previous page', 'joompress'),
    )); ?>

</article>
