<?php

namespace DB;

class SimpleDbWrapper {

    /**
     * DB connection object.
     *
     * @var \PDO
     */
    private $db = NULL;

    /**
     * Prepared statement.
     *
     * @var \PDOStatement
     */
    private $stmt = NULL;
    private $params = array();
    private $sql;

    public function __construct(\PDO $dbc) {
        $this->db = $dbc;
    }

    /**
     * Prepare statement.
     *
     * @param $sql
     * @param array $params
     * @param array $pdoOptions
     *
     * @return \DB\SimpleDbWrapper
     */
    public function prepare($sql, $params = array(), $pdoOptions = array()) {
        $this->stmt = $this->db->prepare($sql, $pdoOptions);
        $this->params = $params;
        $this->sql = $sql;

        return $this;
    }

    /**
     * Execute statement.
     *
     * @param array $params
     *
     * @return \DB\SimpleDbWrapper
     */
    public function execute($params = array()) {
        if ($params) {
            // Overwrite params.
            $this->params = $params;
        }

        $this->stmt->execute($this->params);

        return $this;
    }

    public function fetchAllAssoc() {
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchRowAssoc() {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAllNum() {
        return $this->stmt->fetchAll(\PDO::FETCH_NUM);
    }

    public function fetchRowNum() {
        return $this->stmt->fetch(\PDO::FETCH_NUM);
    }

    public function fetchAllObj() {
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function fetchRowObj() {
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function fetchAllColumn($column) {
        return $this->stmt->fetchAll(\PDO::FETCH_COLUMN, $column);
    }

    public function fetchRowColumn($column) {
        return $this->stmt->fetch(\PDO::FETCH_BOUND, $column);
    }

    public function fetchAllClass($class) {
        return $this->stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function fetchRowClass($class) {
        return $this->stmt->fetch(\PDO::FETCH_BOUND, $class);
    }

    public function getLastInsertedId() {
        return $this->db->lastInsertId();
    }

    public function getAffectedRows() {
        return $this->stmt->rowCount();
    }

    public function getSTMT() {
        return $this->stmt;
    }

}
