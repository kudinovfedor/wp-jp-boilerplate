"use strict";

(function(html) {
    html.className = html.className.replace(/\bno-js\b/, "js");
})(document.documentElement);

(function(w, d, $, Modernizr) {
    $(function() {
        formInline({
            form: ".search-form",
            input: ".search-field",
            button: ".search-btn"
        });
        scrollTop(".js-scroll-top");
        hamburgerMenu(".js-menu", ".js-hamburger", ".js-menu-close");
        commentValidation("#commentform");
        if (Modernizr) {
            console.info("Modernizr is loaded.");
        } else {
            console.info("Modernizr not loaded.");
        }
    });
    var extend = function extend() {
        var i = 0, prop, deep = false, length = arguments.length, extended = {};
        if (typeof arguments[0] === "boolean") {
            deep = arguments[0];
            i++;
        }
        var merge = function merge(object) {
            for (prop in object) {
                if (object.hasOwnProperty(prop)) {
                    if (deep && Object.prototype.toString.call(object[prop]) === "[object Object]") {
                        extended[prop] = extend(true, extended[prop], object[prop]);
                    } else {
                        extended[prop] = object[prop];
                    }
                }
            }
        };
        for (;i < length; i++) {
            merge(arguments[i]);
        }
        return extended;
    };
    var formInline = function formInline(options) {
        var defaults = {
            form: ".form-inline",
            input: ".form-field",
            button: ".form-btn"
        };
        var settings = extend(defaults, options);
        var form = d.querySelector(settings.form);
        if (!form) return;
        var display = w.getComputedStyle(form, null).getPropertyValue("display");
        if (display === "block") {
            var field = form.querySelector(settings.input);
            var button = form.querySelector(settings.button);
            if (!field && !button) return;
            var buttonWidth = Math.ceil(button.getBoundingClientRect().width + button.clientLeft * 2);
            field.style.display = "inline-block";
            field.style.width = "calc(100% - ".concat(buttonWidth, "px)");
        }
    };
    var scrollTop = function scrollTop(element) {
        var el = $(element);
        el.on("click touchend", function() {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            return false;
        });
        $(window).on("scroll", function() {
            var scrollPosition = $(this).scrollTop();
            if (scrollPosition > 200) {
                if (!el.hasClass("is-visible")) {
                    el.addClass("is-visible");
                }
            } else {
                el.removeClass("is-visible");
            }
        });
    };
    var hamburgerMenu = function hamburgerMenu(menuElement, hamburgerElement, closeTrigger) {
        var menu = $(menuElement), close = $(closeTrigger), button = $(hamburgerElement), menuButton = button.add(menu);
        button.on("click", function() {
            menuButton.toggleClass("is-active");
        });
        close.on("click", function() {
            menuButton.removeClass("is-active");
        });
        $(window).on("click", function(e) {
            if (!$(e.target).closest(menuButton).length) {
                menuButton.removeClass("is-active");
            }
        });
    };
    var commentValidation = function commentValidation(formId) {
        var form = $(formId);
        if (form.length && typeof $.fn.validate === "function") {
            $.validator.setDefaults({
                errorClass: "is-error",
                validClass: "is-valid",
                errorElement: "div",
                debug: false
            });
            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z\s.-]+$/i.test(value);
            }, "Only latin letters and symbols: whitespace, dot, dash is allowed.");
            $.validator.methods.email = function(value, element) {
                return this.optional(element) || /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,15}$/i.test(value);
            };
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
                    },
                    "g-recaptcha-response": {
                        required: function required() {
                            return grecaptcha.getResponse() === "";
                        }
                    }
                },
                messages: {
                    author: {},
                    email: {},
                    url: {},
                    comment: {},
                    "g-recaptcha-response": {
                        required: "reCAPTCHA unchecked. Please tick and resubmit the form."
                    }
                }
            });
        }
    };
})(window, document, jQuery, window.Modernizr);