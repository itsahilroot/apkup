<?php
$au_home_footer_info_swt = get_theme_mod('au_home_footer_info_swt', false);
$au_home_footer_info_title = get_theme_mod('au_home_footer_info_title', 'Las mejores aplicaciones y juegos de Android gratis 2026');
$au_home_footer_info_description = get_theme_mod('au_home_footer_info_description', 'APKGSTORE es la plataforma líder y más segura para descargar juegos modificados, versiones pro y aplicaciones totalmente liberadas de forma gratuita para tu dispositivo Android. Nos enfocamos en ofrecer velocidad, seguridad total con análisis de malware riguroso y actualizaciones constantes para que disfrutes de tus títulos favoritos como <span class="italic font-normal text-primary">Subway Surfers</span>, <span class="italic font-normal text-primary">Mortal Kombat</span>, y <span class="italic font-normal text-primary">DEAD TRIGGER 2</span> sin publicidad y con ventajas increíbles.');

if ($au_home_footer_info_swt) : ?>
<section class="mt-8">
    <div class="glass-card p-6 sm:p-8 rounded-2xl text-center md:text-left">
        <?php if (!empty($au_home_footer_info_title)) : ?>
            <h2 class="text-sm font-semibold text-slate-800 dark:text-white mb-2.5">
                <?php echo esc_html($au_home_footer_info_title); ?>
            </h2>
        <?php endif; ?>
        <?php if (!empty($au_home_footer_info_description)) : ?>
            <p class="text-xs leading-relaxed text-slate-500 dark:text-slate-300 font-light">
                <?php echo wp_kses_post($au_home_footer_info_description); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
