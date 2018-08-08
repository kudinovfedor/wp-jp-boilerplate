<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, height=device-height, minimum-scale=1.0, initial-scale=1.0,
     maximum-scale=2.0, user-scalable=yes, shrink-to-fit=no">
    <?php if (!has_site_icon()) { ?>
        <link href="<?php echo JP_FAVICON . '/apple-touch-icon.png'; ?>" rel="apple-touch-icon" sizes="180x180">
        <link href="<?php echo JP_FAVICON . '/favicon-16x16.png'; ?>" rel="icon" type="image/png" sizes="16x16">
        <link href="<?php echo JP_FAVICON . '/favicon-32x32.png'; ?>" rel="icon" type="image/png" sizes="32x32">
        <link href="<?php echo JP_FAVICON . '/site.webmanifest'; ?>" rel="manifest">
        <link href="<?php echo JP_FAVICON . '/safari-pinned-tab.svg'; ?>" rel="mask-icon" color="#146994">
        <link href="<?php echo JP_FAVICON . '/favicon.ico'; ?>" rel="shortcut icon">
        <meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?>">
        <meta name="application-name" content="<?php bloginfo('name'); ?>">
        <meta name="msapplication-TileColor" content="#146994">
        <meta name="msapplication-config" content="<?php echo JP_FAVICON . '/browserconfig.xml'; ?>">
        <meta name="theme-color" content="#146994">
    <?php } ?>
    <?php wp_head(); ?>
</head>
<body id="top" <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<?php wp_body(); ?>

<?php skip_to_content('content'); ?>

<?php /** Sitelinks searchbox */
if (is_front_page()) { ?>
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "name": "<?php bloginfo('name'); ?>",
        "url": "<?php echo home_url('/'); ?>",
        "description": "<?php bloginfo('description'); ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo home_url('/') . '?s={s}'; ?>",
            "query-input": "required name=s"
        }
    }
    </script>
<?php } ?>

<?php /** Organization + Logo */ ?>
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "<?php bloginfo('name'); ?>",
        "url": "<?php echo home_url('/'); ?>",
        "logo": "<?php echo get_logo_url(); ?>",
        "sameAs": [
            "https://www.facebook.com/organization-profile",
            "https://twitter.com/organization-profile",
            "https://plus.google.com/organization-profile",
            "https://www.instagram.com/organization-profile",
            "https://www.youtube.com/organization-profile",
            "https://www.linkedin.com/organization-profile",
            "https://myspace.com/organization-profile",
            "https://ru.pinterest.com/organization-profile",
            "https://soundcloud.com/organization-profile",
            "https://www.tumblr.com/organization-profile"
        ]
    }
</script>

<?php /** Person */ ?>
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Person",
        "name": "<?php _e('Kudinov Fedor', 'joompress'); ?>",
        "url": "<?php echo home_url('/'); ?>",
        "sameAs": [
            "https://www.facebook.com/your-profile",
            "https://twitter.com/your-profile",
            "https://plus.google.com/your-profile",
            "https://www.instagram.com/your-profile",
            "https://www.youtube.com/your-profile",
            "https://www.linkedin.com/your-profile",
            "https://myspace.com/your-profile",
            "https://ru.pinterest.com/your-profile",
            "https://soundcloud.com/your-profile",
            "https://www.tumblr.com/your-profile"
        ]
    }
</script>

<?php /** Article */
if (is_single()) {
    global $post;
    setup_postdata($post);
    $image = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'full');
    ?>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "<?php the_permalink(); ?>"
            },
            "headline": "<?php the_title(); ?>",
            "image": <?php echo $image; ?>,
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
            "description": "<?php the_excerpt(); ?>",
            "articleBody": "<?php the_content(); ?>"
        }
    </script>
<?php } ?>

<header class="header" itemscope itemtype="http://schema.org/WPHeader">
    <div class="container">
        <div class="logo header-logo">
            <?php if (has_custom_logo()) {
                the_custom_logo();
            } else {
                logo('logo.png');
            } ?>
        </div>
        <div class="header-search">
            <?php get_search_form(); ?>
        </div>
        <?php hamburger('js-hamburger'); ?>
    </div>
</header>

<?php get_template_part('template-parts/navigation/menu', 'header'); ?>

<div class="wrapper">

    <div class="container">
        <h2 class="blog-name" itemprop="name"><?php bloginfo('name'); ?></h2>
        <p class="blog-description" itemprop="description"><?php bloginfo('description'); ?></p>

        <div style="margin-bottom: 16px;"><?php google_map(); ?></div>

        <?php if (is_customize_preview()) { ?>
            <div style="margin-bottom: 16px;"><?php social(); ?></div>
            <div style="margin-bottom: 16px;"><?php phones(); ?></div>
            <div style="margin-bottom: 16px;"><?php messengers(); ?></div>
            <div style="margin-bottom: 16px;"><?php (new GoogleReCaptcha())->htmlMarkup(); ?></div>

            <p>
                <button class="btn customizer-edit" data-control='{ "name":"jp_analytics_google_placed" }'>
                    <?php esc_html_e('Edit Analytics Tracking Code', 'joompress'); ?>
                </button>
                <button class="btn customizer-edit" data-control='{ "name":"jp_login_logo" }'>
                    <?php esc_html_e('Edit Login Logo', 'joompress'); ?>
                </button>
            </p>
        <?php } ?>

    </div>