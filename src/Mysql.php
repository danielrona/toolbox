<?php
    /**
     * Copyright (c) 2017-2018.
     *
     * Daniel Rona
     */

    namespace Danielrona\Toolbox;


    /**
     * Class Mysql
     * @package Danielrona\Toolbox
     */
    class Mysql
    {
        private static $instance;
        public $dbh;

        private function __construct()
        {
            $dsn =
                'mysql:host=' . Config::get('db.host') .
                ';dbname=' . Config::get('db.name') .
                ';port=' . Config::get('db.port') .
                ';connect_timeout=' . Config::get('db.timeout') .
                'charset=' . Config::get('db.charset');
            $user = Config::get('db.user');
            $password = Config::get('db.pass');

            try {
                $this->dbh = new \PDO($dsn, $user, $password);
                $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                if (Config::get('db.charset') == 'utf8') {
                    $this->dbh->exec('SET NAMES utf8;');
                }
            } catch (\PDOException $e) {
                echo json_encode(
                    array (
                        'code' => $e->getCode(),
                        'msg' => $e->getMessage()
                    )
                );
            }
        }

        /**
         * @return $this
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
         * @param      $query
         * @param null $params
         * @param bool $multiple
         *
         * @return object|array
         */
        public function readQuery($query, $params = null, $multiple = true)
        {
            try {
                $sth = $this->dbh->prepare($query);
                $sth->execute($params);
                if ($multiple == true) {
                    $result = $sth->fetchAll(\PDO::FETCH_OBJ);
                } else {
                    $result = $sth->fetch(\PDO::FETCH_OBJ);
                }
            } catch (\PDOException $e) {
                $result = json_encode(
                    array (
                        'code' => $e->getCode(),
                        'msg' => $e->getMessage()
                    )
                );
            }

            return $result;
        }

        /**
         * @param      $query
         * @param null $params
         *
         * @return string
         */
        public function createQuery($query, $params = null)
        {
            try {
                $sth = $this->dbh->prepare($query);
                $sth->execute($params);
                $result = $this->dbh->lastInsertId();
            } catch (\PDOException $e) {
                $result = json_encode(
                    array (
                        'code' => $e->getCode(),
                        'msg' => $e->getMessage()
                    )
                );
            }

            return $result;
        }

        /**
         * @param      $query
         * @param null $params
         *
         * @return int|string
         */
        public function updateQuery($query, $params = null)
        {
            try {
                $sth = $this->dbh->prepare($query);
                $sth->execute($params);
                $result = $sth->rowCount();
            } catch (\PDOException $e) {
                $result = json_encode(
                    array (
                        'code' => $e->getCode(),
                        'msg' => $e->getMessage()
                    )
                );
            }

            return $result;
        }

    }