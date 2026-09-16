<?php
$post_id = get_the_ID();

$is_app_mod = get_post_meta($post_id, 'app_type', true);
$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_mod_info = !empty($data['mod_info']) ? $data['mod_info'] : '';
$app_version = !empty($data['version']) ? $data['version'] : '1.0';
$app_novedades = !empty($data['novedades']) ? $data['novedades'] : '';

$new_rating_average = get_post_meta($post_id, 'new_rating_average', true) ?: '4.2';
$new_rating_users = get_post_meta($post_id, 'new_rating_users', true) ?: '2500000';
$rating_users_formatted = number_format((int)$new_rating_users);

// Gather MOD content if app is a MOD or mod_info exists
$mod_details = [];
if ($is_app_mod == 1 || !empty($app_mod_info)) {
    if (!empty($app_mod_info)) {
        $mod_details[] = $app_mod_info;
    }
    // Also check custom boxes (usually stores MOD details)
    $custom_boxes = get_post_meta($post_id, 'custom_boxes', true);
    if (is_array($custom_boxes) && !empty($custom_boxes[0]['content'])) {
        $mod_details[] = wp_strip_all_tags($custom_boxes[0]['content']);
    }
}

// Help Guide variables
$au_single_help_guide_title = get_theme_mod('au_single_help_guide_title', '¿Cómo instalar el archivo APK?');
$au_single_help_guide = get_theme_mod('au_single_help_guide', []);

if (empty($au_single_help_guide)) {
    // Default guide steps
    $au_single_help_guide = [
        ['text' => 'Descarga el archivo APK desde nuestros servidores rápidos y seguros.'],
        ['text' => 'Ve a los Ajustes de Seguridad de tu dispositivo Android.'],
        ['text' => 'Habilita la opción de "Permitir la instalación de Orígenes Desconocidos".'],
        ['text' => 'Abre tu gestor de archivos e instala el archivo APK descargado.'],
        ['text' => '¡Inicia la aplicación y comienza a disfrutar!']
    ];
}

// Generate Table of Contents (TOC) from content
$raw_content = get_the_content();
$processed_content = apply_filters('the_content', $raw_content);

$toc_items = [];
$pattern = '/<(h[23])([^>]*)>(.*?)<\/h[23]>/i';
$index = 1;

$content_with_ids = preg_replace_callback($pattern, function($matches) use (&$toc_items, &$index) {
    $tag = $matches[1];
    $attrs = $matches[2];
    $title = strip_tags($matches[3]);
    $id = 'toc-section-' . $index;
    
    $toc_items[] = [
        'id' => $id,
        'title' => $title,
        'tag' => $tag
    ];
    $index++;
    
    if (strpos($attrs, 'id=') !== false) {
        return $matches[0];
    }
    return "<{$tag} id=\"{$id}\"{$attrs}>{$matches[3]}</{$tag}>";
}, $processed_content);

// Create TOC HTML Card
$toc_html = '';
if (!empty($toc_items)) {
    $toc_html .= '<div class="my-6 p-5 bg-slate-50 dark:bg-slate-900/60 rounded-2xl border border-slate-200/60 dark:border-slate-800/80 max-w-md not-prose">';
    $toc_html .= '  <h4 class="text-xs font-bold text-slate-800 dark:text-white mb-3 uppercase tracking-wider flex items-center gap-2">';
    $toc_html .= '    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>';
    $toc_html .= '    Índice de Contenido';
    $toc_html .= '  </h4>';
    $toc_html .= '  <ul class="space-y-2 text-xs font-semibold text-slate-600 dark:text-slate-400 list-none pl-0">';
    foreach ($toc_items as $idx => $item) {
        $indent = ($item['tag'] === 'h3') ? ' pl-4' : '';
        $toc_html .= '    <li class="' . $indent . '"><a href="#' . esc_attr($item['id']) . '" class="hover:text-primary hover:underline transition-colors block py-0.5">' . ($idx + 1) . '. ' . esc_html($item['title']) . '</a></li>';
    }
    $toc_html .= '  </ul>';
    $toc_html .= '</div>';
    
    // Inject TOC after first paragraph if possible
    $p_pos = strpos($content_with_ids, '</p>');
    if ($p_pos !== false) {
        $content_with_ids = substr_replace($content_with_ids, '</p>' . $toc_html, $p_pos, 4);
    } else {
        $content_with_ids = $toc_html . $content_with_ids;
    }
}
?>



<!-- Minimalist Switcher Tab & Details -->
<div class="space-y-4 my-6">
  <!-- Switcher Button Row -->
  <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800 rounded-2xl max-w-sm">
    <button onclick="switchTab('description')" id="tabBtn-description" aria-label="Mostrar sección de descripción" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-semibold text-center transition-all cursor-pointer bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm border-none outline-none">
      Descripción
    </button>
    <button onclick="switchTab('help')" id="tabBtn-help" aria-label="Mostrar guía de ayuda e instalación" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-semibold text-center transition-all cursor-pointer text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-transparent border-none outline-none">
      Instalación / Ayuda
    </button>
  </div>

  <!-- Contenido: Descripción -->
  <div id="tabContent-description" class="p-6 bg-white dark:bg-brand-darkCard rounded-3xl border border-slate-200/50 dark:border-white/5 space-y-6">
    <div id="descTextContainer" class="prose prose-sm dark:prose-invert max-w-none text-slate-600 dark:text-slate-400 max-h-40 overflow-hidden relative transition-all duration-300 space-y-5 leading-relaxed">
      <?php echo $content_with_ids; ?>
      
      <!-- Gradiente de desvanecimiento -->
      <div id="descFade" class="absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-white dark:from-brand-darkCard to-transparent pointer-events-none"></div>
    </div>
    <button onclick="toggleDescription()" id="descToggleBtn" class="text-sm font-semibold text-primary hover:underline cursor-pointer flex items-center gap-1 border-none bg-transparent outline-none">
      Leer Más 
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
      </svg>
    </button>
  </div>

  <!-- Contenido: Ayuda -->
  <div id="tabContent-help" class="p-6 bg-white dark:bg-brand-darkCard rounded-3xl border border-slate-200/50 dark:border-white/5 space-y-4 hidden">
    <?php if (!empty($au_single_help_guide_title)) : ?>
      <h3 class="text-sm font-bold text-slate-800 dark:text-white"><?php echo esc_html($au_single_help_guide_title); ?></h3>
    <?php endif; ?>
    <ol class="space-y-3 text-sm text-slate-600 dark:text-slate-400 list-decimal list-inside">
      <?php foreach ($au_single_help_guide as $step) : ?>
        <li><?php echo esc_html($step['text']); ?></li>
      <?php endforeach; ?>
    </ol>
    <div class="p-4 bg-amber-50 dark:bg-amber-950/20 rounded-2xl border border-amber-200/50 dark:border-amber-900/30 text-amber-800 dark:text-amber-300 text-xs flex items-center gap-2">
      <svg class="w-4 h-4 shrink-0 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
      </svg>
      <span>Asegúrese de contar con suficiente espacio libre en el almacenamiento interno para evitar errores durante la instalación.</span>
    </div>
  </div>
</div>

<?php if (!empty($app_novedades)) : ?>
  <!-- Novedades / What's New Section -->
  <section class="bg-white dark:bg-gray-850/40 p-6 sm:p-8 rounded-[32px] border border-gray-200/50 dark:border-white/5 space-y-4 my-6">
    <div class="flex items-center space-x-3.5">
      <div class="w-11 h-11 bg-emerald-100 dark:bg-emerald-500/15 rounded-2xl flex items-center justify-center shrink-0 text-emerald-600 dark:text-emerald-400">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 21l-.813-5.096L3 15l5.096-.813L9 9l.813 5.096L15 15l-5.187.904zM18 10.5l-.375 2.25L15.375 13l2.25.375.375 2.25.375-2.25 2.25-.375-2.25-.375-.375-2.25zM12 4.5l-.188 1.125L10.688 6l1.125.188.188 1.125.188-1.125 1.125-.188-1.125-.188L12 4.5z"></path>
        </svg>
      </div>
      <div>
        <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white font-outfit"><?php esc_html_e('¿Qué hay de nuevo?', 'apktemplates'); ?></h2>
        <span class="text-xs text-slate-400 dark:text-slate-500 font-semibold"><?php printf(esc_html__('Novedades en la versión %s', 'apktemplates'), esc_html($app_version)); ?></span>
      </div>
    </div>
    <div class="prose prose-sm dark:prose-invert max-w-none text-slate-600 dark:text-slate-400 leading-relaxed">
      <?php echo $app_novedades; ?>
    </div>
  </section>
<?php endif; ?>

<?php
// Calculate rating distribution percentages
$rating_distribution = [];
$average = floatval($new_rating_average);
if ($average < 1.0) $average = 1.0;
if ($average > 5.0) $average = 5.0;

// Base values for average 4.3:
$p5 = 72;
$p4 = 15;
$p3 = 5;
$p2 = 2;
$p1 = 6;

// Adjust based on deviation from 4.3
$diff = $average - 4.3;
if ($diff > 0) {
    $shift = $diff * 50;
    $p5 += $shift;
    $p4 -= $shift * 0.5;
    $p3 -= $shift * 0.25;
    $p2 -= $shift * 0.15;
    $p1 -= $shift * 0.1;
} else {
    $shift = abs($diff) * 50;
    $p5 -= $shift;
    $p4 += $shift * 0.4;
    $p3 += $shift * 0.3;
    $p2 += $shift * 0.15;
    $p1 += $shift * 0.15;
}

$p5 = max(0, round($p5));
$p4 = max(0, round($p4));
$p3 = max(0, round($p3));
$p2 = max(0, round($p2));
$p1 = max(0, round($p1));

$sum = $p5 + $p4 + $p3 + $p2 + $p1;
if ($sum > 0) {
    $p5 = round(($p5 / $sum) * 100);
    $p4 = round(($p4 / $sum) * 100);
    $p3 = round(($p3 / $sum) * 100);
    $p2 = round(($p2 / $sum) * 100);
    $p1 = 100 - ($p5 + $p4 + $p3 + $p2);
} else {
    $p5 = 100; $p4 = 0; $p3 = 0; $p2 = 0; $p1 = 0;
}
$rating_distribution = [
    5 => $p5,
    4 => $p4,
    3 => $p3,
    2 => $p2,
    1 => $p1
];

// Generate stars HTML
$stars_html = '';
for ($i = 1; $i <= 5; $i++) {
    if ($new_rating_average >= ($i - 0.25)) {
        $stars_html .= '<i class="fa-solid fa-star"></i>';
    } elseif ($new_rating_average >= ($i - 0.75)) {
        $stars_html .= '<i class="fa-solid fa-star-half-stroke"></i>';
    } else {
        $stars_html .= '<i class="fa-regular fa-star"></i>';
    }
}
?>

<!-- Valoración / Ratings Summary Section (Google Play Style) -->
<section class="my-6 space-y-4">
  <h2 class="text-lg font-bold text-slate-900 dark:text-white"><?php esc_html_e('Valoraciones y reseñas', 'apktemplates'); ?></h2>
  <div class="grid grid-cols-1 md:grid-cols-12 gap-8 bg-white dark:bg-gray-850/40 p-6 sm:p-8 rounded-[32px] border border-gray-200/50 dark:border-white/5">
    
    <!-- Resumen de valoración -->
    <div class="md:col-span-4 flex flex-col items-center justify-center text-center space-y-2">
      <span class="text-5xl sm:text-6xl font-outfit font-black text-gray-800 dark:text-white"><?php echo esc_html(number_format((float)$new_rating_average, 1)); ?></span>
      <!-- Estrellas -->
      <div class="flex text-yellow-500 gap-1 text-sm">
        <?php echo $stars_html; ?>
      </div>
      <span class="text-xs font-semibold text-gray-400 dark:text-gray-500"><?php printf(esc_html__('%s calificaciones', 'apktemplates'), esc_html($rating_users_formatted)); ?></span>
    </div>

    <!-- Gráfico de barras de calificación (Google Play Style) -->
    <div class="md:col-span-8 space-y-2">
      <?php for ($i = 5; $i >= 1; $i--) : ?>
        <!-- <?php echo $i; ?> estrellas -->
        <div class="flex items-center gap-4 text-xs font-bold text-gray-500 dark:text-gray-400">
          <span class="w-3 text-right"><?php echo $i; ?></span>
          <div class="flex-1 h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
            <div class="h-full bg-playGreen rounded-full" style="width: <?php echo (int)$rating_distribution[$i]; ?>%;"></div>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- Dynamic download servers -->
<?php get_template_part('components/single/download-links'); ?>

<!-- Accordion and Switcher Javascript -->
<script>


// 2. Tab Switcher
function switchTab(tabId) {
    const descBtn = document.getElementById("tabBtn-description");
    const helpBtn = document.getElementById("tabBtn-help");
    const descContent = document.getElementById("tabContent-description");
    const helpContent = document.getElementById("tabContent-help");

    if (!descBtn || !helpBtn || !descContent || !helpContent) return;

    if (tabId === "description") {
        // Toggle Buttons
        descBtn.className = "flex-1 py-2.5 px-4 rounded-xl text-xs font-semibold text-center transition-all cursor-pointer bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm border-none outline-none";
        helpBtn.className = "flex-1 py-2.5 px-4 rounded-xl text-xs font-semibold text-center transition-all cursor-pointer text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-transparent border-none outline-none";
        // Toggle Content
        descContent.classList.remove("hidden");
        helpContent.classList.add("hidden");
    } else {
        // Toggle Buttons
        helpBtn.className = "flex-1 py-2.5 px-4 rounded-xl text-xs font-semibold text-center transition-all cursor-pointer bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm border-none outline-none";
        descBtn.className = "flex-1 py-2.5 px-4 rounded-xl text-xs font-semibold text-center transition-all cursor-pointer text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-transparent border-none outline-none";
        // Toggle Content
        helpContent.classList.remove("hidden");
        descContent.classList.add("hidden");
    }
}

// 3. Leer Más Description Toggle
function toggleDescription() {
    const container = document.getElementById("descTextContainer");
    const fade = document.getElementById("descFade");
    const btn = document.getElementById("descToggleBtn");
    
    if (container && btn) {
        const isCollapsed = container.classList.contains("max-h-40");
        if (isCollapsed) {
            container.classList.remove("max-h-40");
            container.classList.remove("overflow-hidden");
            if (fade) fade.classList.add("hidden");
            btn.innerHTML = 'Leer Menos <svg class="w-3.5 h-3.5 transform rotate-180 inline ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>';
        } else {
            container.classList.add("max-h-40");
            container.classList.add("overflow-hidden");
            if (fade) fade.classList.remove("hidden");
            btn.innerHTML = 'Leer Más <svg class="w-3.5 h-3.5 inline ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>';
        }
    }
}
</script>