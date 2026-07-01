<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
    <link rel="canonical" href="<?php echo esc_url(is_home() || is_front_page() ? home_url('/') : get_permalink()); ?>">
    <meta property="og:title" content="<?php echo is_home() || is_front_page() ? esc_attr(get_bloginfo('name') . ' - ' . get_bloginfo('description')) : esc_attr(get_the_title()); ?>">
    <meta property="og:description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
    <meta property="og:url" content="<?php echo esc_url(is_home() || is_front_page() ? home_url('/') : get_permalink()); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <meta property="og:type" content="<?php echo is_single() ? 'article' : 'website'; ?>">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <?php wp_head();
    apkup_set_post_views(get_the_ID()); ?>
</head>

<body class="bg-gray-50 min-h-screen md:pb-0 dark:bg-gray-900 transition-colors duration-300">
    <?php get_template_part('components/utils/header'); ?>