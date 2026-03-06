<?php
// Archive posts top 10 box

$post_id = get_the_ID();
$app_url = get_the_permalink($post_id);
$app_name = get_the_title();

$data = get_post_meta($post_id, 'datos_informacion', true);
$data = is_array($data) ? $data : [];
$app_version = $data['version'] ?? '';
$app_requires = $data['requerimientos'] ?? '';

$app_logo_full = get_the_post_thumbnail_url($post_id, 'full');

$is_app_mod = get_post_meta($post_id, 'app_type', true);
?>
<a href="<?php echo esc_url($app_url); ?>" class="flex-shrink-0 w-80 bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 relative">
    <article class="flex flex-col w-full h-full">
    <div class="card-number"><?php echo $args['rank']; ?></div>
    <?php if($is_app_mod == '1') : ?>
    <div class="absolute top-3 right-3 px-2 py-1 bg-orange-100 text-orange-700 dark:bg-orange-700 dark:text-orange-100 text-xs font-semibold rounded uppercase tracking-wider">
        MOD
    </div>
    <?php endif; ?>
    <div class="flex items-center gap-3">
        <div class="w-32 h-32 flex items-center justify-center flex-shrink-0 shadow-lg rounded-2xl">
            <img src="<?php echo esc_url($app_logo_full); ?>" alt="<?php echo $app_name; ?>" class="rounded-2xl">
        </div>
        <div class="flex-1 min-w-0">
            <h3 class="font-semibold text-gray-800 dark:text-gray-200 text-base truncate"><?php echo $app_name; ?></h3>
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-300">
                <span class="text-gray-400 dark:text-gray-300 trunctae">v<?php echo $app_version; ?></span>
                <span class="whitespace-nowrap truncate">Android <?php echo apkup_extract_number($app_requires) ?: '8.0'; ?>+</span>
            </div>
        </div>
    </div>
    </article>
</a>