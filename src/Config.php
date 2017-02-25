<?php
    /**
     * Copyright (c) 2017.
     *
     * Daniel Rona
     */

    namespace Danielrona\Toolbox;


    /**
     * Class Config
     * @package Danielrona\Toolbox
     */
    class Config
    {
        private static $instance; // handle of options
        static $confArray;

        /**
         * @return mixed
         */
        public static function getInstance()
        {
            if (!isset(self::$instance)) {
                $object = __CLASS__;
                self::$instance = new $object;
            }

            return self::$instance;
        }

        /**
         * @param $name
         *
         * @return mixed
         */
        public static function get($name)
        {
            return self::$confArray[$name];
        }

        /**
         * @param $name
         * @param $value
         */
        public static function set($name, $value)
        {
            self::$confArray[$name] = $value;
        }

        /**
         * @return bool
         */
        function isWorking()
        {
            return true;
        }
    }