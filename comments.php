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
<section id="comments" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
    <?php if (post_password_required()) : ?>
        <div class="p-4 bg-red-100 text-red-700 dark:text-gray-300 rounded">
            <?php _e('This post is password protected. Enter the password to view comments', 'apktemplates'); ?>
        </div>
    <?php return;
    endif; ?>

    <?php if (have_comments()) : ?>
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-6">
            <?php _e('Comments', 'apktemplates'); ?>
        </h2>

        <div class="mb-12">
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
            <p class="text-sm text-gray-500 dark:text-gray-200"><?php _e('Comments are closed.', 'apktemplates'); ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $args = [
        'fields' => [
            'author' => '<input id="author" name="author" type="text" placeholder="Name" class="w-full p-2 border-2 border-gray-200 dark:border-gray-700 dark:focus:border-green-400 rounded-lg focus:outline-none focus:border-primary mb-3 text-md dark:text-gray-300" value="' . esc_attr($commenter['comment_author']) . '" required />',
            'email'  => '<input id="email" name="email" type="email" placeholder="Email" class="w-full p-2 border-2 border-gray-200 dark:border-gray-700 dark:focus:border-green-400 rounded-lg focus:outline-none focus:border-primary mb-3 text-md dark:text-gray-300" value="' . esc_attr($commenter['comment_author_email']) . '" required />',
        ],
        'comment_field' =>
        '<textarea id="comment" name="comment" placeholder="Add a comment..." class="w-full p-3 border-2 border-gray-200 dark:border-gray-700 dark:focus:border-green-400 rounded-lg resize-none focus:outline-none focus:border-primary text-md mb-3 dark:text-gray-300" rows="3" required></textarea>',
        'submit_button' =>
        '<button type="submit" class="cursor-pointer uppercase bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition">' . __('Post Comment', 'apktemplates') . '</button>',
        'title_reply' => __('Leave a Comment', 'apktemplates'),
        'title_reply_before' => '<h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-6">',
        'title_reply_after'  => '</h2>',
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
    ];
    comment_form($args);
    ?>
</section>