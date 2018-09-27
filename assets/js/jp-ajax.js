var AjaxJP = (function () {
    'use strict';

    var Ajax;

    /**
     * JP Ajax
     *
     * @description
     * Ajax - native javascript
     *
     * @type {{xhr: null, request: request, get: get, post: post}}
     */
    Ajax = {
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
         * @callback alwaysCallback
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
         * @param {alwaysCallback} [always] - A function to be called when the request finishes
         * (after done and fail callbacks are executed).
         * @returns {void}
         */
        request: function (method, url, data, done, fail, always) {

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

            self.addEventListener('loadstart', function () {
                //console.log('[Load Start]');
            });

            self.addEventListener('progress', function () {
                //console.log('[Progress]');
            });

            self.addEventListener('error', function () {
                if (fail && typeof fail === 'function') {
                    fail(self.responseText, status);
                }
                //console.log('[Error]');
            });

            self.addEventListener('abort', function () {
                //console.log('[Abort]');
            });

            self.addEventListener('timeout', function () {
                //console.log('[Timeout]');
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

                //console.log('[Load]');
            });

            self.addEventListener('loadend', function () {
                if (always && typeof always === 'function') {
                    always(self.responseText, status);
                }
                //console.log('[Loadend]');
            });

            self.addEventListener('readystatechange', function () {
                //console.log('[Ready State Change]', self.readyState);
                if (self.readyState === state.HEADERS_RECEIVED) {
                    //console.log(self.getAllResponseHeaders());
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
         * @param {alwaysCallback} [always] - A function to be called when the request finishes
         * (after done and fail callbacks are executed).
         * @returns {void}
         */
        get: function (url, done, fail, always) {
            this.request('GET', url, null, done, fail, always);
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
         * @param {alwaysCallback} [always] - A function to be called when the request finishes
         * (after done and fail callbacks are executed).
         * @returns {void}
         */
        post: function (url, data, done, fail, always) {
            this.request('POST', url, data, done, fail, always);
        },
    };

    return Ajax;
})();
