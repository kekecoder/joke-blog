<?php

namespace Ninja;

use DateTime;
use PDO;
use PDOException;

class DatabaseTable
{
    private $pdo;
    private $table;
    private $primaryKey;
    private $className;
    private $constructorArgs;

    public function __construct(PDO $pdo, string $table, string $primaryKey, string $className = '\stdClass', array $constructorArgs = [])
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->className = $className;
        $this->constructorArgs = $constructorArgs;
    }

    private function query($sql, $parameter = [])
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($parameter);
        return $query;
    }

    public function total()
    {
        $query = $this->query('SELECT COUNT(*) FROM `' . $this->table . '`');
        $row = $query->fetch();
        return $row[0];
    }

    public function findById($value)
    {
        $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :value';

        $parameter = ['value' => $value];

        $query = $this->query($query, $parameter);

        return $query->fetchObject($this->className, $this->constructorArgs);
    }

    public function find($column, $value)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = :value';

        $parameter = [
            'value' => $value,
        ];

        $query = $this->query($query, $parameter);

        return $query->fetchAll(PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }

    private function insert($fields)
    {
        $query = 'INSERT INTO `' . $this->table . '` (';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '`,';
        }
        $query = rtrim($query, ',');

        $query .= ') VALUES(';

        foreach ($fields as $key => $value) {
            $query .= ':' . $key . ',';
        }

        $query = rtrim($query, ',');

        $query .= ')';

        $fields = $this->processDates($fields);

        $this->query($query, $fields);

        return $this->pdo->lastInsertId();
    }

    private function update($fields)
    {
        $query = ' UPDATE `' . $this->table . '` SET ';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '` = :' . $key . ',';
        }
        $query = rtrim($query, ',');

        $query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';

        $fields['primaryKey'] = $fields['id'];

        $fields = $this->processDates($fields);

        $this->query($query, $fields);
    }

    public function findAll()
    {
        $result = $this->query('SELECT * FROM `' . $this->table . '`');

        return $result->fetchAll(PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }

    public function delete($id)
    {
        $parameter = [':id' => $id];

        $this->query('DELETE FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :id', $parameter);
    }

    public function deleteWhere($column, $value)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' = :value';

        $parameter = ['value' => $value];

        $query = $this->query($query, $parameter);
    }

    private function processDates($fields)
    {
        foreach ($fields as $key => $value) {
            if ($value instanceof DateTime) {
                $fields[$key] = $value->format('Y-m-d');
            }
        }
        return $fields;
    }

    public function save($record)
    {
        $entity = new $this->className(...$this->constructorArgs);

        try {
            if ($record[$this->primaryKey] == '') {
                $record[$this->primaryKey] = null;
            }
            $insertid = $this->insert($record);

            $entity->{$this->primaryKey} = $insertid;
        } catch (PDOException $e) {
            $this->update($record);
        }

        foreach ($record as $key => $value) {
            if (!empty($value)) {
                $entity->$key = $value;
            }
        }

        return $entity;
    }
}
