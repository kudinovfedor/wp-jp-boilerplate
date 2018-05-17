<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport"
          content="width=device-width, height=device-height, minimum-scale=1.0, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes, shrink-to-fit=no">
    <?php if ( ! has_site_icon()) { ?>
        <link href="<?php echo JP_FAVICON . '/apple-touch-icon.png'; ?>" rel="apple-touch-icon" sizes="180x180">
        <link href="<?php echo JP_FAVICON . '/favicon-16x16.png'; ?>" rel="icon" type="image/png" sizes="16x16">
        <link href="<?php echo JP_FAVICON . '/favicon-32x32.png'; ?>" rel="icon" type="image/png" sizes="32x32">
        <link href="<?php echo JP_FAVICON . '/site.webmanifest'; ?>" rel="manifest">
        <link href="<?php echo JP_FAVICON . '/safari-pinned-tab.svg'; ?>" rel="mask-icon" color="#ff6347">
        <link href="<?php echo JP_FAVICON . '/favicon.ico'; ?>" rel="shortcut icon">
        <meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?>">
        <meta name="application-name" content="<?php bloginfo('name'); ?>">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="<?php echo JP_FAVICON . '/mstile-144x144.png'; ?>">
        <meta name="msapplication-config" content="<?php echo JP_FAVICON . '/browserconfig.xml'; ?>">
        <meta name="theme-color" content="#ffffff">
    <?php } ?>
    <?php wp_head(); ?>
</head>
<body id="top" <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<?php wp_body(); ?>

<?php skip_to_content('content'); ?>

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
        <div><?php social(); ?></div>
        <div><?php phones(); ?></div>
    </div>