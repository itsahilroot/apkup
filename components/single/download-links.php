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
?>
<!-- Secure Multi-Server Download Enlaces -->
<section id="download-section" class="p-6 sm:p-8 bg-white dark:bg-brand-darkCard rounded-[32px] border border-slate-200/50 dark:border-white/5 space-y-6">
  <div class="text-center sm:text-left space-y-2">
    <h2 class="text-lg font-bold text-slate-800 dark:text-white flex items-center justify-center sm:justify-start gap-2">
      <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"></path>
      </svg>
      Enlaces de Descarga Seguros
    </h2>
    <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold">
      Seleccione el servidor de su preferencia para descargar <?php echo esc_html($app_name); ?>. Todos nuestros archivos han sido validados con VirusTotal.
    </p>
  </div>

  <?php if (!empty($links)) : ?>
    <div class="flex overflow-x-auto md:grid md:grid-cols-2 gap-4 no-scrollbar pb-3 md:pb-0 -mx-4 px-4 md:mx-0 md:px-0 snap-x snap-mandatory">
      <?php foreach ($links as $index => $dl) : 
          $download_url = get_permalink() . 'download/' . $index;
          $text = !empty($dl['texto']) ? $dl['texto'] : (!empty($dl['type']) ? $dl['type'] : 'APK');
          $type = !empty($dl['type']) ? $dl['type'] : 'Server';
          
          // Detect Server Type for custom styling
          $is_mediafire = (stripos($text, 'mediafire') !== false || stripos($type, 'mediafire') !== false);
          $is_mega = (stripos($text, 'mega') !== false || stripos($type, 'mega') !== false);
          
          $icon_color = 'bg-primary/10 text-primary';
          $btn_color = 'bg-primary hover:opacity-95';
          $icon_svg = '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>'; // Zap Icon
          
          if ($is_mediafire) {
              $icon_color = 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-500';
              $btn_color = 'bg-emerald-600 hover:bg-emerald-700';
              $icon_svg = '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>';
          } elseif ($is_mega) {
              $icon_color = 'bg-blue-100 dark:bg-blue-500/10 text-blue-500';
              $btn_color = 'bg-blue-600 hover:bg-blue-700';
              $icon_svg = '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>';
          }
      ?>
        <!-- Enlace Card -->
        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200/50 dark:border-white/5 flex flex-col sm:flex-row justify-between items-center gap-4 shrink-0 w-[290px] md:w-auto snap-center">
          <div class="flex items-center gap-4 w-full sm:w-auto">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 <?php echo $icon_color; ?>">
              <?php echo $icon_svg; ?>
            </div>
          <?php
          $link_version = !empty($dl['version']) ? $dl['version'] : $app_version;
          $link_size = !empty($dl['size']) ? $dl['size'] : $app_size;
          $link_mod = !empty($dl['mod_info']) ? $dl['mod_info'] : '';
          ?>
          <div class="text-center sm:text-left min-w-0">
              <h4 class="font-bold text-sm text-slate-800 dark:text-white truncate"><?php echo esc_html($text); ?> (<?php echo esc_html($type); ?>)</h4>
              <p class="text-xs text-slate-400 mt-1">
                  Servidor Rápido 
                  <?php if (!empty($link_version)) : ?>• v<?php echo esc_html($link_version); ?><?php endif; ?>
                  <?php if (!empty($link_size)) : ?>• <?php echo esc_html($link_size); ?><?php endif; ?>
                  <?php if (!empty($link_mod)) : ?>• <?php echo esc_html($link_mod); ?><?php endif; ?>
              </p>
          </div>
          </div>
          <a href="<?php echo esc_url($download_url); ?>" class="w-full sm:w-auto px-5 py-2.5 text-white text-xs font-semibold rounded-xl transition-all cursor-pointer flex items-center justify-center gap-1.5 <?php echo $btn_color; ?>">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Descargar
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else : ?>
    <div class="text-center p-8 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800">
      <p class="text-sm text-slate-400 font-semibold">No hay enlaces de descarga disponibles en este momento.</p>
    </div>
  <?php endif; ?>
</section>