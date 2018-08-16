(function ($, d) {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var img, link, select = d.querySelector('[data-customize-setting-link="snazzy_maps_style"]');

        select.addEventListener('change', function () {

            $.ajaxPrefilter(function (s) {
                if (s.crossDomain) {
                    s.contents.script = false;
                }
            });

            $.ajax({
                'url': ajaxurl,
                'method': 'POST',
                'data': {
                    'action': 'snazzy_map',
                    'id': this.value,
                    //'nonce': jp.nonce,
                },
                'dataType': 'text',
                'success': function (response) {

                    img = d.querySelector('#snazzy-map-style');

                    if (img) {

                        link = img.parentElement;

                        if ('' !== response) {

                            img.src = response;
                            link.href = response;

                        } else {

                            link.parentNode.removeChild(link);

                        }

                    } else {

                        createImage(response, select);

                    }

                },
                'error': function (err) {

                    console.log(err);

                }
            });

        });

    });

    /**
     * Create img tag
     *
     * @param {String} src
     * @param {Object} element
     */
    function createImage(src, element) {
        var link = d.createElement('a');
        link.target = '_blank';
        link.rel = 'nofollow noopener noreferrer';
        link.href = src;
        link.setAttribute('style', 'display: block; box-sizing: border-box; border: 1px solid #ddd; margin-top: 10px;');

        var img = d.createElement('img');
        img.id = 'snazzy-map-style';
        img.alt = 'SnazzyMap style image';
        img.src = src;
        img.style.display = 'block';

        link.appendChild(img);

        element.parentNode.appendChild(link);
    }

})(jQuery, document);
