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

  if (typeof $.fn.validate === 'function') {
    $.validator.setDefaults({
      errorClass: 'is-error',
      validClass: 'is-valid',
      errorElement: 'div',
      debug: false
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
        hamburger = $(hamburgerElement),
        menuAll = hamburger.add(menu);
    hamburger.add(close).on('click', function () {
      menuAll.toggleClass('is-active');
    });
    $(window).on('click', function (e) {
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


  var commentValidation = function commentValidation(form_id) {
    var form = $(form_id);

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
            email: true
          },
          url: {
            url: true
          },
          comment: {
            required: true,
            minlength: 10
          }
        },
        messages: {
          author: {},
          email: {},
          url: {},
          comment: {}
        }
      });
    }
  };
})(jQuery, window.Modernizr);