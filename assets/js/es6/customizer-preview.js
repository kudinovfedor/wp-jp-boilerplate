(($) => {

    $(() => {

        const scrollTop = $('.js-scroll-top');
        scrollTop.addClass('is-visible');

        const api = wp.customize;

        $(document.body).on('click', '.customizer-edit', function () {
            api.preview.send('preview-edit', $(this).data('control'));
        });

        api('blogname', (control) => {
            control.bind((value) => {
                $('.blogname').html(value);
            });
        });

        api('blogdescription', (control) => {
            control.bind((value) => {
                $('.blogdescription').html(value);
            });
        });

        api('header_textcolor', (control) => {
            control.bind((value) => {
                $('h1, h2, h3, h4, h5, h6').css('color', value);
            });
        });

        api('background_color', (control) => {
            control.bind((value) => {
                $('body').css('background-color', value);
            });
        });

        api('jp_scroll_top_width', (control) => {
            control.bind((value) => {
                scrollTop.css('width', value);
            })
        });

        api('jp_scroll_top_height', (control) => {
            control.bind((value) => {
                scrollTop.css('height', value);
            })
        });

        api('jp_scroll_top_shape', (control) => {
            control.bind((value) => {
                scrollTop.removeClass('is-circle is-rounded is-square').addClass(`is-${value}`);
            })
        });

        api('jp_scroll_top_position', (control) => {
            control.bind((value) => {
                scrollTop.removeClass('is-left is-right').addClass(`is-${value}`);

                const offset = api.get().jp_scroll_top_offset_left_right;

                if (value === 'right') {
                    scrollTop.css({
                        'right': `${offset}px`,
                        'left': 'auto',
                    });
                } else {
                    scrollTop.css({
                        'left': `${offset}px`,
                        'right': 'auto',
                    });
                }
            })
        });

        api('jp_scroll_top_offset_left_right', (control) => {
            control.bind((value) => {

                const position = api.get().jp_scroll_top_position;

                if (position === 'right') {
                    scrollTop.css({
                        'right': `${value}px`,
                        'left': 'auto',
                    });
                } else {
                    scrollTop.css({
                        'right': 'auto',
                        'left': `${value}px`,
                    });
                }
            })
        });

        api('jp_scroll_top_offset_bottom', (control) => {
            control.bind((value) => {
                scrollTop.css('bottom', `${value}px`);
            })
        });

        api('jp_scroll_top_border_width', (control) => {
            control.bind((value) => {
                scrollTop.css('border-width', `${value}px`);
            })
        });

        api('jp_scroll_top_border_color', (control) => {
            control.bind((value) => {
                scrollTop.css('border-color', value);
            })
        });

        api('jp_scroll_top_background_color', (control) => {
            control.bind((value) => {
                scrollTop.css('background-color', value);
            })
        });

        api('jp_scroll_top_background_color_hover', (control) => {
            control.bind((value) => {
                scrollTop.css('background-color', value);
            })
        });

        api('jp_scroll_top_arrow_color', (control) => {
            control.bind((value) => {
                scrollTop.find('.scroll-top--arrow').css('border-bottom-color', value);
            })
        });

    });

})(jQuery);
