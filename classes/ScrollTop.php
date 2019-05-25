<?php

if (!class_exists('ScrollTop')) {
    /**
     * Class ScrollTop
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class ScrollTop
    {
        /**
         * ScrollTop constructor.
         */
        public function __construct()
        {
            add_action('wp_head', [$this, 'styleCSS']);
            add_action('customize_register', [$this, 'customizeRegister']);
        }

        /**
         * Get Customizer Options
         *
         * @return array
         */
        public function getOptions()
        {
            $options = [
                'display' => get_theme_mod('jp_scroll_top_enable', true),
                'shape' => get_theme_mod('jp_scroll_top_shape', 'circle'),
                'width' => get_theme_mod('jp_scroll_top_width', '50'),
                'height' => get_theme_mod('jp_scroll_top_height', '50'),
                'bottom' => get_theme_mod('jp_scroll_top_offset_bottom', '20'),
                'border-width' => get_theme_mod('jp_scroll_top_border_width', '1'),
                'side-position' => get_theme_mod('jp_scroll_top_position', 'right'),
                'side-offset' => get_theme_mod('jp_scroll_top_offset_left_right', '20'),
                'border-color' => get_theme_mod('jp_scroll_top_border_color', '#000000'),
                'background-color' => get_theme_mod('jp_scroll_top_background_color', '#000000'),
                'arrow-border-color' => get_theme_mod('jp_scroll_top_arrow_color', '#ffffff'),
                'hover-background-color' => get_theme_mod('jp_scroll_top_background_color_hover', '#000000'),
            ];

            return $options;
        }

        /**
         * Customizer CSS
         *
         * @return void
         */
        public function styleCSS()
        {
            $options = $this->getOptions();
            ?>
            <style>
                .scroll-top {
                    width: <?php echo $options['width'] . 'px' ?>;
                    height: <?php echo $options['height'] . 'px' ?>;
                    background-color: <?php echo $options['background-color'] ?>;
                    border-width: <?php echo $options['border-width'] . 'px' ?>;
                    border-color: <?php echo $options['border-color'] ?>;
                    bottom: <?php echo $options['bottom'] . 'px' ?>;
                    <?php echo sprintf('%s: %spx', $options['side-position'], $options['side-offset']) ?>;
                }

                .scroll-top:hover {
                    background-color: <?php echo $options['hover-background-color']; ?>;
                }

                .scroll-top--arrow {
                    border-bottom-color: <?php echo $options['arrow-border-color']; ?>;
                }
            </style>
        <?php }

        /**
         * Customize
         *
         * @param $customize WP_Customize_Manager
         * @return void
         */
        public function customizeRegister($customize)
        {
            // Section Scroll Top
            $customize->add_section('jp_scroll_top', [
                'title' => 'Scroll Top',
                'description' => 'Customizer Custom Scroll Top',
                'panel' => 'jp_theme_options',
            ]);

            $customize->selective_refresh->add_partial('jp_scroll_top_enable', [
                'selector' => '.js-scroll-top',
            ]);

            $customize->add_setting('jp_scroll_top_enable', [
                'default' => true,
                'sanitize_callback' => 'wp_validate_boolean',
            ]);

            $customize->add_setting('jp_scroll_top_width', [
                'default' => '50',
                'transport' => 'postMessage',
                'sanitize_callback' => 'absint',
            ]);

            $customize->add_setting('jp_scroll_top_height', [
                'default' => '50',
                'transport' => 'postMessage',
                'sanitize_callback' => 'absint',
            ]);

            $customize->add_setting('jp_scroll_top_shape', [
                'default' => 'circle',
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_select',
            ]);

            $customize->add_setting('jp_scroll_top_position', [
                'default' => 'right',
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_select',
            ]);

            $customize->add_setting('jp_scroll_top_offset_left_right', [
                'default' => '20',
                'transport' => 'postMessage',
                'sanitize_callback' => 'absint',
            ]);

            $customize->add_setting('jp_scroll_top_offset_bottom', [
                'default' => '20',
                'transport' => 'postMessage',
                'sanitize_callback' => 'absint',
            ]);

            $customize->add_setting('jp_scroll_top_border_width', [
                'default' => '1',
                'transport' => 'postMessage',
                'sanitize_callback' => 'absint',
            ]);

            $customize->add_setting('jp_scroll_top_border_color', [
                'default' => '#000000',
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $customize->add_setting('jp_scroll_top_background_color', [
                'default' => '#000000',
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $customize->add_setting('jp_scroll_top_background_color_hover', [
                'default' => '#000000',
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $customize->add_setting('jp_scroll_top_arrow_color', [
                'default' => '#ffffff',
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $customize->add_control('jp_scroll_top_enable', [
                'label' => 'Enable/Disable',
                'description' => 'Display Scroll Top',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_enable',
                'type' => 'checkbox',
            ]);

            $customize->add_control('jp_scroll_top_width', [
                'label' => 'Width',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_width',
                'type' => 'number',
                'input_attrs' => ['min' => 25, 'step' => 1],
            ]);

            $customize->add_control('jp_scroll_top_height', [
                'label' => 'Height',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_height',
                'type' => 'number',
                'input_attrs' => ['min' => 25, 'step' => 1],
            ]);

            $customize->add_control('jp_scroll_top_shape', [
                'label' => 'Shape',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_shape',
                'type' => 'select',
                'choices' => [
                    'circle' => 'Circle',
                    'rounded' => 'Rounded',
                    'square' => 'Square',
                ],
            ]);

            $customize->add_control('jp_scroll_top_position', [
                'label' => 'Position',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_position',
                'type' => 'select',
                'choices' => [
                    'right' => 'Right',
                    'left' => 'Left',
                ],
            ]);

            $customize->add_control('jp_scroll_top_offset_left_right', [
                'label' => 'Offset Left/Right',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_offset_left_right',
                'type' => 'number',
                'input_attrs' => ['min' => 0, 'step' => 1],
            ]);

            $customize->add_control('jp_scroll_top_offset_bottom', [
                'label' => 'Offset bottom',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_offset_bottom',
                'type' => 'number',
                'input_attrs' => ['min' => 0, 'step' => 1],
            ]);

            $customize->add_control('jp_scroll_top_border_width', [
                'label' => 'Border width',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_border_width',
                'type' => 'number',
                'input_attrs' => ['min' => 0, 'step' => 1],
            ]);

            $customize->add_control('jp_scroll_top_border_color', [
                'label' => 'Border color',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_border_color',
                'type' => 'color',
            ]);

            $customize->add_control('jp_scroll_top_background_color', [
                'label' => 'Background color',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_background_color',
                'type' => 'color',
            ]);

            $customize->add_control('jp_scroll_top_background_color_hover', [
                'label' => 'Background color hover',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_background_color_hover',
                'type' => 'color',
            ]);

            $customize->add_control('jp_scroll_top_arrow_color', [
                'label' => 'Arrow color',
                'section' => 'jp_scroll_top',
                'settings' => 'jp_scroll_top_arrow_color',
                'type' => 'color',
            ]);
        }

        /**
         * Checks if the checkbox is Enable/Disable for display
         *
         * @return bool
         */
        public function isEnabled()
        {
            $options = $this->getOptions();

            return (bool)$options['display'];
        }

        /**
         * Get Scroll Top HTML markup
         *
         * @return string
         */
        public function getMarkup()
        {
            $output = '';

            if ($this->isEnabled()) {

                $options = $this->getOptions();

                switch ($options['shape']) {
                    case 'circle':
                        $shape = 'is-circle';
                        break;
                    case 'rounded':
                        $shape = 'is-rounded';
                        break;
                    default:
                        $shape = '';
                        break;
                }

                $position = $options['side-position'];

                $output = sprintf(
                    '<a href="#top" class="scroll-top js-scroll-top %s %s" role="button"><span class="screen-reader-text">%s</span><i class="scroll-top--arrow"></i></a>',
                    $shape,
                    $position === 'right' ? 'is-right' : 'is-left',
                    __('Scroll to top', 'joompress')
                );
            }

            return $output;
        }
    }

    new ScrollTop();
}
