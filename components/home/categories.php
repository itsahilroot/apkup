<?php
$categories = get_categories(array(
    'hide_empty' => true,
));
?>
<section class="relative mb-12">
    <header class="flex items-center justify-between mb-6 relative">
        <div class="flex items-center gap-3">
            <h2 class="text-3xl font-bold tracking-tight drop-shadow-lg flex items-center space-x-2">
                <span class="text-black dark:text-gray-200">Categorías</span>
            </h2>
        </div>
    </header>
    <div class="flex gap-4 overflow-x-auto pb-2">
        <?php foreach ($categories as $cat) :
            $cat_link = get_category_link($cat->term_id);
            $cat_name = $cat->name;
            $cat_count = $cat->count;

            $cat_icon = get_term_meta($cat->term_id, 'category_icon', true);

            if (empty($cat_icon)) {
                $cat_icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>';
            } else {
                $cat_icon = '<img src="' . esc_url($cat_icon) . '" alt="' . esc_attr($cat_name) . '" class="h-6 w-6">';
            }
        ?>
            <a href="<?php echo esc_url($cat_link); ?>" class="group flex-shrink-0 w-40">
                <div class="h-full p-4 rounded-xl bg-green-50 dark:bg-gray-800 border border-green-200 dark:border-gray-700 hover:border-green-400 dark:hover:border-green-400 transition-colors flex flex-col items-center text-center">
                    <div class="w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center mb-3 group-hover:bg-green-200 dark:group-hover:bg-green-800 transition-colors">
                        <?php echo $cat_icon; ?>
                    </div>
                    <h3 class="font-medium text-gray-800 dark:text-gray-200 truncate">
                        <?php echo esc_html($cat_name); ?>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">
                        <?php echo esc_html($cat_count); ?> apps
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>