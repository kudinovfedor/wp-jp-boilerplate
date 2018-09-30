<?php

if (!class_exists('SRI')) {
    /**
     * Class SRI
     */
    class SRI
    {
        /**
         * @var array
         */
        public $styles = [];

        /**
         * @var array
         */
        public $scripts = [
            'jquery-core',
        ];

        /**
         * @var array
         */
        public $hash_algos = [
            'sha256',
            'sha384',
            'sha512',
        ];

        /**
         * SRI constructor.
         */
        public function __construct()
        {
            add_filter('style_loader_tag', [$this, 'loadStyles'], 10, 4);
            add_filter('script_loader_tag', [$this, 'loadScripts'], 10, 3);
        }

        /**
         * Filters the HTML link tag of an enqueued style.
         *
         * @param string $html The link tag for the enqueued style.
         * @param string $handle The style's registered handle.
         * @param string $href The stylesheet's source URL.
         * @param string $media The stylesheet's media attribute.
         */
        public function loadStyles($html, $handle, $href, $media)
        {
            //dump($html, $handle, $href, $media);
        }

        /**
         * Filters the HTML script tag of an enqueued script.
         *
         * @param string $tag The `<script>` tag for the enqueued script.
         * @param string $handle The script's registered handle.
         * @param string $src The script's source URL.
         *
         * @return string
         */
        public function loadScripts($tag, $handle, $src)
        {
            if (in_array($handle, $this->scripts)) {
                $attributes = sprintf(' integrity="sha256-%s" crossorigin="anonymous"', $this->hashSHA256($src));
                return preg_replace("/src=/", $attributes . ' src=', $tag);
            }

            //dump($tag, $handle, $src);
        }

        /**
         * Generate a hash value using the contents of a given file
         *
         * @param string $algo Name of selected hashing algorithm
         * @param string $filename URL describing location of file to be hashed
         * @return string
         */
        public function hash($algo, $filename)
        {
            if (!in_array($algo, $this->hash_algos)) {
                throw new \InvalidArgumentException('');
            }

            return base64_encode(hash_file($algo, $filename, true));
        }

        /**
         * @param string $filename URL describing location of file to be hashed
         * @return string
         */
        public function hashSHA256($filename)
        {
            return base64_encode(hash_file('sha256', $filename, true));
        }

        /**
         * @param string $filename URL describing location of file to be hashed
         * @return string
         */
        public function hashSHA384($filename)
        {
            return base64_encode(hash_file('sha384', $filename, true));
        }

        /**
         * @param string $filename URL describing location of file to be hashed
         * @return string
         */
        public function hashSHA512($filename)
        {
            return base64_encode(hash_file('sha512', $filename, true));
        }
    }
}
