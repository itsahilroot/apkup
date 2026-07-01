<style>
    ul.children .comment {
        margin-left: 1.5rem;
    }

    #respond.comment-respond {
        margin-bottom: 2rem;
    }

    .comment-form-cookies-consent {
        margin: .5rem 0;
    }

    .dark .comment-form-cookies-consent {
        color: #e5e7eb;
    }
</style>
<section id="comments-section" class="p-6 sm:p-8 bg-white dark:bg-brand-darkCard rounded-[32px] border border-slate-200/50 dark:border-white/5 space-y-6 my-6">
    <?php if (post_password_required()) : ?>
        <div class="p-4 bg-red-100 text-red-700 dark:text-gray-300 rounded-2xl">
            <?php _e('This post is password protected. Enter the password to view comments', 'apkup'); ?>
        </div>
    <?php return;
    endif; ?>

    <?php if (have_comments()) : ?>
        <h2 class="text-lg font-bold text-slate-800 dark:text-white">
            Foro de Comentarios (<?php echo get_comments_number(); ?>)
        </h2>

        <div class="mb-12 space-y-4">
            <?php
            wp_list_comments([
                'type'     => 'comment',
                'callback' => 'apkup_comments_list'
            ]);
            ?>
        </div>
        <?php
        $total_pages   = get_comment_pages_count();
        $current_page  = get_query_var('cpage') ? intval(get_query_var('cpage')) : 1;

        if ($total_pages > 1) {
            apkup_comments_pagination($current_page, $total_pages);
        }
        ?>
    <?php else : ?>
        <?php if (!comments_open()) : ?>
            <p class="text-sm text-slate-400 dark:text-slate-500 font-semibold"><?php _e('Comments are closed.', 'apkup'); ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $commenter = wp_get_current_commenter();
    $consent   = empty( $commenter['comment_author_email'] ) ? '' : 'yes';
    $app_name = get_the_title();

    $args = [
        'fields' => [
            'author' => '<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <input id="author" name="author" type="text" placeholder="Nombre completo" aria-label="Nombre completo del autor" class="w-full p-3 border-2 border-slate-100 dark:border-slate-850 dark:bg-slate-900/60 dark:focus:border-primary/80 rounded-2xl focus:outline-none focus:border-primary text-sm dark:text-gray-300" value="' . esc_attr($commenter['comment_author']) . '" required />',
            'email'  => '<input id="email" name="email" type="email" placeholder="Correo electrónico (Privado)" aria-label="Correo electrónico del autor (será privado)" class="w-full p-3 border-2 border-slate-100 dark:border-slate-850 dark:bg-slate-900/60 dark:focus:border-primary/80 rounded-2xl focus:outline-none focus:border-primary text-sm dark:text-gray-300" value="' . esc_attr($commenter['comment_author_email']) . '" required />
            </div>',
            'cookies' => '<div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-4">
                <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" class="w-4 h-4 rounded text-primary focus:ring-primary cursor-pointer" ' . checked( $consent, 'yes', false ) . ' />
                <label for="wp-comment-cookies-consent" class="cursor-pointer">Guardar mis datos en este navegador para la próxima vez que comente.</label>
            </div>',
        ],
        'comment_field' =>
        '<div class="mb-4">
            <textarea id="comment" name="comment" placeholder="Añade tu reseña pública sobre ' . esc_attr($app_name) . '..." aria-label="Escribe tu comentario u opinión" class="w-full p-4 border-2 border-slate-100 dark:border-slate-850 dark:bg-slate-900/60 dark:focus:border-primary/80 rounded-2xl resize-none focus:outline-none focus:border-primary text-sm dark:text-gray-300 h-28" required></textarea>
        </div>',
        'submit_button' =>
        '<button type="submit" class="px-6 py-3 bg-primary hover:opacity-95 text-white font-semibold rounded-xl text-xs uppercase tracking-wider cursor-pointer transition-colors border-none outline-none">' . __('Publicar Opinión', 'apkup') . '</button>',
        'title_reply' => 'Publicar un Comentario',
        'title_reply_before' => '<h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4">',
        'title_reply_after'  => '</h2>',
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
        'class_form' => 'space-y-4',
    ];
    comment_form($args);
    ?>
</section>