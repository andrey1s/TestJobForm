<?php

namespace DataBase;

/**
 * Description of DataBase
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class DataBase {

    /**
     * @var string
     */
            private $dsn, $user, $pass;

    /**
     * @var \PDO
     */
    private $dbh;

    /**
     * init
     *
     * @param string $dsn
     * @param string $user
     * @param string $pass
     */
    public function __construct($dsn, $user, $pass) {
        $this->setDsn($dsn)->setPass($pass)->setUser($user)->connectDB();
    }

    /**
     * add User
     *
     * @param string $name
     * @param string $pass
     * @return boolean|Object
     */
    public function addUser($name, $pass) {
        $sth = $this->dbh->prepare("INSERT INTO test_user (name, pass) VALUES (:name, :pass)");
        if ($sth->execute(array(':name' => $name, ':pass' => $pass))) {
            return $this->getFromNamePass($name, $pass);
        }
        return false;
    }

    /**
     * get User
     *
     * @param string $name
     * @param string $pass
     * @return Object
     */
    public function getFromNamePass($name, $pass) {
        $sth = $this->dbh->prepare("SELECT * FROM test_user WHERE name=:name AND pass=:pass");
        $sth->execute(array(':name' => $name, ':pass' => $pass));
        return $sth->fetchObject();
    }

    /**
     * is name isset
     *
     * @param string $name
     * @return boolean
     */
    public function isNameIsset($name) {
        $sth = $this->dbh->prepare("SELECT * FROM test_user WHERE name=':name'");
        $sth->execute(array(':name' => $name));
        return (boolean) $sth->columnCount();
    }

    /**
     * get DSN
     * @return string
     */
    public function getDsn() {
        return $this->dsn;
    }

    /**
     * get Dbh
     * @return \PDO
     */
    public function getDbh() {
        return $this->dbh;
    }

    /**
     * set dsn
     *
     * @param string $dsn
     * @return \DataBase\DataBase
     */
    public function setDsn($dsn) {
        $this->dsn = $dsn;
        
        return $this;
    }

    /**
     * get User DB
     * @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * set User
     * @param string $user
     * @return \DataBase\DataBase
     */
    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    /**
     * get Password
     *
     * @return string
     */
    public function getPass() {
        return $this->pass;
    }

    /**
     * set Password
     * @param string $pass
     * @return \DataBase\DataBase
     */
    public function setPass($pass) {
        $this->pass = $pass;

        return $this;
    }

    /**
     * connect database
     *
     * @return \DataBase\DataBase
     * @throws Exception
     */
    private function connectDB() {
        try {
            $this->dbh = new \PDO($this->dsn, $this->user, $this->pass);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        $this->dbh->exec("SET NAMES utf8");

        return $this;
    }

}
