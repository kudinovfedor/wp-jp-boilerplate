const JP = (() => {
    class JP {
        /**
         *
         * @param {Object} element
         * @param {String} className
         * @returns {boolean}
         */
        static hasClass(element, className) {
            if (element.classList) {
                return element.classList.contains(className);
            } else {
                const regex = new RegExp(`\\b${className}\\b`, 'g');
                return regex.test(element.className);
            }
        };

        /**
         *
         * @param {Object} element
         * @param {String} className
         * @returns {void}
         */
        static addClass(element, className) {
            if (element.classList) {
                element.classList.add(className);
            } else {
                const classes = element.className.split(' ');
                if (classes.indexOf(className) === -1) {
                    element.className += ` ${className}`;
                }
            }
        }

        /**
         *
         * @param {Object} elements
         * @param {String} className
         * @returns {void}
         */
        static removeClass(elements, className) {
            let i, regex, length = elements.length, element, classList;

            for (i = 0; i < length; i++) {
                element = elements[i];
                classList = element.classList;

                if (classList) {
                    classList.remove(className);
                } else {
                    regex = new RegExp(`\\b${className}\\b`, 'g');
                    element.className = element.className.replace(regex, '');
                }
            }
        }

        /**
         *
         * @param {Object} element
         * @param {String} className
         * @returns {void}
         */
        static toggleClass(element, className) {

            if (element.classList) {
                element.classList.toggle(className);
            } else {
                const classes = element.className.split(' ');
                const index = classes.indexOf(className);

                if (index >= 0) {
                    classes.splice(index, 1);
                } else {
                    classes.push(className);
                }

                element.className = classes.join(' ');
            }
        }

        /**
         *
         * @param {Object} element
         * @param {String} className
         * @returns {void}
         */
        static closest(element, className) {

        }

        /**
         * @callback forEachCallback
         * @param currentValue - Required. The value of the current element
         * @param {!number} [index] - Optional. The array index of the current element
         * @param [array] - Optional. The array object the current element belongs to
         */

        /**
         *
         * @param array - Required.
         * @param {forEachCallback} callback - Required. A function to be run for each element in the array.
         * @param [thisArg] - Optional. An object to which the this keyword can refer in the forEachCallback function. If thisArg is omitted, undefined is used as the this value.
         * @returns {void}
         */
        static forEach(array, callback, thisArg) {
            let i, length = array.length;
            for (i = 0; i < length; i++) {
                callback.call(thisArg, array[i], i, array);
            }
        }

        static extend() {
            let i = 0, prop, deep = false, length = arguments.length, extended = {};

            if (typeof (arguments[0]) === 'boolean') {
                deep = arguments[0];
                i++;
            }

            const merge = (object) => {
                for (prop in object) {
                    if (object.hasOwnProperty(prop)) {
                        if (deep && Object.prototype.toString.call(object[prop]) === '[object Object]') {
                            extended[prop] = extend(true, extended[prop], object[prop]);
                        } else {
                            extended[prop] = object[prop];
                        }
                    }
                }
            };

            for (; i < length; i++) {
                merge(arguments[i]);
            }

            return extended;
        }
    }

    return JP;
})();
