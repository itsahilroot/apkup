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
    <div class="flex flex-wrap gap-3 pb-4 pt-2 px-1">
        <?php foreach ($categories as $cat) :
            $cat_link = get_category_link($cat->term_id);
            $cat_name = $cat->name;
        ?>
            <a href="<?php echo esc_url($cat_link); ?>" class="group flex-shrink-0">
                <div class="px-6 py-2.5 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 hover:bg-primary dark:hover:bg-green-500 hover:border-transparent transition-all duration-300 shadow-sm hover:shadow-lg transform hover:-translate-y-1">
                    <h3 class="font-bold text-sm text-gray-800 dark:text-gray-200 group-hover:text-white transition-colors whitespace-nowrap">
                        <?php echo esc_html($cat_name); ?>
                    </h3>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>