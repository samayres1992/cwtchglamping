<textarea class="widefat add-quote-message" name="add-quote-message"></textarea>
<button class="add-message-button"><?php esc_html_e('ADD MESSAGE', 'redq-rental') ?></button>

<?php
$quote_id = $post->ID;
// Remove the comments_clauses where query here.
remove_filter('comments_clauses', 'exclude_request_quote_comments_clauses');
$args = array(
    'post_id' => $quote_id,
    'orderby' => 'comment_ID',
    'order'   => 'DESC',
    'approve' => 'approve',
    'type'    => 'quote_message'
);
$comments = get_comments($args); ?>
<ul class="quote-message">
    <?php foreach ($comments as $comment) : ?>
        <?php
        $list_class = 'message-list';
        $content_class = 'quote-message-content';
        if ($comment->user_id === get_post_field('post_author', $quote_id)) {
            $list_class .= ' customer';
            $content_class .= ' customer';
        }
        ?>
        <li class="<?php echo $list_class ?>">
            <div class="<?php echo $content_class ?>">
                <?php echo wpautop(wptexturize(wp_kses_post($comment->comment_content))); ?>
            </div>
            <p class="meta">
                <abbr class="exact-date" title="<?php echo $comment->comment_date; ?>"><?php printf(__('added on %1$s at %2$s', 'redq-rental'), date_i18n(wc_date_format(), strtotime($comment->comment_date)), date_i18n(wc_time_format(), strtotime($comment->comment_date))); ?></abbr>
                <?php printf(' ' . __('by %s', 'redq-rental'), $comment->comment_author); ?>
                <!-- <a href="#" class="delete-message"><?php _e('Delete', 'redq-rental'); ?></a> -->
            </p>
        </li>
    <?php endforeach; ?>
</ul>