<?php

namespace Form\Validators;

/**
 * Description of Unique
 *
 * @author andrey <asamusev@archer-soft.com>
 */
class Unique extends AbstractValidator {

    /**
     * @var string
     */
            private $table, $name;

    /**
     * @var \PDO
     */
    private $dbh;

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = 'this value alredy exist';

    /**
     * init
     *
     * @param string $table
     * @param string $name
     * @param \PDO $dbh
     */
    public function __construct($table, $name, \PDO $dbh) {
        $this->setDbh($dbh);
        $this->setName($name);
        $this->setTable($table);
    }

    /**
     * set table
     *
     * @param string $table
     */
    public function setTable($table) {
        $this->table = $table;
    }

    /**
     * set field name
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * ser Dbh
     *
     * @param \PDO $dbh
     */
    public function setDbh($dbh) {
        $this->dbh = $dbh;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid() {
        $sth = $this->dbh->prepare("SELECT * FROM " . $this->table . " WHERE " . $this->name . "=:value");
        $sth->execute(array(':value' => $this->validateValue));

        return $sth->rowCount() ? false : true;
    }

}

