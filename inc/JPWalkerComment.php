<?php

if (!class_exists('JPWalkerComment')) {
    /**
     * Custom walker class used to create an HTML list of comments.
     *
     * @see Walker_Comment
     */
    class JPWalkerComment extends Walker_Comment
    {
        /**
         * What the class handles.
         *
         * @var string
         *
         * @see Walker::$tree_type
         */
        public $tree_type = 'comment';

        /**
         * Database fields to use.
         *
         * @var array
         *
         * @see Walker::$db_fields
         */
        public $db_fields = array('parent' => 'comment_parent', 'id' => 'comment_ID');

        /**
         * Starts the list before the elements are added.
         *
         * @see Walker::start_lvl()
         * @global int $comment_depth
         *
         * @param string $output Used to append additional content (passed by reference).
         * @param int $depth Optional. Depth of the current comment. Default 0.
         * @param array $args Optional. Uses 'style' argument for type of HTML list. Default empty array.
         */
        public function start_lvl(&$output, $depth = 0, $args = array())
        {
            $GLOBALS['comment_depth'] = $depth + 1;

            switch ($args['style']) {
                case 'div':
                    break;
                case 'ol':
                    $output .= '<ol class="comment-children">' . "\n";
                    break;
                case 'ul':
                default:
                    $output .= '<ul class="comment-children">' . "\n";
                    break;
            }
        }

        /**
         * Outputs a pingback comment.
         *
         * @see wp_list_comments()
         *
         * @param WP_Comment $comment The comment object.
         * @param int $depth Depth of the current comment.
         * @param array $args An array of arguments.
         */
        protected function ping($comment, $depth, $args)
        {
            $tag = ('div' == $args['style']) ? 'div' : 'li';
            ?>
            <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('', $comment); ?>>
            <div class="comment-body">
                <?php _e('Pingback', 'joompress'); ?>: <?php comment_author_link($comment); ?>
                <?php edit_comment_link(__('Edit', 'joompress'), '<span class="edit-link">', '</span>'); ?>
            </div>
            <?php
        }

        /**
         * Outputs a comment in the HTML5 format.
         *
         * @see wp_list_comments()
         *
         * @param WP_Comment $comment Comment to display.
         * @param int $depth Depth of the current comment.
         * @param array $args An array of arguments.
         */
        protected function html5_comment($comment, $depth, $args)
        {
            $tag = ('div' === $args['style']) ? 'div' : 'li';
            ?>
            <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>"
            <?php comment_class(array('comment-item', $this->has_children ? 'parent' : ''), $comment); ?>>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <div class="comment-meta">
                    <div class="comment-author">
                        <?php if (0 != $args['avatar_size']) {
                            echo get_avatar($comment, $args['avatar_size']);
                        } ?>
                        <?php printf(__('%s <span class="says">says:</span>', 'joompress'),
                            sprintf('<b class="comment-author-name">%s</b>', get_comment_author($comment))
                        ); ?>
                    </div>
                    <div class="comment-metadata">
                        <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                            <time datetime="<?php comment_time('c'); ?>"><?php printf(__('%1$s at %2$s', 'joompress'),
                                    get_comment_date('', $comment), get_comment_time()); ?></time>
                        </a>
                        <?php edit_comment_link(__('Edit', 'joompress'), '<span class="edit-link">', '</span>'); ?>
                    </div>
                    <?php if ('0' == $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.',
                                'joompress'); ?></p>
                    <?php endif; ?>
                </div>
                <div class="comment-content"><?php comment_text(); ?></div>
                <?php comment_reply_link(array_merge($args, array(
                    'add_below' => 'div-comment',
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'before' => '<div class="comment-reply">',
                    'after' => '</div>'
                ))); ?>
            </div>
            <?php
        }
    }
}
