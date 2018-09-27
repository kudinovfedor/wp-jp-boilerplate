(function (w, d, ajax, $) {
    'use strict';

    /**
     * JP Ajax
     *
     * @description
     * Ajax - native javascript
     *
     * @type {{xhr: null, request: request, get: get, post: post}}
     */
    var Ajax = {
        /**
         * @type {XMLHttpRequest}
         */

        'xhr': null,
        /**
         * @callback doneCallback
         * @param response -
         * @param {Object} status - A object describing the status code and status text.
         */

        /**
         * @callback failCallback
         * @param response -
         * @param {Object} status - A object describing the status code and status text.
         */

        /**
         * REQUEST
         *
         * @description
         * Perform an asynchronous HTTP (Ajax) request.
         *
         * @example
         * Ajax.request(method, url, data, done, fail, always);
         *
         * @param {string} method - The HTTP method to use for the request (e.g. 'GET', 'POST')
         * @param {string} url - A string containing the URL to which the request is sent.
         * @param data - Data to be sent to the server.
         * @param {doneCallback} done - A function to be called if the request succeeds.
         * @param {failCallback} [fail] - A function to be called if the request fails.
         * (after done and fail callbacks are executed).
         * @returns {void}
         */
        request: function (method, url, data, done, fail) {

            var self, state, status;

            this.xhr = new XMLHttpRequest();

            self = this.xhr;

            /**
             * XMLHttpRequest state
             *
             * @type {{UNSENT: number, OPENED: number, HEADERS_RECEIVED: number, LOADING: number, DONE: number}}
             */
            state = {
                'UNSENT': (typeof XMLHttpRequest.UNSENT !== 'undefined') ? XMLHttpRequest.UNSENT : 0,
                'OPENED': (typeof XMLHttpRequest.OPENED !== 'undefined') ? XMLHttpRequest.OPENED : 1,
                'HEADERS_RECEIVED': (typeof XMLHttpRequest.HEADERS_RECEIVED !== 'undefined') ? XMLHttpRequest.HEADERS_RECEIVED : 2,
                'LOADING': (typeof XMLHttpRequest.LOADING !== 'undefined') ? XMLHttpRequest.LOADING : 3,
                'DONE': (typeof XMLHttpRequest.DONE !== 'undefined') ? XMLHttpRequest.DONE : 4,
            };

            status = {};

            self.open(method, url, true);

            self.withCredentials = false; // true, false | Default: false
            self.timeout = 0; // Default: 0
            self.responseType = ''; // 'arraybuffer', 'blob', 'document', 'json', 'text' | Default: ''

            self.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

            self.addEventListener('error', function () {
                if (fail && typeof fail === 'function') {
                    fail(self.responseText, status);
                }
            });

            self.addEventListener('load', function () {
                status.code = self.status;

                try {
                    status.text = self.statusText;
                } catch (e) {
                    status.text = '';
                }

                if (self.readyState === state.DONE && status.code === 200) {
                    if (done && typeof done === 'function') {
                        done(self.responseText, status);
                    }
                } else {
                    if (fail && typeof fail === 'function') {
                        fail(self.responseText, status);
                    }
                }
            });

            self.send(data);
        },

        /**
         * GET
         *
         * @description
         * Load data from the server using a HTTP GET request.
         *
         * @example
         * Ajax.get(url, done, fail, always);
         *
         * @param {string} url - A string containing the URL to which the request is sent.
         * @param {doneCallback} done - A function to be called if the request succeeds.
         * @param {failCallback} [fail] - A function to be called if the request fails.
         * (after done and fail callbacks are executed).
         * @returns {void}
         */
        get: function (url, done, fail) {
            this.request('GET', url, null, done, fail);
        },

        /**
         * POST
         *
         * @description
         * Load data from the server using a HTTP POST request.
         *
         * @example
         * Ajax.post(url, data, done, fail, always);
         *
         * @param {string} url - A string containing the URL to which the request is sent.
         * @param data - Data to be sent to the server.
         * @param {doneCallback} done - A function to be called if the request succeeds.
         * @param {failCallback} [fail] - A function to be called if the request fails.
         * (after done and fail callbacks are executed).
         * @returns {void}
         */
        post: function (url, data, done, fail) {
            this.request('POST', url, data, done, fail);
        },
    };

    d.addEventListener('DOMContentLoaded', function () {
        ajaxContactForm('#contact-form');
    });

    function ajaxContactForm(selector) {

        var form = d.querySelector(selector);

        if (form) {

            var fields = form.querySelectorAll('input, select, textarea');

            var data = {
                'action': ajax.action,
                'nonce': ajax.nonce,
            };

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                var field, params, i;

                for (i = 0; i < fields.length; i++) {
                    field = fields[i];
                    data[field.name] = field.value;
                }

                params = getParams(data);

                Ajax.post(ajax.url, params, function done(data, status) {

                    elementShowMessage(form, JSON.parse(data).data, 'alert-success');
                    console.log('Done: ', data, status);

                }, function fail(data, status) {

                    elementShowMessage(form, JSON.parse(data).data, 'alert-error');
                    console.log('Fail: ', data, status);

                });

                /*var xhr = new XMLHttpRequest();
                xhr.open('POST', ajax.url, true);
                xhr.responseType = 'text';
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

                xhr.onload = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log(xhr.responseText);
                    }
                };

                xhr.onerror = function () {
                    console.log(xhr.response);
                };

                xhr.send(params);*/

                /*$.ajax({
                    'url': ajax.url,
                    'method': 'POST',
                    'dataType': 'html',
                    'data': data,
                })
                    .done(function (data, textStatus, jqXHR) {
                        console.log('[Method Done]', data, textStatus, jqXHR);
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        console.log('[Method Fail]', jqXHR, textStatus, errorThrown);
                    })
                    .always(function () {
                        //console.log('[Method Always]');
                    });*/
            });

        }

        /**
         * Show Message
         *
         * @description
         * Displaying a message inside a selected element.
         *
         * @param {Object} element - The chosen element of the page.
         * @param {string} message - Message to display.
         * @param {string} className - Class name for the created div element
         * @param {number} [timeout=5000] - Waiting time in milliseconds.
         */
        function elementShowMessage(element, message, className, timeout) {
            var div = d.createElement('div');
            div.className = 'alert ' + className;
            div.innerText = message;
            element.appendChild(div);

            setTimeout(function () {
                var elements = d.querySelectorAll('.alert');
                elements.forEach(function (elem) {
                    elem.parentNode.removeChild(elem);
                });
            }, timeout || 5000);
        }

        /**
         * String Params
         *
         * @description
         * Get string of params from object.
         *
         * @param {Object} object - Object for converted into the string.
         * @returns {string} - String with parameters.
         */
        function getParams(object) {
            var encodedString = '', prop;

            for (prop in object) {
                if (object.hasOwnProperty(prop)) {
                    if (encodedString.length > 0) {
                        encodedString += '&';
                    }
                    encodedString += encodeURI(prop + '=' + object[prop]);
                }
            }

            return encodedString;
        }
    }

})(window, document, window.jpAjax, jQuery);
