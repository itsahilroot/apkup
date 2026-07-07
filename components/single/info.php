<?php
$post_id = get_the_ID();

$app_name = get_the_title();
$post_updated_date = get_the_modified_date('d M Y', $post_id);
$app_logo_full = get_the_post_thumbnail_url($post_id, 'full');
if (empty($app_logo_full)) {
    $app_logo_full = 'https://placehold.co/150x150/0052e0/ffffff?text=App';
}

$is_app_mod = get_post_meta($post_id, 'app_type', true);

$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_version = !empty($data['version']) ? $data['version'] : '1.0';
$app_requires = !empty($data['requerimientos']) ? $data['requerimientos'] : '7.0';
$app_size = !empty($data['tamano']) ? $data['tamano'] : '100 MB';
$app_downloads = !empty($data['descargas']) ? (function_exists('apkup_format_downloads') ? apkup_format_downloads($data['descargas']) : $data['descargas']) : '10M+';
$app_consiguelo = !empty($data['consiguelo']) ? $data['consiguelo'] : '';

$new_rating_average = get_post_meta($post_id, 'new_rating_average', true) ?: '4.2';
$new_rating_users = get_post_meta($post_id, 'new_rating_users', true) ?: '2500000';
$formatted_reviews = function_exists('apkup_format_views_count') ? apkup_format_views_count($new_rating_users) : $new_rating_users;
$developer_terms = get_the_terms($post_id, 'developer');
$developer_name = 'Supercell';
$developer_search_url = '';

if (!empty($developer_terms) && !is_wp_error($developer_terms)) {
    $first_developer = array_shift($developer_terms);
    $developer_name = $first_developer->name;
    $term_link = get_term_link($first_developer);
    $developer_search_url = !is_wp_error($term_link) ? $term_link : esc_url(add_query_arg('s', $developer_name, home_url('/')));
} else {
    $developer_name = get_post_meta($post_id, 'wp_developers_GP', true) ?: 'Supercell';
    $developer_search_url = esc_url(add_query_arg('s', $developer_name, home_url('/')));
}

$primary_cat = apkup_get_primary_post_category($post_id);
?>
<!-- App Details Hero Section -->
<section class="bg-white dark:bg-brand-darkCard rounded-3xl p-4 sm:p-6 shadow-sm border border-slate-100 dark:border-brand-darkBorder transition-all flex flex-col items-stretch space-y-4">

  <!-- Breadcrumbs -->
  <div class="border-b border-slate-100 dark:border-brand-darkBorder/40 pb-2.5">
    <?php if (function_exists('apkup_breadcrumb')) apkup_breadcrumb(); ?>
  </div>

  <!-- Icon and Meta block layout -->
  <div class="flex items-start text-left space-x-4 md:space-x-6 w-full">
    <!-- App icon -->
    <div class="relative w-24 h-24 sm:w-28 sm:h-28 shrink-0 rounded-3xl overflow-hidden shadow-md border border-slate-100 dark:border-brand-darkBorder">
      <img src="<?php echo esc_url($app_logo_full); ?>" alt="<?php echo esc_attr($app_name); ?> App Icon" class="w-full h-full object-cover" width="112" height="112" onerror="this.onerror=null; this.src='https://placehold.co/150x150/0052e0/ffffff?text=App';">
    </div>

    <!-- Meta Text Column + Stats grid side-by-side -->
    <div class="flex-grow space-y-3.5 w-full">
      <div>
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
          <?php echo esc_html($app_name); ?>
        </h1>
        <a href="<?php echo $developer_search_url; ?>"
          aria-label="Ver más de <?php echo esc_attr($developer_name); ?>"
          class="inline-flex items-center mt-1 text-primary hover:underline font-semibold text-sm transition-colors">
          <span><?php echo esc_html($developer_name); ?></span>
          <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>

      <!-- Specifications Stats Row Table -->
      <div class="grid grid-cols-3 gap-2 border-t border-slate-100 dark:border-brand-darkBorder/70 pt-3 text-xs sm:text-sm max-w-[320px]">
        <!-- Stats Col 1 -->
        <div class="flex flex-col items-center justify-center border-r border-slate-150/60 dark:border-brand-darkBorder">
          <div class="flex items-center space-x-1 font-bold text-slate-900 dark:text-white">
            <span class="text-amber-500">★</span>
            <span><?php echo esc_html(number_format((float)$new_rating_average, 1)); ?></span>
          </div>
          <span class="text-slate-400 dark:text-slate-500 text-[10px] mt-0.5 text-center"><?php echo esc_html($formatted_reviews); ?> reviews</span>
        </div>
        <!-- Stats Col 2 -->
        <div class="flex flex-col items-center justify-center border-r border-slate-150/60 dark:border-brand-darkBorder">
          <div class="flex items-center space-x-1 font-bold text-slate-900 dark:text-white">
            <svg class="w-3.5 h-3.5 text-slate-500 mr-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            <span><?php echo esc_html($app_downloads); ?></span>
          </div>
          <span class="text-slate-400 dark:text-slate-500 text-[10px] mt-0.5 text-center">Downloads</span>
        </div>
        <!-- Stats Col 3 -->
        <div class="flex flex-col items-center justify-center">
          <div class="flex items-center space-x-1 font-bold text-slate-900 dark:text-white">
            <svg class="w-3.5 h-3.5 text-slate-500 mr-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <span><?php echo esc_html($app_size); ?></span>
          </div>
          <span class="text-slate-400 dark:text-slate-500 text-[10px] mt-0.5 text-center">Size</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Download Action button triggering inline progress indicator -->
  <div class="pt-1 flex flex-col space-y-2.5">
    <button id="downloadBtn" aria-label="Descargar <?php echo esc_attr($app_name); ?> APK (<?php echo esc_attr($app_size); ?>)"
      class="relative overflow-hidden w-full bg-primary hover:opacity-95 active:scale-[0.99] text-white font-bold py-3 px-6 rounded-xl shadow-md shadow-primary/15 flex items-center justify-center space-x-2.5 transition-all text-sm sm:text-base focus:ring-4 focus:ring-primary/20 cursor-pointer">
      <div id="btnProgressBar" class="absolute inset-y-0 left-0 bg-black/10 w-0 transition-all duration-200"></div>
      <div class="relative z-10 flex items-center justify-center space-x-2.5">
        <svg id="btnIcon" class="w-5 h-5 shrink-0 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
        </svg>
        <span id="btnText">Download APK (<?php echo esc_html($app_size); ?>)</span>
      </div>
    </button>
    <div id="btnProgressDetails" class="hidden justify-between items-center px-1 text-xs font-semibold text-slate-400 dark:text-slate-500">
      <span id="btnPercentage">0%</span>
      <span id="btnSpeed">Descargando...</span>
    </div>
  </div>
</section>

<!-- Carousel Features Horizontal Grid -->
<section class="relative mt-4">
  <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar py-1 snap-x snap-mandatory scroll-smooth md:grid md:grid-cols-6 md:gap-4 md:space-x-0 md:overflow-x-visible" id="specCarousel">

    <!-- Info Card 1: Actualización -->
    <div class="min-w-[100px] sm:min-w-[115px] md:min-w-0 snap-center bg-white dark:bg-brand-darkCard rounded-2xl p-2.5 flex flex-col items-center text-center shadow-sm border border-slate-100 dark:border-brand-darkBorder/80">
      <div class="w-8 h-8 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center mb-1.5 text-slate-500">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
      </div>
      <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium leading-none">Actualización</span>
      <span class="text-xs font-bold text-slate-800 dark:text-slate-200 mt-1 whitespace-nowrap"><?php echo esc_html($post_updated_date); ?></span>
    </div>

    <!-- Info Card 2: Versión -->
    <div class="min-w-[100px] sm:min-w-[115px] md:min-w-0 snap-center bg-white dark:bg-brand-darkCard rounded-2xl p-2.5 flex flex-col items-center text-center shadow-sm border border-slate-100 dark:border-brand-darkBorder/80">
      <div class="w-8 h-8 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center mb-1.5 text-slate-500">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
      </div>
      <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium leading-none">Versión</span>
      <span class="text-xs font-bold text-slate-800 dark:text-slate-200 mt-1 truncate max-w-full"><?php echo esc_html($app_version); ?></span>
    </div>

    <!-- Info Card 3: Categoría -->
    <div class="min-w-[100px] sm:min-w-[115px] md:min-w-0 snap-center bg-white dark:bg-brand-darkCard rounded-2xl p-2.5 flex flex-col items-center text-center shadow-sm border border-slate-100 dark:border-brand-darkBorder/80">
      <div class="w-8 h-8 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center mb-1.5 text-slate-500">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
        </svg>
      </div>
      <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium leading-none">Categoría</span>
      <?php if ($primary_cat) : ?>
        <a href="<?php echo esc_url($primary_cat['url']); ?>" class="text-xs font-bold text-primary mt-1 truncate max-w-full hover:underline"><?php echo esc_html($primary_cat['name']); ?></a>
      <?php else : ?>
        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 mt-1">Apps</span>
      <?php endif; ?>
    </div>

    <!-- Info Card 4: Requiere -->
    <div class="min-w-[100px] sm:min-w-[115px] md:min-w-0 snap-center bg-white dark:bg-brand-darkCard rounded-2xl p-2.5 flex flex-col items-center text-center shadow-sm border border-slate-100 dark:border-brand-darkBorder/80">
      <div class="w-8 h-8 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center mb-1.5 text-slate-500">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
      </div>
      <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium leading-none">Requiere</span>
      <span class="text-xs font-bold text-slate-800 dark:text-slate-200 mt-1 whitespace-nowrap">Android <?php echo esc_html(function_exists('apkup_extract_number') ? (apkup_extract_number($app_requires) ?: '7.0') : $app_requires); ?>+</span>
    </div>

    <!-- Info Card 5: Tamaño -->
    <div class="min-w-[100px] sm:min-w-[115px] md:min-w-0 snap-center bg-white dark:bg-brand-darkCard rounded-2xl p-2.5 flex flex-col items-center text-center shadow-sm border border-slate-100 dark:border-brand-darkBorder/80">
      <div class="w-8 h-8 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center mb-1.5 text-slate-500">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
      </div>
      <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium leading-none">Tamaño</span>
      <span class="text-xs font-bold text-slate-800 dark:text-slate-200 mt-1 truncate max-w-full"><?php echo esc_html($app_size); ?></span>
    </div>

    <!-- Info Card 6: Play Store -->
    <div class="min-w-[100px] sm:min-w-[115px] md:min-w-0 snap-center bg-white dark:bg-brand-darkCard rounded-2xl p-2.5 flex flex-col items-center text-center shadow-sm border border-slate-100 dark:border-brand-darkBorder/80">
      <div class="w-8 h-8 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center mb-1.5">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
          <path d="M3 20.37V3.63a1 1 0 011.53-.85l15.1 8.37a1 1 0 010 1.7l-15.1 8.37A1 1 0 013 20.37z" fill="#00e676"></path>
          <path d="M3 3.63v16.74a1 1 0 001.53.85L12 12 3.53 2.78A1 1 0 003 3.63z" fill="#00b0ff"></path>
          <path d="M12 12l6.63 3.67 1.5-1.5a1 1 0 000-1.7l-8.13-4.47" fill="#ffea00"></path>
          <path d="M3.53 2.78l11.5 6.35 3.1-1.7-13.1-7.25a1 1 0 00-1.53.85c0 .35.13.7.43.85V2.78z" fill="#ff1744"></path>
        </svg>
      </div>
      <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium leading-none">Play Store</span>
      <?php if (!empty($app_consiguelo)) : ?>
        <a href="<?php echo esc_url($app_consiguelo); ?>" target="_blank" rel="noopener" class="text-xs font-bold text-blue-500 mt-1 hover:underline">Disponible</a>
      <?php else : ?>
        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 mt-1">No disp.</span>
      <?php endif; ?>
    </div>

  </div>

  <!-- Custom progress navigation slider tracker (Desktop only - Hidden if no overflow) -->
  <div class="hidden flex-col items-center justify-center mt-3 select-none" id="specTrackContainer">
    <div id="specTrack" class="w-48 h-2.5 bg-slate-200 dark:bg-slate-800 rounded-full relative cursor-pointer group flex items-center">
      <div class="absolute inset-x-0 h-1.5 bg-slate-200 dark:bg-slate-800 rounded-full group-hover:bg-slate-300 dark:group-hover:bg-slate-700 transition-colors"></div>
      <div id="specThumb" class="absolute h-2.5 bg-primary rounded-full cursor-grab active:cursor-grabbing transition-transform duration-75 hover:opacity-90 shadow-sm" style="width: 50px; transform: translateX(0);"></div>
    </div>
    <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest uppercase mt-2 pointer-events-none">Deslizar para explorar</span>
  </div>
</section>

<?php
$custom_boxes = get_post_meta($post_id, 'custom_boxes', true);
$mod_details = [];
if (is_array($custom_boxes) && !empty($custom_boxes[0]['content'])) {
    $mod_details[] = wp_strip_all_tags($custom_boxes[0]['content']);
}

if (!empty($mod_details)) :
    $mod_title = (is_array($custom_boxes) && !empty($custom_boxes[0]['title'])) ? $custom_boxes[0]['title'] : __('MOD INFO', 'apktemplates');
?>
<!-- MOD Info Accordion -->
<section class="bg-white dark:bg-brand-darkCard rounded-3xl overflow-hidden shadow-sm border border-slate-100 dark:border-brand-darkBorder smooth-transition my-6">
  <button id="modAccordionHeader" class="w-full p-5 flex items-center justify-between text-left focus:outline-none cursor-pointer" aria-expanded="false" aria-controls="modAccordionBody">
    <div class="flex items-center space-x-3.5">
      <div class="w-11 h-11 bg-purple-100 dark:bg-purple-500/15 rounded-2xl flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 24 24">
          <path d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
      </div>
      <div>
        <span class="block text-sm font-bold text-purple-600 dark:text-purple-400 tracking-wider"><?php echo esc_html($mod_title); ?></span>
        <span class="block text-xs text-slate-400 dark:text-slate-500 mt-0.5"><?php esc_html_e('Toca para ver las funciones modificadas', 'apktemplates'); ?></span>
      </div>
    </div>
    <svg id="modAccordionChevron" class="w-5 h-5 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
    </svg>
  </button>

  <!-- Content Panel -->
  <div id="modAccordionBody" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
    <div class="p-5 border-t border-slate-100 dark:border-brand-darkBorder bg-purple-50/20 dark:bg-purple-950/5 space-y-3.5 text-sm">
      <p class="font-semibold text-slate-700 dark:text-slate-300"><?php esc_html_e('Este APK cuenta con los siguientes agregados especiales:', 'apktemplates'); ?></p>
      <ul class="space-y-2.5">
        <?php foreach ($mod_details as $detail) : 
            $lines = array_filter(explode("\n", str_replace("\r", "", $detail)));
            if (empty($lines)) $lines = [$detail];
            foreach ($lines as $line) :
        ?>
          <li class="flex items-start space-x-2">
            <span class="text-emerald-500 font-bold shrink-0">✔</span>
            <span class="text-slate-600 dark:text-slate-400"><?php echo esc_html($line); ?></span>
          </li>
        <?php endforeach; endforeach; ?>
      </ul>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Inline Javascript Controller for Download Animation & Specs Trackbar -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    // MOD Accordion Toggle
    const accordionHeader = document.getElementById("modAccordionHeader");
    const accordionBody = document.getElementById("modAccordionBody");
    const accordionChevron = document.getElementById("modAccordionChevron");

    if (accordionHeader && accordionBody) {
        accordionHeader.addEventListener("click", () => {
            const expanded = accordionHeader.getAttribute("aria-expanded") === "true";
            accordionHeader.setAttribute("aria-expanded", !expanded);
            
            if (!expanded) {
                accordionBody.style.maxHeight = accordionBody.scrollHeight + "px";
                if (accordionChevron) accordionChevron.classList.add("rotate-180");
            } else {
                accordionBody.style.maxHeight = "0";
                if (accordionChevron) accordionChevron.classList.remove("rotate-180");
            }
        });
    }

    // 1. Download progress animation
    const downloadBtn = document.getElementById("downloadBtn");
    const progressBar = document.getElementById("btnProgressBar");
    const progressDetails = document.getElementById("btnProgressDetails");
    const percentageText = document.getElementById("btnPercentage");
    const btnIcon = document.getElementById("btnIcon");
    const btnText = document.getElementById("btnText");
    const btnSpeed = document.getElementById("btnSpeed");

    if (downloadBtn && progressBar && progressDetails) {
        let isDownloading = false;
        downloadBtn.addEventListener("click", (e) => {
            if (isDownloading) return;
            
            // If already downloaded or done, just scroll down
            if (downloadBtn.classList.contains("download-completed")) {
                const target = document.getElementById("download-section") || document.getElementById("download-links");
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                return;
            }

            isDownloading = true;
            downloadBtn.style.pointerEvents = "none";
            progressDetails.classList.remove("hidden");
            progressDetails.classList.add("flex");
            
            let progress = 0;
            const size = "<?php echo esc_js($app_size); ?>";
            btnText.innerText = "Preparando descarga...";
            progressBar.style.width = "0%";
            
            const interval = setInterval(() => {
                progress += Math.floor(Math.random() * 10) + 5;
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(interval);
                    
                    progressBar.style.width = "100%";
                    percentageText.innerText = "100%";
                    btnText.innerText = "¡Descarga Lista!";
                    btnSpeed.innerText = "Completado";
                    downloadBtn.classList.add("download-completed");
                    downloadBtn.style.pointerEvents = "auto";
                    isDownloading = false;
                    
                    // Trigger scroll to download section
                    setTimeout(() => {
                        const target = document.getElementById("download-section") || document.getElementById("download-links");
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }, 500);
                } else {
                    progressBar.style.width = progress + "%";
                    percentageText.innerText = progress + "%";
                    btnText.innerText = "Descargando... (" + progress + "%)";
                    
                    // Simulated speeds
                    const speeds = ["5.2 MB/s", "6.8 MB/s", "8.1 MB/s", "4.9 MB/s", "7.4 MB/s"];
                    const randomSpeed = speeds[Math.floor(Math.random() * speeds.length)];
                    btnSpeed.innerText = randomSpeed + " • " + size;
                }
            }, 150);
        });
    }

    // 2. Specifications Slider Trackbar (Desktop Only)
    const carousel = document.getElementById("specCarousel");
    const trackContainer = document.getElementById("specTrackContainer");
    const track = document.getElementById("specTrack");
    const thumb = document.getElementById("specThumb");

    if (carousel && trackContainer && track && thumb) {
        const updateSlider = () => {
            const scrollWidth = carousel.scrollWidth;
            const clientWidth = carousel.clientWidth;
            const scrollLeft = carousel.scrollLeft;

            if (scrollWidth > clientWidth && window.innerWidth >= 768) {
                trackContainer.classList.remove("hidden");
                trackContainer.classList.add("flex");

                const trackWidth = track.clientWidth;
                const thumbWidth = (clientWidth / scrollWidth) * trackWidth;
                thumb.style.width = Math.max(thumbWidth, 30) + "px";

                const maxScroll = scrollWidth - clientWidth;
                const scrollPct = scrollLeft / maxScroll;
                const maxTranslate = trackWidth - thumb.clientWidth;
                thumb.style.transform = `translateX(${scrollPct * maxTranslate}px)`;
            } else {
                trackContainer.classList.add("hidden");
                trackContainer.classList.remove("flex");
            }
        };

        // Scroll event listener
        carousel.addEventListener("scroll", updateSlider);
        window.addEventListener("resize", updateSlider);
        
        // Let user drag the thumb
        let isDragging = false;
        let startX, startLeft;

        thumb.addEventListener("mousedown", (e) => {
            isDragging = true;
            startX = e.clientX;
            const matrix = window.getComputedStyle(thumb).transform;
            if (matrix && matrix !== 'none') {
                startLeft = parseFloat(matrix.split(',')[4]);
            } else {
                startLeft = 0;
            }
            thumb.classList.add("grabbing");
            document.body.style.userSelect = "none";
        });

        document.addEventListener("mousemove", (e) => {
            if (!isDragging) return;
            const deltaX = e.clientX - startX;
            const trackWidth = track.clientWidth;
            const maxTranslate = trackWidth - thumb.clientWidth;
            
            let newLeft = startLeft + deltaX;
            newLeft = Math.max(0, Math.min(newLeft, maxTranslate));
            thumb.style.transform = `translateX(${newLeft}px)`;

            const pct = newLeft / maxTranslate;
            carousel.scrollLeft = pct * (carousel.scrollWidth - carousel.clientWidth);
        });

        document.addEventListener("mouseup", () => {
            if (isDragging) {
                isDragging = false;
                thumb.classList.remove("grabbing");
                document.body.style.userSelect = "";
            }
        });

        // Initialize view
        setTimeout(updateSlider, 200);
    }
});
</script>