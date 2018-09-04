"use strict";

(function (html) {
  html.className = html.className.replace(/\bno-js\b/, 'js');
})(document.documentElement);

(function ($, Modernizr) {
  $(function () {
    scrollTop('.js-scroll-top');
    hamburgerMenu('.js-menu', '.js-hamburger', '.js-menu-close');
    commentValidation('#commentform');

    if (Modernizr) {
      console.info("Modernizr is loaded.");
    } else {
      console.info("Modernizr not loaded.");
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

  var scrollTop = function scrollTop(element) {
    var el = $(element);
    el.on('click touchend', function () {
      $('html, body').animate({
        scrollTop: 0
      }, 600);
      return false;
    });
    $(window).on('scroll', function () {
      var scrollPosition = $(this).scrollTop();

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


  var scrollTopNative = function scrollTopNative(element, duration, easing, offset, callback) {
    var options = {
      'element': null,
      'duration': duration || 600,
      'easing': easing || 'linear',
      'offset': offset || 200
    };
    var easings = {
      linear: function linear(t) {
        return t;
      },
      easeInQuad: function easeInQuad(t) {
        return t * t;
      },
      easeOutQuad: function easeOutQuad(t) {
        return t * (2 - t);
      },
      easeInOutQuad: function easeInOutQuad(t) {
        return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
      },
      easeInCubic: function easeInCubic(t) {
        return t * t * t;
      },
      easeOutCubic: function easeOutCubic(t) {
        return --t * t * t + 1;
      },
      easeInOutCubic: function easeInOutCubic(t) {
        return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
      },
      easeInQuart: function easeInQuart(t) {
        return t * t * t * t;
      },
      easeOutQuart: function easeOutQuart(t) {
        return 1 - --t * t * t * t;
      },
      easeInOutQuart: function easeInOutQuart(t) {
        return t < 0.5 ? 8 * t * t * t * t : 1 - 8 * --t * t * t * t;
      },
      easeInQuint: function easeInQuint(t) {
        return t * t * t * t * t;
      },
      easeOutQuint: function easeOutQuint(t) {
        return 1 + --t * t * t * t * t;
      },
      easeInOutQuint: function easeInOutQuint(t) {
        return t < 0.5 ? 16 * t * t * t * t * t : 1 + 16 * --t * t * t * t * t;
      }
    };
    var scrollToOptions = {
      'behavior': 'smooth',
      'left': 0,
      'top': 0
    };
    var isSmoothScrollSupported = 'scrollBehavior' in document.documentElement.style;
    var d = document,
        html = d.documentElement,
        el = d.querySelector(element),
        classList = el.classList;
    el.addEventListener('click', function (event) {
      event.preventDefault();
      var start = window.pageYOffset || html.scrollTop,
          startTime = 'now' in window.performance ? performance.now() : new Date().getTime();

      var scroll = function scroll() {
        var now = 'now' in window.performance ? performance.now() : new Date().getTime();
        var time = Math.min(1, (now - startTime) / options.duration);
        var timeFunction = easings[options.easing](time);
        window.scrollTo(scrollToOptions.left, Math.ceil(timeFunction * (scrollToOptions.top - start) + start));

        if (window.pageYOffset === scrollToOptions.top) {
          if (callback && typeof callback === 'function') {
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

          if (callback && typeof callback === 'function') {
            callback();
          }

          return;
        }

        console.log('[requestAnimationFrame]');
        scroll();
      }
    });
    window.addEventListener('scroll', function () {
      var scrollPosition = window.pageYOffset || html.scrollTop;

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


  var hamburgerMenu = function hamburgerMenu(menuElement, hamburgerElement, closeTrigger) {
    var menu = $(menuElement),
        close = $(closeTrigger),
        button = $(hamburgerElement),
        menuButton = button.add(menu);
    button.on('click', function () {
      menuButton.toggleClass('is-active');
    });
    close.on('click', function () {
      menuButton.removeClass('is-active');
    });
    $(window).on('click', function (e) {
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


  var commentValidation = function commentValidation(formId) {
    var form = $(formId);

    if (form.length && typeof $.fn.validate === 'function') {
      $.validator.setDefaults({
        errorClass: 'is-error',
        validClass: 'is-valid',
        errorElement: 'div',
        debug: false
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
            lettersonly: true
          },
          'email': {
            required: true,
            email: true
          },
          'url': {
            url: true
          },
          'comment': {
            required: true,
            minlength: 10
          },
          'g-recaptcha-response': {
            required: function required() {
              return grecaptcha.getResponse() === '';
            }
          }
        },
        messages: {
          'author': {},
          'email': {},
          'url': {},
          'comment': {},
          'g-recaptcha-response': {
            'required': 'reCAPTCHA unchecked. Please tick and resubmit the form.'
          }
        }
      });
    }
  };
})(jQuery, window.Modernizr);

if (false && 'serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js', {
    scope: './'
  }).then(function (registration) {
    console.log("[ServiceWorker] Registered. Scope is ".concat(registration.scope));
  }).catch(function (error) {
    console.log("[ServiceWorker] Failed to Register with ".concat(error));
  });
}