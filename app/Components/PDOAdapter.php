<?php
/**
 * Created by PhpStorm.
 * User: sparrow
 * Date: 12/18/16
 * Time: 7:07 AM
 */

namespace Components;


class PDOAdapter
{
    protected $config = [];

    protected $connection;

    protected $statement;

    protected $fetchMode = \PDO::FETCH_ASSOC;

    public function __construct($config = 'db_params')
    {
        //устанавливаем конфиг
        $this->config = include($this->loadConfig($config));
    }
    //создаем объект PDO
    public function connect(){
        // если есть подлкючение
        if ($this->connection) {
            return;
        }
        try {
            $this->connection = new \PDO(
                $this->config['dsn'],
                $this->config['user'],
                $this->config['password'],
                $this->config['options']
            );
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION)
            $this->connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function disconnect(){
        $this->connection = NULL;
    }

    public function prepare($sql, array $options = [])
    {
        $this->connect();
        try {
            $this->statement = $this->connection->prepare($sql, $options);
            return $this;
        } catch(\PDOException $e)  {
            echo $e->getMessage();
        }
    }

    public function getStatement()
    {
        if ($this->statement === NULL) {
            throw new \PDOException("There is no PDOStatement.");
        }
        return $this->statement;

    }

    public function execute(array $params = [])
    {
        try {
            $this->getStatement()->execute($params);
            return $this;
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function countAffectedRows()
    {
        try {
            return $this->getStatement()->rowCount();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getLastInsertId($name = NULL)
    {
        $this->connect();
        return $this->connection->lastInsertId($name);
    }

    public function fetch($fetchStyle = NULL, $cursorOrientation = NULL, $cursorOffset = NULL)
    {
        if ($fetchStyle === NULL) {
            $fetchStyle = $this->fetchMode;
        }
        try {
            return $this->getStatement()->fetch($fetchStyle,$cursorOrientation, $cursorOffset);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function fetchAll($fetchStyle = NULL, $column = 0)
    {
        if ($fetchStyle === NULL) {
            $fetchStyle = $this->fetchMode;
        }
        try {
            if ($fetchStyle === \PDO::FETCH_COLUMN){
                $this->getStatement()->fetchAll($fetchStyle, $column);
            } else {
                $this->getStatement()->fetchAll($fetchStyle);
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function select($table, array $bind = [], $boolOperator = "AND")
    {
        if ($bind) {
            $where = [];
            foreach ($bind as $col => $value) {
                unset($bind[$col]);
                $bind[":" . $col] = $value;
                $where[] = $col . " = :" . $col;
            }
        }

        $sql = "SELECT * FROM " . $table
            . (($bind) ? " WHERE "
                . implode(" " . $boolOperator . " ", $where) : " ");
        $this->prepare($sql)
            ->execute($bind);
        return $this;
    }

    public function insert($table, array $bind) {
        $cols = implode(", ", array_keys($bind));
        $values = implode(", :", array_keys($bind));
        foreach ($bind as $col => $value) {
            unset($bind[$col]);
            $bind[":" . $col] = $value;
        }

        $sql = "INSERT INTO " . $table
            . " (" . $cols . ")  VALUES (:" . $values . ")";
        return (int) $this->prepare($sql)
            ->execute($bind)
            ->getLastInsertId();
    }

    public function update($table, array $bind, $where = "") {
        $set = array();
        foreach ($bind as $col => $value) {
            unset($bind[$col]);
            $bind[":" . $col] = $value;
            $set[] = $col . " = :" . $col;
        }

        $sql = "UPDATE " . $table . " SET " . implode(", ", $set)
            . (($where) ? " WHERE " . $where : " ");
        return $this->prepare($sql)
            ->execute($bind)
            ->countAffectedRows();
    }

    public function delete($table, $where = "") {
        $sql = "DELETE FROM " . $table . (($where) ? " WHERE " . $where : " ");
        return $this->prepare($sql)
            ->execute()
            ->countAffectedRows();
    }

    //проверяем конфиг
    private function loadConfig($file)
    {
        $path = ROOT.'/config/'.$file.'.php';
        if (file_exists($path)) {
            return $path;
        } else {
            exit('File '.$path.' not found.');
        }

    }
}

