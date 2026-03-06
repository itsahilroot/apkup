<?php
$au_home_footer_info_swt = get_theme_mod('au_home_footer_info_swt', false);
$au_home_footer_info_title = get_theme_mod('au_home_footer_info_title', 'Best Android Apps & Games for free');
$au_home_footer_info_description = get_theme_mod('au_home_footer_info_description', 'Hre is the best place to dwonload android premium apps and mod games for free.');

if ($au_home_footer_info_swt) : ?>
    <div class="info-card mb-8 bg-white dark:bg-gray-800 rounded-[18px] p-[20px_18px] shadow-[0_4px_16px_rgba(0,0,0,0.07)]">
        <?php if (!empty($au_home_footer_info_title)) : ?>
            <h1 class="text-[1.8rem] md:text-[2rem] font-black text-[#1a1a1a] dark:text-gray-200 leading-[1.3] mb-4">
                <?php echo $au_home_footer_info_title; ?>
            </h1>
        <?php endif;
        if (!empty($au_home_footer_info_description)) : ?>
            <p id="desc" class="text-[0.92rem] text-[#555] dark:text-[#d1d5db] leading-[1.6] font-semibold mb-3 line-clamp-3 transition-all duration-300">
                <?php echo $au_home_footer_info_description; ?>
            </p>
            <button id="toggleBtn" class="leer-mas bg-transparent border-none cursor-pointer text-primary text-[0.82rem] font-extrabold tracking-[0.5px] uppercase hover:underline">
                LEER MÁS
            </button>
        <?php endif; ?>
    </div>
<?php endif; ?>
