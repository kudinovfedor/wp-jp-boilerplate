<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>" content="<?php the_title(); ?>">
    <meta itemprop="dateModified" content="<?php the_modified_date( 'c' ); ?>">

    <?php /*
    <div itemprop="articleBody"><?php the_content(); ?></div>
    */ ?>

    <meta itemprop="author" content="<?php the_author(); ?>">

    <time itemprop="datePublished" datetime="<?php the_time( 'c' ); ?>"><?php the_time( 'd.m.Y' ); ?></time>

    <span itemprop="articleSection"><?php the_category( ',' ); ?></span>

    <h2 itemprop="headline"><?php the_title(); ?></h2>

    <div itemprop="description"><?php the_content(); ?></div>

</article>
