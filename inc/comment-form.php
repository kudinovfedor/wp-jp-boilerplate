<?php

/**
 * Remove the Comment URL Field and Update other
 *
 * @param $fields
 *
 * @return array
 */
function jp_comment_fields($fields)
{

    $req       = get_option('require_name_email');
    $aria_req  = ($req ? " aria-required='true'" : '');
    $html_req  = ($req ? " required='required'" : '');
    $commenter = wp_get_current_commenter();

    $fields = array(
        'author' => '<div class="form-row comment-form-author">' . '<label for="author" class="form-label">' . __('Name', 'joompress') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
                    '<input id="author" class="form-field" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245"' . $aria_req . $html_req . '></div>',
        'email' => '<div class="form-row comment-form-email"><label for="email" class="form-label">' . __('Email', 'joompress') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
                   '<input id="email" class="form-field" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req . '></div>',
        'url' => '<div class="form-row comment-form-url"><label for="url" class="form-label">' . __('Website', 'joompress') . '</label> ' .
                 '<input id="url" class="form-field" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200"></div>',
    );

    if (isset($fields['url'])) {
        unset($fields['url']);
    }

    return $fields;

}

add_filter('comment_form_default_fields', 'jp_comment_fields');

/**
 * Update textarea for comments
 *
 * @param $defaults
 *
 * @return mixed
 */
function jp_comment_form_defaults($defaults)
{
    $label = sprintf('<label for="comment" class="screen-reader-text">%s</label>', _x('Comment', 'noun', 'joompress'));

    $textarea = sprintf(
        '<textarea id="comment" class="form-field" name="comment" cols="45" rows="8" maxlength="65525" placeholder="%s" required aria-required="true"></textarea>',
        _x('Comment', 'noun', 'joompress')
    );

    $defaults['comment_field'] = sprintf('<div class="form-row comment-form-comment">%s %s</div>', $label, $textarea);

    return $defaults;
}

add_filter('comment_form_defaults', 'jp_comment_form_defaults');
