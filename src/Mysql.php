<?php
    namespace Danielrona\Toolbox;


    /**
     * Class Mysql
     * @package Danielrona\Toolbox
     */
    class Mysql
    {
        private static $instance; // handle of the db connection
        public $dbh; // make connection available

        private function __construct()
        {
            // building data source name from config
            $dsn =
                'mysql:host=' . Config::get('db.host') .
                ';dbname=' . Config::get('db.name') .
                ';port=' . Config::get('db.port') .
                ';connect_timeout=' . Config::get('db.timeout') .
                'charset=' . Config::get('db.charset');
            // getting DB user from config
            $user = Config::get('db.user');
            // getting DB password from config
            $password = Config::get('db.pass');

            try {
                $this->dbh = new \PDO($dsn, $user, $password);
                $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                if (Config::get('db.charset') == 'utf8') {
                    $this->dbh->exec('SET NAMES utf8;');
                }
            } catch (\PDOException $e) {
                // handle exceptions
                echo json_encode(
                    array (
                        'code' => $e->getCode(),
                        'msg' => $e->getMessage()
                    )
                );
            }
        }

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
         * @return string
         */
        public function getId()
        {
            return $this->dbh->lastInsertId();
        }

        /**
         * @param      $query
         * @param null $params
         *
         * @return array|string
         */
        public function readQuery($query, $params=null)
        {
            try {
                $sth = $this->dbh->prepare($query);
                $sth->execute($params);
                $result = $sth->fetchAll(\PDO::FETCH_OBJ);
            } catch (\PDOException $e) {
                // handle exceptions
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
        public function createQuery($query, $params=null)
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
        public function updateQuery($query, $params=null)
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