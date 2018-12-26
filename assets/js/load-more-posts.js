"use strict";

(function(d, ajax) {
    var Ajax = {
        xhr: null,
        request: function request(method, url, data, done, fail) {
            var self, state, status;
            this.xhr = new XMLHttpRequest();
            self = this.xhr;
            state = {
                UNSENT: typeof XMLHttpRequest.UNSENT !== "undefined" ? XMLHttpRequest.UNSENT : 0,
                OPENED: typeof XMLHttpRequest.OPENED !== "undefined" ? XMLHttpRequest.OPENED : 1,
                HEADERS_RECEIVED: typeof XMLHttpRequest.HEADERS_RECEIVED !== "undefined" ? XMLHttpRequest.HEADERS_RECEIVED : 2,
                LOADING: typeof XMLHttpRequest.LOADING !== "undefined" ? XMLHttpRequest.LOADING : 3,
                DONE: typeof XMLHttpRequest.DONE !== "undefined" ? XMLHttpRequest.DONE : 4
            };
            status = {};
            self.open(method, url, true);
            self.withCredentials = false;
            self.timeout = 0;
            self.responseType = "";
            self.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
            self.addEventListener("error", function() {
                if (fail && typeof fail === "function") {
                    fail(self.responseText, status);
                }
            });
            self.addEventListener("load", function() {
                status.code = self.status;
                try {
                    status.text = self.statusText;
                } catch (e) {
                    status.text = "";
                }
                if (self.readyState === state.DONE && status.code === 200) {
                    if (done && typeof done === "function") {
                        done(self.responseText, status);
                    }
                } else {
                    if (fail && typeof fail === "function") {
                        fail(self.responseText, status);
                    }
                }
            });
            data = this._getParams(data);
            self.send(data);
        },
        get: function get(url, done, fail) {
            this.request("GET", url, null, done, fail);
        },
        post: function post(url, data, done, fail) {
            this.request("POST", url, data, done, fail);
        },
        _getParams: function _getParams(object) {
            var encodedString = "", prop;
            for (prop in object) {
                if (object.hasOwnProperty(prop)) {
                    if (encodedString.length > 0) {
                        encodedString += "&";
                    }
                    encodedString += encodeURI(prop + "=" + object[prop]);
                }
            }
            return encodedString;
        }
    };
    d.addEventListener("DOMContentLoaded", function() {
        ajaxLoadMorePosts(".js-load-more", ".js-ajax-posts");
    });
    var getDataAttrs = function getDataAttrs(element) {
        var i, name, value, obj = {};
        var attrs = element.attributes, length = attrs.length;
        for (i = 0; i < length; i++) {
            name = attrs[i].name;
            value = attrs[i].value;
            if (name.indexOf("data-") !== -1) {
                obj[name] = value;
            }
        }
        return obj;
    };
    var ajaxLoadMorePosts = function ajaxLoadMorePosts(selector, container) {
        var btn = d.querySelector(selector);
        var storage = d.querySelector(container);
        if (!btn || !storage) return;
        var data, ajaxStart;
        data = {
            action: ajax.action,
            nonce: ajax.nonce,
            paged: 1,
            query: {}
        };
        btn.addEventListener("click", function(event) {
            if (ajaxStart) return;
            ajaxStart = true;
            var key, value, prop, query = {}, dataObj;
            dataObj = getDataAttrs(btn);
            for (prop in dataObj) {
                if (dataObj.hasOwnProperty(prop)) {
                    value = dataObj[prop];
                    key = prop.replace("data-", "");
                    query[key] = value;
                }
            }
            data.query = query;
            btn.classList.add("is-loading");
            Ajax.post(ajax.url, data, function(response, status) {
                response = JSON.parse(response);
                var result = response.data;
                var posts = result.posts;
                data.paged += 1;
                posts.forEach(function(post, index, array) {
                    storage.appendChild(getPostMarkup(post));
                });
                ajaxStart = false;
                btn.classList.remove("is-loading");
                if (result.posts_count !== result.posts_per_page) {
                    btn.parentNode.removeChild(btn);
                }
            }, function(error, status) {
                console.log(error, status);
                ajaxStart = false;
            });
        });
    };
    var getPostMarkup = function getPostMarkup(post) {
        var article = "", thumbnail, categories = [], tags = [];
        var section = d.createElement("section");
        section.className = "col-sm-6 col-md-4";
        section.id = "post-".concat(post.id);
        article += '<h2><a href="'.concat(post.link, '">').concat(post.title, "</a></h2>");
        if (post.attachment.length) {
            thumbnail = post.attachment.medium;
            article += '<figure><img src="'.concat(thumbnail.src, '" alt="').concat(thumbnail.alt, '"></figure>');
        }
        article += "<p>";
        article += '<time datetime="'.concat(post.datetime, '">').concat(post.date, "</time>");
        if (post.categories.length) {
            post.categories.forEach(function(category, index, array) {
                categories.push('<a href="'.concat(category.link, '">').concat(category.name, "</a>"));
            });
            article += "<br><span>Categories: ".concat(categories.join(", "), "</span>");
        }
        if (post.tags.length) {
            post.tags.forEach(function(tag, index, array) {
                tags.push('<a href="'.concat(tag.link, '">').concat(tag.name, "</a>"));
            });
            article += "<br><span>Tags: ".concat(tags.join(", "), "</span>");
        }
        article += "</p>";
        article += "<p>".concat(post.excerpt, "</p>");
        article += '<p><a class="btn btn-sm btn-primary" href="'.concat(post.link, '">Read more</a></p>');
        section.innerHTML = article;
        return section;
    };
})(document, window.jpAjax);