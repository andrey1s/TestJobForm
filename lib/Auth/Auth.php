<?php

namespace Auth;

/**
 * Description of Auth
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class Auth {

    /**
     *
     * @var Auth
     */
    protected static $instance;

    /**
     *
     * @var string
     */
    private $namespace = 'Auth';

    /**
     * init Auth
     *
     * @return Auth
     */
    public static function getInstance() {
        if (empty(self::$instance)) {
            session_start();
            self::$instance = new Auth();
        }
        return self::$instance;
    }

    /**
     * has Identity
     *
     * @return boolean
     */
    public function hasIdentity() {
        return isset($_SESSION[$this->getNamespace()]);
    }

    /**
     * get Identity
     *
     * @return mixed
     */
    public function getIdentity() {
        return unserialize($_SESSION[$this->getNamespace()]);
    }

    /**
     * set init data
     *
     * @param mixed $data
     * @return \Auth\Auth
     */
    public function setData($data) {
        $_SESSION[$this->getNamespace()] = serialize($data);

        return $this;
    }

    /**
     * unset
     *
     * @return \Auth\Auth
     */
    public function unsetIdentity() {
        unset($_SESSION[$this->getNamespace()]);

        return $this;
    }

    /**
     * get Namespase
     *
     * @return string
     */
    public function getNamespace() {
        return $this->namespace;
    }

    /**
     * set Namespace
     *
     * @param string $namespace
     */
    public function setNamespace($namespace) {
        $this->namespace = $namespace;
    }

    private function __construct() {}

    private function __clone() {}

    private function __wakeup() {}

}
