<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport"
          content="width=device-width, height=device-height, minimum-scale=1.0, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes, shrink-to-fit=no">
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
                logo();
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