<?php
$post_id = get_the_ID();
$download_links = apkup_get_datos_download($post_id);

$app_name = get_the_title();
$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_version = !empty($data['version']) ? $data['version'] : '1.0';
$app_size = !empty($data['tamano']) ? $data['tamano'] : '100 MB';

$links = [];
if (!empty($download_links['links_options'])) {
    $links = $download_links['links_options'];
} else {
    foreach ($download_links as $k => $v) {
        if (is_int($k) && is_array($v)) {
            $links[$k] = $v;
        }
    }
}

$formatted_links = [];
foreach ($links as $index => $dl) {
    $text = !empty($dl['texto']) ? $dl['texto'] : (!empty($dl['type']) ? $dl['type'] : 'APK');
    $type = !empty($dl['type']) ? $dl['type'] : 'Server';
    $link_version = !empty($dl['version']) ? $dl['version'] : $app_version;
    $link_size = !empty($dl['size']) ? $dl['size'] : $app_size;
    $link_mod = !empty($dl['mod_info']) ? $dl['mod_info'] : '';
    $download_url = get_permalink() . 'download/' . $index;
    
    $formatted_links[] = [
        'id' => 'ver-' . $index,
        'index' => $index,
        'text' => $text,
        'type' => $type,
        'version' => $link_version,
        'size' => $link_size,
        'mod' => $link_mod,
        'url' => esc_url($download_url),
        'isPro' => (stripos($link_mod, 'pro') !== false || stripos($text, 'pro') !== false || stripos($type, 'pro') !== false || get_post_meta($post_id, 'app_type', true) == 1)
    ];
}

$app_logo_url = get_the_post_thumbnail_url($post_id, 'thumbnail');
if (empty($app_logo_url)) {
    $app_logo_url = 'https://placehold.co/150x150/0052e0/ffffff?text=App';
}
?>

<!-- Secure Multi-Server Download Enlaces -->
<section id="download-section" class="space-y-6">
  <style>
    .dropdown-transition {
      transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .chevron-rotate {
      transition: transform 0.3s ease;
    }
  </style>

  <?php if (!empty($formatted_links)) : ?>
    <div class="border border-blue-100 dark:border-blue-900/30 rounded-2xl p-5 bg-[#fafcff] dark:bg-slate-900/40 space-y-4">
      <!-- Header with Cloud Secure Icon -->
      <div class="flex items-start space-x-3.5 text-left">
        <div class="bg-[#edf5ff] dark:bg-blue-950/60 text-[#0066fe] dark:text-blue-400 p-3 rounded-xl shadow-inner shrink-0 flex items-center justify-center">
          <i data-lucide="download-cloud" class="w-6 h-6"></i>
        </div>
        <div class="space-y-1">
          <span class="font-bold text-slate-900 dark:text-white text-base">Enlaces de Descarga Seguros</span>
          <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
            Seleccione el servidor de su preferencia para descargar <strong class="text-slate-700 dark:text-slate-200"><?php echo esc_html($app_name); ?></strong>. Todos nuestros archivos han sido validados con VirusTotal.
          </p>
        </div>
      </div>

      <!-- Mini App Icon Card -->
      <div class="bg-white dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800/50 rounded-xl p-4 flex items-center space-x-4 shadow-sm text-left">
        <div class="bg-blue-50 text-blue-600 h-12 w-12 rounded-xl flex items-center justify-center font-bold text-xl shadow-sm border border-blue-100 shrink-0">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="zap" aria-hidden="true" class="lucide lucide-zap w-6 h-6 text-blue-600 fill-blue-600"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg>
        </div>
        <div class="space-y-1.5 flex-grow">
          <h5 class="font-bold text-slate-800 dark:text-white text-sm leading-none" id="activeAppName"><?php echo esc_html($app_name); ?></h5>
          <div class="flex flex-wrap gap-1.5 items-center">
            <span id="activeBadge" class="bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800/40 text-blue-600 dark:text-blue-400 font-bold text-[10px] px-2 py-0.5 rounded-full">v<?php echo esc_html($app_version); ?></span>
            <span id="activeSize" class="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/40 text-slate-600 dark:text-slate-400 font-semibold text-[10px] px-2 py-0.5 rounded-full"><?php echo esc_html($app_size); ?></span>
            <span id="activeModBadge" class="border border-purple-200 dark:border-purple-900/40 text-purple-600 dark:text-purple-400 font-bold text-[10px] px-2 py-0.5 rounded-full bg-purple-50 dark:bg-purple-950/40 hidden">Pro</span>
          </div>
        </div>
      </div>

      <!-- Main Interactive Download Button -->
      <a href="#" id="mainDownloadBtn" class="w-full bg-[#0066fe] hover:bg-[#0053cf] text-white py-3.5 px-4 rounded-xl font-bold text-sm tracking-wide flex items-center justify-center space-x-2 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/35 transition-all duration-150 transform active:scale-[0.98] no-underline hover:no-underline">
        <i data-lucide="download" class="w-4 h-4"></i>
        <span id="mainDownloadBtnText">Descargar v<?php echo esc_html($app_version); ?></span>
      </a>

      <!-- Dynamic Dropdown and Other Versions -->
      <div id="dropdownWrapper" class="space-y-2 hidden">
        <!-- Toggle Button -->
        <button onclick="toggleDownloadDropdown()" class="w-full py-2.5 flex items-center justify-center space-x-1.5 text-[#0066fe] dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-bold text-xs transition duration-150">
          <span id="dropdownToggleText">Otras versiones</span>
          <i id="downloadChevronIcon" data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-300"></i>
        </button>

        <!-- Collapsible Versions Wrapper -->
        <div id="downloadDropdownContainer" class="grid dropdown-transition grid-rows-[0fr] opacity-0 overflow-hidden">
          <div class="min-h-0 space-y-2 pt-1 pb-2" id="downloadDropdownList">
            <!-- Dynamic Version Rows Will Inject Here -->
          </div>
        </div>
      </div>
    </div>

    <script>
      (function() {
        const downloadVersions = <?php echo json_encode($formatted_links); ?>;
        if (!downloadVersions || downloadVersions.length === 0) return;

        let activeVersionId = downloadVersions[0].id;
        let isDropdownOpen = false;

        function renderComponent() {
          const activeObj = downloadVersions.find(v => v.id === activeVersionId);
          if (!activeObj) return;

          // Update Main Download Link & Text
          const mainBtn = document.getElementById('mainDownloadBtn');
          const mainBtnText = document.getElementById('mainDownloadBtnText');
          if (mainBtn && mainBtnText) {
            mainBtn.setAttribute('href', activeObj.url);
            mainBtnText.textContent = `Descargar v${activeObj.version} (${activeObj.text})`;
          }

          // Update badges
          const activeBadge = document.getElementById('activeBadge');
          const activeSize = document.getElementById('activeSize');
          const activeModBadge = document.getElementById('activeModBadge');

          if (activeBadge) activeBadge.textContent = 'v' + activeObj.version;
          if (activeSize) activeSize.textContent = activeObj.size;
          
          if (activeModBadge) {
            if (activeObj.mod) {
              activeModBadge.textContent = activeObj.mod;
              activeModBadge.classList.remove('hidden');
            } else if (activeObj.isPro) {
              activeModBadge.textContent = 'Pro';
              activeModBadge.classList.remove('hidden');
            } else {
              activeModBadge.classList.add('hidden');
            }
          }

          // Filter options for dropdown (exclude current)
          const otherVersions = downloadVersions.filter(v => v.id !== activeVersionId);
          const dropdownWrapper = document.getElementById('dropdownWrapper');

          if (dropdownWrapper) {
            if (otherVersions.length > 0) {
              dropdownWrapper.classList.remove('hidden');
              const toggleText = document.getElementById('dropdownToggleText');
              if (toggleText) {
                toggleText.textContent = `Otras versiones (${otherVersions.length})`;
              }
            } else {
              dropdownWrapper.classList.add('hidden');
            }
          }

          const listContainer = document.getElementById('downloadDropdownList');
          if (listContainer) {
            listContainer.innerHTML = '';
            otherVersions.forEach(version => {
              const row = document.createElement('div');
              row.className = 'bg-white dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800/50 hover:border-blue-300 dark:hover:border-blue-800/50 hover:bg-blue-50/20 dark:hover:bg-blue-950/20 rounded-xl p-3 flex items-center justify-between transition cursor-pointer group shadow-sm text-left';
              
              row.addEventListener('click', function() {
                selectVersion(version.id);
              });

              let badgeHtml = '';
              if (version.mod) {
                badgeHtml = `<span class="border border-purple-200 dark:border-purple-900/40 text-purple-600 dark:text-purple-400 text-[9px] font-extrabold px-1.5 py-0.2 rounded bg-purple-50 dark:bg-purple-950/40">${version.mod}</span>`;
              } else if (version.isPro) {
                badgeHtml = `<span class="border border-purple-200 dark:border-purple-900/40 text-purple-600 dark:text-purple-400 text-[9px] font-extrabold px-1.5 py-0.2 rounded bg-purple-50 dark:bg-purple-950/40">Pro</span>`;
              }

              row.innerHTML = `
                <div class="flex items-center space-x-3">
                  <span class="text-blue-600 dark:text-blue-400 font-bold text-xs select-none">${version.text}</span>
                  <span class="text-slate-400 dark:text-slate-500 text-[10px] font-semibold">v${version.version}</span>
                  <span class="text-slate-400 dark:text-slate-500 text-[10px] font-semibold">${version.size}</span>
                  ${badgeHtml}
                </div>
                <button class="bg-blue-50 dark:bg-blue-950/50 group-hover:bg-blue-600 dark:group-hover:bg-blue-600 group-hover:text-white text-blue-600 dark:text-blue-400 p-1.5 rounded-lg transition duration-150 flex items-center justify-center">
                  <i data-lucide="download" class="w-3.5 h-3.5"></i>
                </button>
              `;
              listContainer.appendChild(row);
            });
          }

          // Handle Dropdown animation & icon rotation
          const dropdownWrap = document.getElementById('downloadDropdownContainer');
          const chevron = document.getElementById('downloadChevronIcon');
          if (dropdownWrap && chevron) {
            if (isDropdownOpen) {
              dropdownWrap.style.gridTemplateRows = '1fr';
              dropdownWrap.style.opacity = '1';
              chevron.style.transform = 'rotate(180deg)';
            } else {
              dropdownWrap.style.gridTemplateRows = '0fr';
              dropdownWrap.style.opacity = '0';
              chevron.style.transform = 'rotate(0deg)';
            }
          }

          // Re-trigger Lucide icon instantiation
          if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons();
          }
        }

        window.toggleDownloadDropdown = function() {
          isDropdownOpen = !isDropdownOpen;
          renderComponent();
        };

        window.selectVersion = function(versionId) {
          activeVersionId = versionId;
          isDropdownOpen = true; // keep open
          renderComponent();
        };

        // Initial render
        document.addEventListener('DOMContentLoaded', function() {
          renderComponent();
        });
      })();
    </script>
  <?php else : ?>
    <div class="text-center p-8 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800">
      <p class="text-sm text-slate-400 font-semibold">No hay enlaces de descarga disponibles en este momento.</p>
    </div>
  <?php endif; ?>
</section>