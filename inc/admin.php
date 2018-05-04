<?php

/**
 * Text displayed in the admin footer
 *
 * @return void
 */
function jp_admin_footer_text()
{
    $developed_by = sprintf(
        '%s: <strong><a href="https://joompress.biz" target="_blank">%s</a></strong>',
        __('Developed by', 'joompress'),
        __('JoomPress.biz', 'joompress')
    );

    $php_version = sprintf(
        '%s: <b style="color: #080;">%s</b>',
        __('Running PHP version', 'joompress'),
        phpversion()
    );

    $queries = sprintf(
        __('%d queries in %s sec', 'joompress'),
        get_num_queries(),
        timer_stop(0, 3)
    );

    $memory = sprintf(
        __('Using %d Mb memory (including unused pages %d Mb).', 'joompress'),
        round(memory_get_usage() / 1024 / 1024, 2),
        round(memory_get_usage(true) / 1024 / 1024, 2)
    );

    $output = sprintf(
        '<span id="footer-thankyou">%s</span><br>%s<br>%s<br>%s',
        $developed_by,
        $php_version,
        $queries,
        $memory
    );

    echo $output;
}

add_filter('admin_footer_text', 'jp_admin_footer_text');

/**
 * The info about developer, version/update text displayed in the admin footer.
 *
 * @return void
 */
function jp_update_footer()
{
    $social = sprintf(
        'vk.com: <a href="https://vk.com/id29713764" target="_blank">%s</a>',
        __('Kudinov Fedor', 'joompress')
    );

    $email = sprintf(
        '%s: <a href="mailto:admin@joompress.biz" target="_blank">admin@joompress.biz</a>',
        __('Email', 'joompress')
    );

    $tel = sprintf(
        '%s: <a href="tel:%s" target="_blank">+38 (066) 43-15-291</a>',
        __('Tel', 'joompress'),
        get_phone_number('+38 (066) 43-15-291')
    );

    $output = sprintf('%s<br>%s<br>%s<br>', $social, $email, $tel);

    echo $output;

    core_update_footer();
}

add_filter('update_footer', 'jp_update_footer', 10);

/**
 * PHP version
 *
 * @param string $content Default text
 *
 * @return string
 */
function jp_php_version($content)
{
    $php_version = sprintf(
        '<br>%s: <b style="color: #080;">%s</b>',
        __('Running PHP version', 'joompress'),
        phpversion()
    );

    return $content . $php_version;
}

add_filter('update_right_now_text', 'jp_php_version');
