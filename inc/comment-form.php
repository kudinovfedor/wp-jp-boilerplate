<?php

/** Update textarea for comments */
function joompress_comment_form_defaults($defaults) {
  $defaults['comment_field'] = '<div class="form__row comment-form-comment"><label for="comment" class="screen-reader-text">' . _x('Comment', 'noun', 'joompress') . '</label> <textarea id="comment" class="form__field" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required" placeholder="' . _x('Comment', 'noun', 'joompress') . '"></textarea></div>';

  return $defaults;
}

add_filter('comment_form_defaults', 'joompress_comment_form_defaults');

/** Remove the Comment URL Field and Update other */
function joompress_comment_fields($fields) {
  $req = get_option('require_name_email');
  $aria_req = ($req ? " aria-required='true'" : '');
  $html_req = ($req ? " required='required'" : '');
  $commenter = wp_get_current_commenter();

  $fields = array(
    'author' => '<div class="form__row comment-form-author">' . '<label for="author" class="form__label">' . __('Name', 'joompress') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
      '<input id="author" class="form__field" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245"' . $aria_req . $html_req . '></div>',
    'email' => '<div class="form__row comment-form-email"><label for="email" class="form__label">' . __('Email', 'joompress') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
      '<input id="email" class="form__field" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req . '></div>',
    'url' => '<div class="form__row comment-form-url"><label for="url" class="form__label">' . __('Website', 'joompress') . '</label> ' .
      '<input id="url" class="form__field" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200"></div>',
  );

  if (isset($fields['url'])) {
    unset($fields['url']);
  }

  return $fields;

}

add_filter('comment_form_default_fields', 'joompress_comment_fields');
