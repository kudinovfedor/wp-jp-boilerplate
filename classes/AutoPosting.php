<?php

if (!class_exists('AutoPosting')) {
    /**
     * Class AutoPosting
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class AutoPosting
    {
        const VK_API_METHOD_WALL_POST = 'https://api.vk.com/method/wall.post';

        /**
         * @var array
         */
        public $settings = [];

        /**
         * AutoPosting constructor.
         */
        public function __construct()
        {
            add_action('customize_register', [$this, 'customizeRegister']);

            //add_action('save_post_post', [$this, 'savePost'], 10, 3);

            if (!is_admin()) {
                //echo '<pre>';
                //var_dump($this->vkPublishPost());
                //echo '</pre>';
            }
        }

        /**
         * @param int $post_ID Post ID.
         * @param WP_Post $post Post object.
         * @param bool $update Whether this is an existing post being updated or not.
         */
        public function savePost($post_ID, $post, $update)
        {

        }

        /**
         * @return array
         */
        public function getSettings()
        {
            return [
                'vk' => [
                    'app-id' => get_theme_mod('vk-app-id'),
                    'access_token' => get_theme_mod('vk-access-token'),
                    'v' => get_theme_mod('vk-version', 5.92),
                    'user_id' => get_theme_mod('vk-user-id'),
                    'owner_id' => get_theme_mod('vk-owner-id'),
                    'friends_only' => get_theme_mod('vk-friends-only', 0),
                    'from_group' => get_theme_mod('vk-from-group', 0),
                    'signed' => get_theme_mod('vk-signed', 0),
                ],
                'twitter' => [],
                'facebook' => [],
                'instagram' => [],
            ];
        }

        public function vkPublishPost()
        {

            $body = $this->getSettings()['vk'];
            $body['message'] = 'Test message';
            unset($body['app-id']);

            $response = wp_safe_remote_post(self::VK_API_METHOD_WALL_POST, [
                'sslverify' => false,
                'body' => $body,
            ]);

            if (is_wp_error($response)) {
                echo 'Error while sending: ' . $response->get_error_message();
                return $response;
            }

            return json_decode($response['body'], true);
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         */
        public function customizeRegister($wp_customize)
        {
            $wp_customize->add_panel('auto-posting', [
                'title' => 'AutoPosting',
                'description' => '',
                'priority' => 205,
            ]);

            $clientID = get_theme_mod('vk-app-id');

            $sections = [
                [
                    'id' => 'vk-posting',
                    'title' => 'VK',
                    'description' => '<b>Step №1</b> - <a href="https://vk.com/editapp?act=create" target="_blank" rel="noopener">Create VK APP</a><br><b>Step №2</b> - <a href="https://oauth.vk.com/authorize?client_id=' . $clientID . '&scope=wall,photos,offline&redirect_uri=https://oauth.vk.com/blank.html&display=page&response_type=token" target="_blank" rel="noopener">Get Token</a>',
                    'description_hidden' => true,
                ],
                [
                    'id' => 'twitter-posting',
                    'title' => 'Twitter',
                    'description' => '',
                ],
                [
                    'id' => 'facebook-posting',
                    'title' => 'Facebook',
                    'description' => '',
                ],
                [
                    'id' => 'instagram-posting',
                    'title' => 'Instagram',
                    'description' => '',
                ],
            ];

            foreach ($sections as $section) {
                $args = [
                    'title' => $section['title'],
                    'description' => $section['description'],
                    'panel' => 'auto-posting',
                ];

                if (isset($section['description_hidden'])) {
                    $args['description_hidden'] = $section['description_hidden'];
                }

                $wp_customize->add_section($section['id'], $args);
            }

            $vk = [
                [
                    'id' => 'vk-app-id',
                    'setting' => [
                        'default' => '',
                        'sanitize_callback' => '',
                    ],
                    'control' => [
                        'label' => 'APP ID',
                        'description' => '',
                        'type' => 'text',
                    ],

                ],
                [
                    'id' => 'vk-access-token',
                    'setting' => [
                        'default' => '',
                        'sanitize_callback' => '',
                    ],
                    'control' => [
                        'label' => 'Access Token',
                        'description' => '',
                        'type' => 'text',
                    ],

                ],
                [
                    'id' => 'vk-version',
                    'setting' => [
                        'default' => '5.92',
                        'sanitize_callback' => '',
                    ],
                    'control' => [
                        'label' => 'Version',
                        'description' => '',
                        'type' => 'text',
                    ],
                ],
                [
                    'id' => 'vk-user-id',
                    'setting' => [
                        'default' => '',
                        'sanitize_callback' => '',
                    ],
                    'control' => [
                        'label' => 'user_id',
                        'description' => '',
                        'type' => 'text',
                    ],
                ],
                [
                    'id' => 'vk-owner-id',
                    'setting' => [
                        'default' => '',
                        'sanitize_callback' => '',
                    ],
                    'control' => [
                        'label' => 'owner_id',
                        'description' => '',
                        'type' => 'text',
                    ],
                ],
                [
                    'id' => 'vk-friends-only',
                    'setting' => [
                        'default' => 0,
                        'sanitize_callback' => 'absint',
                    ],
                    'control' => [
                        'label' => 'friends_only',
                        'description' => '',
                        'type' => 'select',
                        'choices' => [
                            0 => 'Available to all users',
                            1 => 'Available to friends only',
                        ],
                    ],
                ],
                [
                    'id' => 'vk-from-group',
                    'setting' => [
                        'default' => 0,
                        'sanitize_callback' => 'absint',
                    ],
                    'control' => [
                        'label' => 'from_group',
                        'description' => '',
                        'type' => 'select',
                        'choices' => [
                            0 => 'Published by the user',
                            1 => 'Published by the community',
                        ],
                    ],
                ],
                [
                    'id' => 'vk-signed',
                    'setting' => [
                        'default' => 0,
                        'sanitize_callback' => 'absint',
                    ],
                    'control' => [
                        'label' => 'signed',
                        'description' => 'Only for posts in communities with <b>from_group</b> set to 1',
                        'type' => 'select',
                        'choices' => [
                            0 => 'Not be signed',
                            1 => 'Be signed with the name of the posting user',
                        ],
                    ],
                ],
            ];

            foreach ($vk as $item) {
                $setting = $item['setting'];
                $control = $item['control'];

                $wp_customize->add_setting($item['id'], [
                    'default' => $setting['default'],
                    'sanitize_callback' => $setting['sanitize_callback'],
                ]);

                $args = [
                    'label' => $control['label'],
                    'description' => $control['description'],
                    'section' => 'vk-posting',
                    'settings' => $item['id'],
                    'type' => $control['type'],
                ];

                switch ($control['type']) {
                    case 'text':
                        break;
                    case 'select':
                        $args['choices'] = $control['choices'];
                        break;
                }

                $wp_customize->add_control($item['id'], $args);
            }
        }
    }

    //new AutoPosting();
}

/*if(is_admin()) return;

$appID = 6804424;
$methodUsersURL = 'https://api.vk.com/method/users.get?';
$methodGroupsURL = 'https://api.vk.com/method/groups.get?';
$methodWallURL = 'https://api.vk.com/method/wall.post?';
$tokenURL = 'https://oauth.vk.com/authorize?client_id=' . $appID . '&scope=wall,photos,offline&redirect_uri=https://oauth.vk.com/blank.html&display=page&response_type=token';

$vkBody = [
    'user_id' => '29713764',
    'v' => '5.92',
    'access_token' => 'a63568f5df868700ea434e8adedb9ae71f92fb306128b50132f3bfd1d0716031923390907758a0401b475',
    'owner_id' => '-135689628',
    'friends_only' => 0,
    'from_group' => 1,
    'message' => 'Test message',
    'signed' => 0,
    //'extended' => 0,
];

$url = $methodWallURL . http_build_query($vkBody);

var_dump($tokenURL, $url);

$response = wp_safe_remote_post($methodWallURL, [
    'sslverify' => true,
    'body' => $vkBody
]);

if(is_wp_error($response)) {
    echo 'Ошибка отправки: ' . $response->get_error_message();
}

echo '<pre>';
var_dump(json_decode($response['body'], true));
echo '</pre>';*/
