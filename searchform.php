<?php $unique_id = esc_attr(uniqid('form-search-')); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text" for="<?php echo $unique_id; ?>"><?php echo _x('Search for:', 'label', 'joompress'); ?></label>
    <input class="search-field form-field" type="search" name="s" id="<?php echo $unique_id; ?>"
           placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'joompress'); ?>"
           value="<?php echo get_search_query(); ?>" required>
    <button class="search-btn btn btn-primary" type="submit"><?php echo _x('Search', 'submit button', 'joompress'); ?></button>
</form>
