<?php
function apkup_comments_list($comment, $args, $depth)
{
    $author = get_comment_author($comment);
    $avatar = get_avatar($comment, 40, '', '', ['class' => 'w-8 h-8 rounded-full']);
    $date   = get_comment_date('', $comment);
?>

    <div id="comment-<?php comment_ID(); ?>" <?php comment_class("comment border-l-2 border-primary pl-4 mb-8"); ?>>
        <div class="flex gap-3">
            <div><?php echo $avatar; ?></div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-medium text-gray-900 dark:text-gray-200 text-md font-semibold"><?php echo esc_html($author); ?></span>
                    <time datetime="<?php comment_time('c'); ?>" class="text-gray-400 dark:text-gray-300 text-sm">
                        <?php echo esc_html($date); ?>
                    </time>
                </div>
                <div class="text-gray-700 dark:text-gray-300 text-md mb-2">
                    <?php if ($comment->comment_approved == '0'): ?>
                        <p style="color:red; font-size: 16px; margin: .5rem 0;"><strong><?php _e('Please wait for aproval', 'apktemplates'); ?></strong></p>
                    <?php endif; ?>
                    <?php comment_text(); ?>
                </div>
                <?php if ($comment->comment_approved == '1'): ?>
                <div class="flex items-center gap-4 text-xs">
                    <button class="like-btn flex items-center gap-1 text-gray-500 dark:text-gray-300 hover:text-secondary transition cursor-pointer"
                        data-comment-id="<?php comment_ID(); ?>">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 000-6.364 4.5 4.5 0 00-6.364 0L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="like-count"><?php echo (int) get_comment_meta(get_comment_ID(), 'apkup_likes', true); ?></span>
                    </button>

                    <?php
                    comment_reply_link(array_merge($args, [
                        'depth'      => $depth,
                        'max_depth'  => $args['max_depth'],
                        'reply_text' => __('Reply', 'apktemplates'),
                        'class'      => 'text-gray-500 hover:text-primary transition'
                    ]));
                    ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php
}

//Enqueue comment reply
function apktemplates_enqueue_comment_reply()
{
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'apktemplates_enqueue_comment_reply');

//alt value for comment avatr
function apktemplates_comment_avatar_alt($apktemplates_comment_avatar_alt)
{
    if (have_comments()) {
        $alt = get_comment_author();
    } else {
        $alt = get_the_author_meta('display_name');
    }
    $apktemplates_comment_avatar_alt = str_replace('alt=\'\'', 'alt=\'' . $alt . ' avatar\' ', $apktemplates_comment_avatar_alt);
    return $apktemplates_comment_avatar_alt;
}
add_filter('get_avatar', 'apktemplates_comment_avatar_alt');

// Change Cancel Reply Link
function change_cancel_reply_text($html, $link, $text)
{
    $new_text = 'Cancel';
    return str_replace($text, $new_text, $html);
}
add_filter('cancel_comment_reply_link', 'change_cancel_reply_text', 10, 3);

//Remove Logged in as text, edit profile link
add_filter('comment_form_logged_in', '__return_empty_string');
// title reply text remove
function custom_comment_form_title($args)
{
    $args['title_reply_before'] = '<h2 class="text-2xl font-bold text-gray-700 mb-6">Leave a Comment</h2>';
    $args['title_reply'] = '';
    return $args;
}
add_filter('comment_form_defaults', 'custom_comment_form_title');
