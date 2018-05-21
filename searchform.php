<?php $unique_id = esc_attr(uniqid('form-search-')); ?>

<div itemscope itemtype="http://schema.org/WebSite">
    <meta itemprop="url" content="<?php echo esc_url(home_url('/')); ?>">
    <form role="search" method="get" class="form-search" action="<?php echo esc_url(home_url('/')); ?>"
          itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
        <meta itemprop="target" content="<?php echo esc_url(home_url('/')); ?>?s={s}">
        <label class="screen-reader-text" for="<?php echo $unique_id; ?>"><?php echo _x('Search for:', 'label', 'joompress'); ?></label>
        <input class="form-field" type="search" name="s" itemprop="query-input" id="<?php echo $unique_id; ?>"
               placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'joompress'); ?>"
               value="<?php echo get_search_query(); ?>" required>
        <button class="btn btn-default" type="submit"><?php echo _x('Search', 'submit button', 'joompress'); ?></button>
    </form>
</div>
