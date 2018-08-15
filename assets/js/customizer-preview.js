(function ($) {
    "use strict";

    $(function () {

        var scrollTop = $('.js-scroll-top');
        scrollTop.addClass('is-visible');

        var api = wp.customize;

        $(document.body).on('click', '.customizer-edit', function () {
            api.preview.send('preview-edit', $(this).data('control'));
        });

        api('blogname', function (control) {
            control.bind(function (value) {
                $('.blogname').html(value);
            });
        });

        api('blogdescription', function (control) {
            control.bind(function (value) {
                $('.blogdescription').html(value);
            });
        });

        api('header_textcolor', function (control) {
            control.bind(function (value) {
                $('h1, h2, h3, h4, h5, h6').css('color', value);
            });
        });

        api('background_color', function (control) {
            control.bind(function (value) {
                console.log(value);
                $('body').css('background-color', value);
            });
        });

        api('jp_scroll_top_width', function (control) {
            control.bind(function (value) {
                scrollTop.css('width', value);
            })
        });

        api('jp_scroll_top_height', function (control) {
            control.bind(function (value) {
                scrollTop.css('height', value);
            })
        });

        api('jp_scroll_top_shape', function (control) {
            control.bind(function (value) {
                scrollTop.removeClass('is-circle is-rounded is-square').addClass('is-' + value);
            })
        });

        api('jp_scroll_top_position', function (control) {
            control.bind(function (value) {
                scrollTop.removeClass('is-left is-right').addClass('is-' + value);

                var offset = api.get().jp_scroll_top_offset_left_right;

                if (value === 'right') {
                    scrollTop.css({
                        'right': offset + 'px',
                        'left': 'auto',
                    });
                } else {
                    scrollTop.css({
                        'left': offset + 'px',
                        'right': 'auto',
                    });
                }
            })
        });

        api('jp_scroll_top_offset_left_right', function (control) {
            control.bind(function (value) {

                var position = api.get().jp_scroll_top_position;

                if (position === 'right') {
                    scrollTop.css({
                        'right': value + 'px',
                        'left': 'auto',
                    });
                } else {
                    scrollTop.css({
                        'right': 'auto',
                        'left': value + 'px',
                    });
                }
            })
        });

        api('jp_scroll_top_offset_bottom', function (control) {
            control.bind(function (value) {
                scrollTop.css('bottom', value + 'px');
            })
        });

        api('jp_scroll_top_border_width', function (control) {
            control.bind(function (value) {
                scrollTop.css('border-width', value + 'px');
            })
        });

        api('jp_scroll_top_border_color', function (control) {
            control.bind(function (value) {
                console.log(value.length);
                scrollTop.css('border-color', value);
            })
        });

        api('jp_scroll_top_background_color', function (control) {
            control.bind(function (value) {
                scrollTop.css('background-color', value);
            })
        });

        api('jp_scroll_top_background_color_hover', function (control) {
            control.bind(function (value) {
                scrollTop.css('background-color', value);
            })
        });

        api('jp_scroll_top_arrow_color', function (control) {
            control.bind(function (value) {
                scrollTop.find('.scroll-top--arrow').css('border-bottom-color', value);
            })
        });

        api('snazzy_maps_style', function (control) {
            control.bind(function (value) {
                $.ajax({
                    'url': jp_ajax_obj.ajax_url,
                    'method': 'POST',
                    'data': {
                        'action': 'snazzy_map',
                        'nonce': jp_ajax_obj.nonce,
                        'id': value,
                    },
                    'dataType': 'text',
                    'success': function (response) {
                        var img = document.querySelector('#snazzy-map-style');
                        if (img) {
                            img.src = response;
                        } else {
                            createImage(response, document.getElementById('_customize-input-snazzy_maps_style'));
                        }
                        console.log(response);
                    },
                    'error': function (err) {
                        console.log(err);
                    }
                });
                console.log(value);
            });
        });

    });

    function createImage(src, element) {
        var img = document.createElement('img');
        img.id = 'snazzy-map-style';
        img.alt = '';
        img.src = src;

        console.log(element);
        console.log(element.parentNode);

        element.parentNode.appendChild(img);
    }

})(jQuery);
