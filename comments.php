<?php if (post_password_required()) {
    return;
} ?>

<div id="comments" class="comments">

    <?php if (have_comments()) : ?>

        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ('1' === $comments_number) {
                printf(_x('One Reply to &ldquo;%s&rdquo;', 'comments title', 'joompress'), get_the_title());
            } else {
                printf(
                    _nx(
                        '%1$s Reply to &ldquo;%2$s&rdquo;',
                        '%1$s Replies to &ldquo;%2$s&rdquo;',
                        $comments_number,
                        'comments title',
                        'joompress'
                    ),
                    number_format_i18n($comments_number),
                    get_the_title()
                );
            }
            ?>
        </h2>

        <ul class="comment-list">
            <?php wp_list_comments([
                'walker' => new JPWalkerComment,
                'style' => 'ul',
                'avatar_size' => 40,
                'short_ping' => true,
            ]); ?>
        </ul>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <div class="text-center"><?php jp_comments_pagination(); ?></div>
        <?php endif; ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php _e('Comments are closed.', 'joompress'); ?></p>
    <?php endif; ?>

    <?php comment_form([
        'class_submit' => 'btn btn-primary',
        'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
    ]); ?>

</div>
