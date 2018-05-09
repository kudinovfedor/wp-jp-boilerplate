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

    if (typeof $.fn.validate === 'function') {
        $.validator.setDefaults({
            errorClass: 'is-error',
            validClass: 'is-valid',
            errorElement: 'div',
            debug: false,
        });

        $.validator.addMethod('lettersonly', function (value, element) {
            return this.optional(element) || /^[a-zA-Z]+$/i.test(value);
        }, 'Letters only please');

        $.validator.methods.email = function (value, element) {
            return this.optional(element) || /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,15}$/i.test(value);
        };
    }

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
     * @param {(string|Object)} menuElement - Selected menu
     * @param {(string|Object)} hamburgerElement - Trigger element for open/close menu
     * @param {(string|Object)} closeTrigger - Trigger element for close opened menu
     */
    const hamburgerMenu = (menuElement, hamburgerElement, closeTrigger) => {
        const menu = $(menuElement),
            close = $(closeTrigger),
            hamburger = $(hamburgerElement),
            menuAll = hamburger.add(menu);

        hamburger.add(close).on('click', () => {
            menuAll.toggleClass('is-active');
        });

        $(window).on('click', (e) => {
            if (!$(e.target).closest(menuAll).length) {
                menuAll.removeClass('is-active');
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
            $(form).validate({
                rules: {
                    author: {
                        required: true,
                        minlength: 3,
                        lettersonly: true
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    url: {
                        url: true,
                    },
                    comment: {
                        required: true,
                        minlength: 10,
                    },
                },
                messages: {
                    author: {},
                    email: {},
                    url: {},
                    comment: {},
                },
            });
        }

    };

})(jQuery, window.Modernizr);
