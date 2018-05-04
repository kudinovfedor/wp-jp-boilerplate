<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">

    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>" content="<?php the_title(); ?>">
    <meta itemprop="dateModified" content="<?php the_modified_date( 'c' ); ?>">
    <meta itemprop="author" content="<?php the_author(); ?>">

    <time itemprop="datePublished" datetime="<?php the_time( 'c' ); ?>"><?php the_time( 'd.m.Y' ); ?></time>

    <span itemprop="articleSection"><?php the_category( ',' ); ?></span>

    <h1 itemprop="headline"><?php the_title(); ?></h1>

    <?php if (has_post_thumbnail()) the_post_thumbnail(); ?>

    <div itemprop="articleBody"><?php the_content(); ?></div>

    <?php the_tags(); ?>

    <?php if (comments_open() || get_comments_number()) comments_template(); ?>

</article>
