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
        mobileMenu();
        stickyHeader();
        scrollTop(".js-scroll-top");
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
    var stickyHeader = function stickyHeader() {
        var element = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : ".js-header";
        var space = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : ".js-header-space";
        var className = "is-sticky";
        var header = d.querySelector(element);
        var headerSpace = d.querySelector(space);
        var headerHeight = header.offsetHeight;
        var scrollTop = 0;
        var hasClass = false;
        w.addEventListener("scroll", function() {
            scrollTop = w.scrollY || w.pageYOffset;
            hasClass = header.classList.contains(className);
            if (scrollTop > headerHeight + 50 && !hasClass) {
                headerSpace.style.height = "".concat(headerHeight, "px");
                header.classList.add(className);
            }
            if (scrollTop <= 1 && hasClass) {
                headerSpace.style.height = 0;
                header.classList.remove(className);
            }
        });
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
    var mobileMenu = function mobileMenu(options) {
        var defaults = {
            menu: ".js-menu",
            close: ".js-menu-close",
            trigger: ".js-hamburger",
            blackout: ".js-blackout"
        };
        var settings = extend(defaults, options);
        var menu = d.querySelector(settings.menu);
        var trigger = d.querySelector(settings.trigger);
        if (!menu || !trigger) return;
        var close = d.querySelector(settings.close);
        var blackout = d.querySelector(settings.blackout);
        var event = "ontouchstart" in window ? "touchstart" : "click";
        trigger.addEventListener(event, function() {
            menu.classList.toggle("is-opened");
            trigger.classList.toggle("is-opened");
            if (blackout) {
                blackout.classList.toggle("is-active");
            }
        });
        if (close) {
            close.addEventListener(event, function() {
                menu.classList.remove("is-opened");
                trigger.classList.remove("is-opened");
                if (blackout) {
                    blackout.classList.remove("is-active");
                }
            });
        }
        if (blackout) {
            blackout.addEventListener(event, function() {
                menu.classList.remove("is-opened");
                trigger.classList.remove("is-opened");
                blackout.classList.remove("is-active");
            });
        }
        if (!("closest" in d.documentElement)) return;
        w.addEventListener(event, function(e) {
            var selectors = "".concat(settings.menu, ", ").concat(settings.trigger, ", ").concat(settings.blackout);
            if (!e.target.closest(selectors)) {
                menu.classList.remove("is-opened");
                trigger.classList.remove("is-opened");
                if (blackout) {
                    blackout.classList.remove("is-active");
                }
            }
        });
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