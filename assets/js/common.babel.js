"use strict";

((html) => {
    html.className = html.className.replace(/\bno-js\b/, 'js');
})(document.documentElement);

if (false && 'serviceWorker' in navigator) {
    navigator.serviceWorker
        .register('/sw.js', {scope: './'})
        .then(registration => {
            console.log(`[ServiceWorker] Registered. Scope is ${registration.scope}`);
        })
        .catch(error => {
            console.log(`[ServiceWorker] Failed to Register with ${error}`);
        });
}

(($, Modernizr) => {

    $(() => {

        scrollTop('.js-scroll-top');

        hamburgerMenu('.js-menu', '.js-hamburger', '.js-menu-close');

        commentValidation('#commentform');

        if (Modernizr) {
            console.info(`Modernizr is loaded.`);
        } else {
            console.info(`Modernizr not loaded.`);
        }

    });

    /**
     * Scroll Top
     *
     * @example
     * scrollTop('.js-scroll-top');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} element - selected element
     */
    const scrollTop = element => {
        const el = $(element);

        el.on('click touchend', () => {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        });

        $(window).on('scroll', function () {

            let scrollPosition = $(this).scrollTop();

            if (scrollPosition > 200) {
                if (!el.hasClass('is-visible')) {
                    el.addClass('is-visible');
                }
            } else {
                el.removeClass('is-visible');
            }
        });
    };

    /**
     * Hamburger Menu
     *
     * @example
     * hamburgerMenu('.js-menu', '.js-hamburger', '.js-menu-close');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} menu_element - Selected menu
     * @param {(string|Object)} hamburger_element - Trigger element for open/close menu
     * @param {(string|Object)} close_trigger - Trigger element for close opened menu
     */
    const hamburgerMenu = (menu_element, hamburger_element, close_trigger) => {
        const menu = $(menu_element),
            close = $(close_trigger),
            button = $(hamburger_element),
            menu_button = button.add(menu);

        button.on('click', () => {
            menu_button.toggleClass('is-active');
        });

        close.on('click', () => {
            menu_button.removeClass('is-active');
        });

        $(window).on('click', (e) => {
            if (!$(e.target).closest(menu_button).length) {
                menu_button.removeClass('is-active');
            }
        });
    };

    /**
     * Comment Validation
     *
     * @example
     * commentValidation('#commentform');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} form_id
     */
    const commentValidation = form_id => {
        const form = $(form_id);

        if (form.length && typeof $.fn.validate === 'function') {

            $.validator.setDefaults({
                errorClass: 'is-error',
                validClass: 'is-valid',
                errorElement: 'div',
                debug: false,
            });

            $.validator.addMethod('lettersonly', function (value, element) {
                return this.optional(element) || /^[a-zA-Z\s.-]+$/i.test(value);
            }, 'Only latin letters and symbols: whitespace, dot, dash is allowed.');

            $.validator.methods.email = function (value, element) {
                return this.optional(element) || /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,15}$/i.test(value);
            };

            $(form).validate({
                rules: {
                    'author': {
                        required: true,
                        minlength: 3,
                        lettersonly: true,
                    },
                    'email': {
                        required: true,
                        email: true,
                    },
                    'url': {
                        url: true,
                    },
                    'comment': {
                        required: true,
                        minlength: 10,
                    },
                    'g-recaptcha-response': {
                        required: function () {
                            return grecaptcha.getResponse() === '';
                        },
                    },
                },
                messages: {
                    'author': {},
                    'email': {},
                    'url': {},
                    'comment': {},
                    'g-recaptcha-response': {
                        'required': 'reCAPTCHA unchecked. Please tick and resubmit the form.',
                    },
                },
            });

        }

    };

})(jQuery, window.Modernizr);
