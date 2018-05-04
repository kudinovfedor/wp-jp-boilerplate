<?php $unique_id = esc_attr(uniqid('search-form-')); ?>

<form role="search" method="get" class="form-search" action="<?php echo esc_url(home_url('/')); ?>">
  <label for="<?php echo $unique_id; ?>">
    <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'joompress'); ?></span>
  </label>
  <input class="form-field" type="search" name="s" id="<?php echo $unique_id; ?>" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'joompress'); ?>" value="<?php echo get_search_query(); ?>"/>
  <button class="btn btn-default" type="submit"><?php echo _x('Search', 'submit button', 'joompress'); ?></button>
</form>
