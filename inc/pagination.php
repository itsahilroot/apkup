<?php
function apkup_pagination($current_page, $total_pages) {
    if ($total_pages <= 1) {
        return '';
    }
    
    $max_num_pages = 5;
    
    $start_page = max(1, $current_page - floor($max_num_pages / 2));
    $end_page = min($total_pages, $start_page + $max_num_pages - 1);
    $start_page = max(1, $end_page - $max_num_pages + 1);
 
    $html  = '<div class="pagination flex items-center justify-center gap-2 select-none mt-6">';
 
    if ($current_page > 1) {
        $html .= '<a href="' . get_pagenum_link($current_page - 1) . '" class="w-10 h-10 rounded-xl border border-slate-200/50 dark:border-white/5 flex items-center justify-center text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-white bg-white/50 dark:bg-slate-900/50 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all font-semibold text-xs shadow-sm">&laquo;</a>';
    }
 
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            $html .= '<span class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white transition-all font-bold text-xs shadow-sm shadow-primary/20">' . $i . '</span>';
        } else {
            $html .= '<a href="' . get_pagenum_link($i) . '" class="w-10 h-10 rounded-xl border border-slate-200/50 dark:border-white/5 flex items-center justify-center text-slate-600 hover:text-primary dark:text-slate-400 dark:hover:text-white bg-white/50 dark:bg-slate-900/50 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all font-semibold text-xs shadow-sm">' . $i . '</a>';
        }
    }
 
    if ($current_page < $total_pages) {
        $html .= '<a href="' . get_pagenum_link($current_page + 1) . '" class="w-10 h-10 rounded-xl border border-slate-200/50 dark:border-white/5 flex items-center justify-center text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-white bg-white/50 dark:bg-slate-900/50 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all font-semibold text-xs shadow-sm">&raquo;</a>';
    }
 
    $html .= '</div>';
 
    return $html;
}

function apkup_comments_pagination($current_page, $total_pages) {
    if ($total_pages <= 1) {
        return '';
    }

    $max_num_pages = 3;
    $start_page = max(1, $current_page - floor($max_num_pages / 2));
    $end_page   = min($total_pages, $start_page + $max_num_pages - 1);
    $start_page = max(1, $end_page - $max_num_pages + 1);

    $html  = '<div class="pagination mt-4 mb-8 flex space-x-1 justify-center">';

    // Prev
    if ($current_page > 1) {
        $html .= '<a href="' . esc_url(get_comments_pagenum_link($current_page - 1)) . '" class="min-w-9 rounded-full border-2 border-primary dark:border-gray-700 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-primary dark:text-primary hover:text-white hover:bg-primary hover:border-primary ml-2 hover:text-white dark:hover:border-primary/80 dark:hover:text-gray-600 dark:hover:bg-primary/80 dark:border-primary">Prev</a>';
    }

    // Pages
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            $html .= '<span class="min-w-9 rounded-full bg-primary py-2 px-3.5 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg dark:bg-primary ml-2">' . esc_html($i) . '</span>';
        } else {
            $html .= '<a href="' . esc_url(get_comments_pagenum_link($i)) . '" class="min-w-9 rounded-full border-2 border-primary dark:border-gray-700 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-primary dark:text-primary hover:text-white hover:bg-primary hover:border-primary ml-2 hover:text-white dark:hover:border-primary/80 dark:hover:text-gray-600 dark:hover:bg-primary/80 dark:border-primary">' . esc_html($i) . '</a>';
        }
    }

    // Next
    if ($current_page < $total_pages) {
        $html .= '<a href="' . esc_url(get_comments_pagenum_link($current_page + 1)) . '" class="min-w-9 rounded-full border-2 border-primary dark:border-gray-700 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-primary dark:text-primary hover:text-white hover:bg-primary hover:border-primary ml-2 hover:text-white dark:hover:border-primary/80 dark:hover:text-gray-600 dark:hover:bg-primary/80 dark:border-primary">Next</a>';
    }

    $html .= '</div>';

    echo $html;
}