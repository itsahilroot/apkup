<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head();
    apkup_set_post_views(get_the_ID()); ?>
</head>

<body class="bg-gray-50 min-h-screen md:pb-0 dark:bg-gray-900 transition-colors duration-300">
    <?php get_template_part('components/utils/header'); ?>