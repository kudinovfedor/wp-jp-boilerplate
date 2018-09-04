"use strict";

((html) => {
    html.className = html.className.replace(/\bno-js\b/, 'js');
})(document.documentElement);

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
     * Scroll Top Native JS
     *
     * @example
     * scrollTopNative('.js-scroll-top', 600, 'linear', 200});
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} element -
     * @param {number} [duration] -
     * @param {string} [easing] -
     * @param {number} [offset] -
     * @param {function} [callback] -
     * @return {*}
     */
    const scrollTopNative = (element, duration, easing, offset, callback) => {

        const options = {
            'element': null,
            'duration': duration || 600,
            'easing': easing || 'linear',
            'offset': offset || 200,
        };

        const easings = {
            linear(t) {
                return t;
            },
            easeInQuad(t) {
                return t * t;
            },
            easeOutQuad(t) {
                return t * (2 - t);
            },
            easeInOutQuad(t) {
                return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
            },
            easeInCubic(t) {
                return t * t * t;
            },
            easeOutCubic(t) {
                return (--t) * t * t + 1;
            },
            easeInOutCubic(t) {
                return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
            },
            easeInQuart(t) {
                return t * t * t * t;
            },
            easeOutQuart(t) {
                return 1 - (--t) * t * t * t;
            },
            easeInOutQuart(t) {
                return t < 0.5 ? 8 * t * t * t * t : 1 - 8 * (--t) * t * t * t;
            },
            easeInQuint(t) {
                return t * t * t * t * t;
            },
            easeOutQuint(t) {
                return 1 + (--t) * t * t * t * t;
            },
            easeInOutQuint(t) {
                return t < 0.5 ? 16 * t * t * t * t * t : 1 + 16 * (--t) * t * t * t * t;
            }
        };

        const scrollToOptions = {
            'behavior': 'smooth',
            'left': 0,
            'top': 0,
        };

        const isSmoothScrollSupported = 'scrollBehavior' in document.documentElement.style;

        const d = document, html = d.documentElement, el = d.querySelector(element), classList = el.classList;

        el.addEventListener('click', event => {
            event.preventDefault();

            const start = window.pageYOffset || html.scrollTop,
                startTime = 'now' in window.performance ? performance.now() : new Date().getTime();

            const scroll = () => {
                const now = 'now' in window.performance ? performance.now() : new Date().getTime();
                const time = Math.min(1, ((now - startTime) / options.duration));
                const timeFunction = easings[options.easing](time);

                window.scrollTo(scrollToOptions.left, Math.ceil((timeFunction * (scrollToOptions.top - start)) + start));

                if (window.pageYOffset === scrollToOptions.top) {
                    if (callback && typeof(callback) === 'function') {
                        callback();
                    }

                    return;
                }

                requestAnimationFrame(scroll);
            };

            if (isSmoothScrollSupported) {

                window.scrollTo(scrollToOptions);
                console.log('[scrollBehavior]');

            } else {

                if ('requestAnimationFrame' in window === false) {
                    console.log('[scrollTo]');
                    window.scrollTo(scrollToOptions.left, scrollToOptions.top);

                    if (callback && typeof(callback) === 'function') {
                        callback();
                    }

                    return;
                }

                console.log('[requestAnimationFrame]');
                scroll();
            }
        });

        window.addEventListener('scroll', () => {
            const scrollPosition = window.pageYOffset || html.scrollTop;

            if (scrollPosition > options.offset) {
                if (!classList.contains('is-visible')) {
                    classList.add('is-visible');
                }
            } else {
                classList.remove('is-visible');
            }
        });
    };

    /**
     * Hamburger Menu
     *
     * @example
     * hamburgerMenu('.js-menu', '.js-hamburger', '.js-menu-close');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} menuElement - Selected menu
     * @param {(string|Object)} hamburgerElement - Trigger element for open/close menu
     * @param {(string|Object)} closeTrigger - Trigger element for close opened menu
     */
    const hamburgerMenu = (menuElement, hamburgerElement, closeTrigger) => {
        const menu = $(menuElement),
            close = $(closeTrigger),
            button = $(hamburgerElement),
            menuButton = button.add(menu);

        button.on('click', () => {
            menuButton.toggleClass('is-active');
        });

        close.on('click', () => {
            menuButton.removeClass('is-active');
        });

        $(window).on('click', (e) => {
            if (!$(e.target).closest(menuButton).length) {
                menuButton.removeClass('is-active');
            }
        });
    };

    /**
     * Comment Validation
     *
     * @example
     * commentValidation('#commentform');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} formId
     */
    const commentValidation = formId => {
        const form = $(formId);

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
