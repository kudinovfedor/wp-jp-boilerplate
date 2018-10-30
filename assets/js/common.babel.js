"use strict";

((html) => {
    html.className = html.className.replace(/\bno-js\b/, 'js');
})(document.documentElement);

((w, d, $, Modernizr) => {

    $(() => {

        formInline({
            form: '.search-form',
            input: '.search-field',
            button: '.search-btn',
        });

        mobileMenu();
        stickyHeader();

        scrollTop('.js-scroll-top');

        hamburgerMenu('.js-menu', '.js-hamburger', '.js-menu-close');

        commentValidation('#commentform');

        if (Modernizr) {
            console.info(`Modernizr is loaded.`);
        } else {
            console.info(`Modernizr not loaded.`);
        }

    });

    const extend = function () {
        let i = 0, prop, deep = false, length = arguments.length, extended = {};

        if (typeof (arguments[0]) === 'boolean') {
            deep = arguments[0];
            i++;
        }

        const merge = (object) => {
            for (prop in object) {
                if (object.hasOwnProperty(prop)) {
                    if (deep && Object.prototype.toString.call(object[prop]) === '[object Object]') {
                        extended[prop] = extend(true, extended[prop], object[prop]);
                    } else {
                        extended[prop] = object[prop];
                    }
                }
            }
        };

        for (; i < length; i++) {
            merge(arguments[i]);
        }

        return extended;
    };

    /**
     * Sticky Header
     *
     * @param {string} [element=.js-header]
     * @param {string} [space=.js-header-space]
     * @returns {void}
     */
    const stickyHeader = (element = '.js-header', space = '.js-header-space') => {
        const className = 'is-sticky';
        const header = d.querySelector(element);
        const headerSpace = d.querySelector(space);
        const headerHeight = header.offsetHeight;

        let scrollTop = 0;
        let hasClass = false;

        w.addEventListener('scroll', () => {
            scrollTop = w.scrollY || w.pageYOffset;
            hasClass = header.classList.contains(className);

            if (scrollTop > headerHeight + 50 && !hasClass) {
                headerSpace.style.height = `${headerHeight}px`;
                header.classList.add(className);
            }

            if (scrollTop <= 1 && hasClass) {
                headerSpace.style.height = 0;
                header.classList.remove(className);
            }
        });
    };

    /**
     * Inline Form
     *
     * @param {Object} [options]
     * @returns {void}
     */
    const formInline = (options) => {
        const defaults = {
            form: '.form-inline',
            input: '.form-field',
            button: '.form-btn',
        };

        const settings = extend(defaults, options);

        const form = d.querySelector(settings.form);

        if (!form) return;

        const display = w.getComputedStyle(form, null).getPropertyValue('display');

        if (display === 'block') {
            const field = form.querySelector(settings.input);
            const button = form.querySelector(settings.button);

            if (!field && !button) return;

            const buttonWidth = Math.ceil(button.getBoundingClientRect().width + button.clientLeft * 2);
            field.style.display = 'inline-block';
            field.style.width = `calc(100% - ${buttonWidth}px)`;
        }
    };

    /**
     *  Mobile Menu
     *
     * @param {Object} [options]
     * @returns {void}
     */
    const mobileMenu = (options) => {
        const defaults = {
            menu: '.js-menu',
            close: '.js-menu-close',
            trigger: '.js-hamburger',
            blackout: '.js-blackout',
        };

        const settings = extend(defaults, options);

        const menu = d.querySelector(settings.menu);
        const trigger = d.querySelector(settings.trigger);

        if (!menu || !trigger) return;

        const close = d.querySelector(settings.close);
        const blackout = d.querySelector(settings.blackout);
        const event = ('ontouchstart' in window ? 'touchstart' : 'click');

        trigger.addEventListener(event, () => {
            menu.classList.toggle('is-opened');
            trigger.classList.toggle('is-opened');

            if (blackout) {
                blackout.classList.toggle('is-active');
            }
        });

        if (close) {
            close.addEventListener(event, () => {
                menu.classList.remove('is-opened');
                trigger.classList.remove('is-opened');

                if (blackout) {
                    blackout.classList.remove('is-active');
                }
            });
        }

        if (blackout) {
            blackout.addEventListener(event, () => {
                menu.classList.remove('is-opened');
                trigger.classList.remove('is-opened');
                blackout.classList.remove('is-active');
            });
        }

        if (!('closest' in d.documentElement)) return;

        w.addEventListener(event, function (e) {
            const selectors = `${settings.menu}, ${settings.trigger}, ${settings.blackout}`;

            if (!e.target.closest(selectors)) {
                menu.classList.remove('is-opened');
                trigger.classList.remove('is-opened');

                if (blackout) {
                    blackout.classList.remove('is-active');
                }
            }
        });
    };

    /**
     * Scroll Top
     *
     * @example
     * scrollTop('.js-scroll-top');
     * @author Fedor Kudinov <brothersrabbits@mail.ru>
     * @param {(string|Object)} element - selected element
     */
    const scrollTop = (element) => {
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
    /*const scrollTopNative = (element, duration, easing, offset, callback) => {

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
    };*/

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

})(window, document, jQuery, window.Modernizr);

/*if (false && 'serviceWorker' in navigator) {
    navigator.serviceWorker
        .register('/sw.js', {scope: './'})
        .then(registration => {
            console.log(`[ServiceWorker] Registered. Scope is ${registration.scope}`);
        })
        .catch(error => {
            console.log(`[ServiceWorker] Failed to Register with ${error}`);
        });
}*/
