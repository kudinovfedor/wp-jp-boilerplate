<?php

add_action('wp_enqueue_scripts', function () {

    wp_register_script('contact-form', get_template_directory_uri() . '/assets/js/contact-form.js', [], null, true);

    wp_localize_script('contact-form', 'jpAjax', [
        'action' => 'contact_form',
        'nonce' => wp_create_nonce('contact_form_action'),
        'url' => admin_url('admin-ajax.php'),
    ]);

    if (
        is_front_page()
        || is_page('contact')
        || is_page_template('page-contact.php')
    ) {
        wp_enqueue_script('contact-form');
    }
});

if (wp_doing_ajax()) {
    add_action('wp_ajax_contact_form', 'jp_ajax_contact_form_callback');
    add_action('wp_ajax_nopriv_contact_form', 'jp_ajax_contact_form_callback');
}

function jp_ajax_contact_form_callback()
{
    check_ajax_referer('contact_form_action', 'nonce');

    $field_names = [
        'email',
        'message',
        'name',
        'tel',
    ];

    $required_fields = [
        'email',
        'name',
        'tel'
    ];

    $data = [];

    $is_valid = true;

    foreach ($field_names as $name) {

        $field_value = isset($_POST[$name]) ? $_POST[$name] : '';

        if (in_array($name, $required_fields) && empty($field_value)) {
            $is_valid = false;
        }

        switch ($name) {
            case 'name':
                $data['name'] = sanitize_text_field($field_value);
                break;
            case 'tel':
                $data['tel'] = sanitize_phone($field_value);
                break;
            case 'email':
                $data['email'] = sanitize_email($field_value);
                break;
            case 'message':
                $data['message'] = sanitize_textarea_field($field_value);
                break;
        }
    }

    if ($is_valid) {

        $from_name = ucfirst(get_bloginfo('name'));
        $from_email = 'wordpress@' . parse_url(get_site_url(), PHP_URL_HOST);

        $email = [
            'to' => get_option('admin_email', 'admin@joompress.biz'),
            'subject' => __('Feedback', 'joompress'),
            'message' => sprintf(
                "Name: %s\nPhone: %s\nE-mail: %s\nMessage: %s",
                $data['name'], $data['tel'], $data['email'], $data['message']
            ),
            'headers' => [
                'from' => sprintf('%s <%s>', $from_name, $from_email),
                'content-type' => 'text/html; charset=UTF-8',
                'cc' => '',
                'bcc' => '',
                'reply-to' => '',
            ],
            'attachments' => [],
        ];

        wp_mail($email['to'], $email['subject'], $email['message'], $email['headers'], $email['attachments']);

        $message = __('Message sent successfully.', 'joompress');
        wp_send_json_success($message, 200);

    } else {
        $message = __('Failed to send message.', 'joompress');
        wp_send_json_error($message, 404);
    }

    wp_die();
}

if (!function_exists('sanitize_phone')) {
    /**
     * Sanitizes a phone number.
     *
     * @param string $phone Phone to sanitize.
     * @return string Sanitized string.
     */
    function sanitize_phone($phone)
    {
        $phone = preg_replace('/^[0-9+-]$/', '', $phone);

        return $phone;
    }
}
