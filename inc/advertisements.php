<?php
function home_top_ad($elem = 'section', $class = '')
{
    $is_home_top_ad = get_theme_mod("home_top_ads_swt", false);
    $home_top_ad_code = get_theme_mod("home_top_ads");
    if ($is_home_top_ad) {
        echo '<' . $elem . ' class="relative mb-12 w-full h-auto overflow-hidden text-center ' . $class . '">';
        echo $home_top_ad_code;
        echo '</' . $elem . '>';
    }
}

function home_bottom_ad($elem = 'section', $class = '')
{
    $is_home_btm_ad = get_theme_mod("home_botm_ads_swt", false);
    $home_btm_ad_code = get_theme_mod("home_botm_ads");
    if ($is_home_btm_ad) {
        echo '<' . $elem . ' class="relative mb-12 w-full h-auto overflow-hidden text-center ' . $class . '">';
        echo $home_btm_ad_code;
        echo '</' . $elem . '>';
    }
}

function single_top_ad($elem = 'section', $class = '')
{
    // Check if ads are disabled for this specific post
    if (get_post_meta(get_the_ID(), '_apkup_disable_ads', true)) {
        return;
    }

    $is_single_top_ad = get_theme_mod('single_top_ads_swt', false);
    $single_top_ad_code = get_theme_mod("single_top_ads");
    if ($is_single_top_ad) {
        echo '<' . $elem . ' class="relative mb-12 w-full h-auto overflow-hidden text-center ' . $class . '">';
        echo $single_top_ad_code;
        echo '</' . $elem . '>';
    }
}

function single_bottom_ad($elem = 'section', $class = '')
{
    // Check if ads are disabled for this specific post
    if (get_post_meta(get_the_ID(), '_apkup_disable_ads', true)) {
        return;
    }

    $is_single_bottom_ad = get_theme_mod('single_botm_ads_swt', false);
    $single_bottom_ad_code = get_theme_mod("single_botm_ads");
    if ($is_single_bottom_ad) {
        echo '<' . $elem . ' class="relative mb-12 w-full h-auto overflow-hidden text-center ' . $class . '">';
        echo $single_bottom_ad_code;
        echo '</' . $elem . '>';
    }
}

function archive_top_ad($elem = 'section', $class = '')
{
    $is_archive_top_ad = get_theme_mod('archive_top_ads_swt', false);
    $archive_top_ad_code = get_theme_mod('archive_top_ads');
    if ($is_archive_top_ad) {
        echo '<' . $elem . ' class="relative mb-12 w-full h-auto overflow-hidden text-center ' . $class . '">';
        echo $archive_top_ad_code;
        echo '</' . $elem . '>';
    }
}

function archive_bottom_ad($elem = 'section', $class = '')
{
    $is_archive_bottom_ad = get_theme_mod('archive_botm_ads_swt', false);
    $archive_bottom_ad_code = get_theme_mod('archive_botm_ads');
    if ($is_archive_bottom_ad) {
        echo '<' . $elem . ' class="relative mb-12 w-full h-auto overflow-hidden text-center ' . $class . '">';
        echo $archive_bottom_ad_code;
        echo '</' . $elem . '>';
    }
}


function download_top_ad($elem = 'section', $class = '')
{
    $is_download_top_ad = get_theme_mod('download_top_ads_swt', false);
    $download_top_ad_code = get_theme_mod('download_top_ads');
    if ($is_download_top_ad) {
        echo '<' . $elem . ' class="relative mb-12 w-full h-auto overflow-hidden text-center ' . $class . '">';
        echo $download_top_ad_code;
        echo '</' . $elem . '>';
    }
}

function download_bottom_ad($elem = 'section', $class = '')
{
    $is_download_bottom_ad = get_theme_mod('download_botm_ads_swt', false);
    $download_bottom_ad_code = get_theme_mod('download_botm_ads');
    if ($is_download_bottom_ad) {
        echo '<' . $elem . ' class="relative mb-12 w-full h-auto overflow-hidden text-center ' . $class . '">';
        echo $download_bottom_ad_code;
        echo '</' . $elem . '>';
    }
}
