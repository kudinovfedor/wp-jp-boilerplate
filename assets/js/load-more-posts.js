(function (d, ajax) {
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

            data = this._getParams(data);

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

        /**
         * String Params
         *
         * @description
         * Get string of params from object.
         *
         * @example
         * this._getParams(data);
         *
         * @param {Object} object - Object for converted into the string.
         * @returns {string} - String with parameters.
         */
        _getParams: function (object) {
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
    };

    d.addEventListener('DOMContentLoaded', function () {
        ajaxLoadMorePosts('.js-load-more', '.js-ajax-posts');
    });

    function getDataAttrs(element) {
        var i, name, value, obj = {}, attrs = element.attributes, length = attrs.length;

        for (i = 0; i < length; i++) {
            name = attrs[i].name;
            value = attrs[i].value;

            if(name.indexOf('data-') !== -1) {
                obj[name] = value;
            }
        }

        return obj;

    }

    function ajaxLoadMorePosts(selector, container) {
        var btn, data, storage, ajaxStart;

        btn = d.querySelector(selector);
        storage = d.querySelector(container);

        if (!btn || !storage) return;

        data = {
            'action': ajax.action,
            'nonce': ajax.nonce,
            'paged': 1,
            'query': {},
        };

        btn.addEventListener('click', function (event) {
            if (ajaxStart) return;

            ajaxStart = true;

            var key, value, prop, query = {}, dataObj;

            dataObj = getDataAttrs(btn);

            for (prop in dataObj) {
                if (dataObj.hasOwnProperty(prop)) {
                    value = dataObj[prop];
                    key = prop.replace('data-', '');
                    query[key] = value;
                }
            }

            data.query = query;

            btn.classList.add('is-loading');

            Ajax.post(ajax.url, data, function (response, status) {
                var result, posts, section, article = '', thumbnail, categories = [], tags = [];

                response = JSON.parse(response);
                result = response.data;
                posts = result.posts;

                data.paged += 1;

                posts.forEach(function (post, index, array) {

                    section = d.createElement('section');
                    section.className = 'col-sm-6 col-md-4';
                    section.id = `post-${post.id}`;

                    article += `<h2><a href="${post.link}">${post.title}</a></h2>`;

                    if (post.attachment.length) {
                        thumbnail = post.attachment.medium;
                        article += `<figure><img src="${thumbnail.src}" alt="${thumbnail.alt}"></figure>`;
                    }

                    article += `<p>`;
                    article += `<time datetime="${post.datetime}">${post.date}</time>`;

                    if (post.categories.length) {
                        post.categories.forEach(function (category, index, array) {
                            categories.push(`<a href="${category.link}">${category.name}</a>`);
                        });
                        article += `<br><span>Categories: ${categories.join(', ')}</span>`;
                    }

                    if (post.tags.length) {
                        post.tags.forEach(function (tag, index, array) {
                            tags.push(`<a href="${tag.link}">${tag.name}</a>`);
                        });
                        article += `<br><span>Tags: ${tags.join(', ')}</span>`;
                    }

                    article += `</p>`;

                    article += `<p>${post.excerpt}</p>`;

                    article += `<p><a class="btn btn-default btn-sm" href="${post.link}">Read more</a></p>`;

                    section.innerHTML = article;

                    storage.appendChild(section);

                    article = '';
                });

                ajaxStart = false;

                btn.classList.remove('is-loading');

                if (result.posts_count !== result.posts_per_page) {
                    btn.parentNode.removeChild(btn);
                }

            }, function (error, status) {
                console.log(error, status);

                ajaxStart = false;
            });

        });
    }
})(document, window.jpAjax);
