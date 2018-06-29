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

<header class="header" itemscope itemtype="http://schema.org/WPHeader">
    <div class="container">
        <div class="logo header-logo" itemscope itemtype="http://schema.org/Organization">
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

<span class="screen-reader-text" itemscope itemtype="http://schema.org/Person">
    <link itemprop="url" href="<?php echo esc_url(home_url('/')); ?>">
    <meta itemprop="name" content="<?php _e('Kudinov Fedor', 'joompress'); ?>">
    <a itemprop="sameAs" href="https://www.facebook.com/">Facebook</a>
    <a itemprop="sameAs" href="https://twitter.com/">Twitter</a>
    <a itemprop="sameAs" href="https://plus.google.com/">Google+</a>
    <a itemprop="sameAs" href="https://www.instagram.com/">Instagram</a>
    <a itemprop="sameAs" href="https://www.youtube.com/">Youtube</a>
    <a itemprop="sameAs" href="https://www.linkedin.com/">LinkedIn</a>
    <a itemprop="sameAs" href="https://myspace.com/">Myspace</a>
    <a itemprop="sameAs" href="https://ru.pinterest.com/">Pinterest</a>
    <a itemprop="sameAs" href="https://soundcloud.com/">SoundCloud</a>
    <a itemprop="sameAs" href="https://www.tumblr.com/">Tumblr</a>
</span>

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