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

    public function __construct(PDO $pdo, string $table, string $primaryKey)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
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

        return $query->fetch();
    }

    public function find($column, $value)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = :value';

        $parameter = [
            'value' => $value,
        ];

        $query = $this->query($query, $parameter);

        return $query->fetchAll();
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

        return $result->fetchAll();
    }

    public function delete($id)
    {
        $parameter = [':id' => $id];

        $this->query('DELETE FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :id', $parameter);
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
        try {
            if ($record[$this->primaryKey] == '') {
                $record[$this->primaryKey] = null;
            }
            $this->insert($record);
        } catch (PDOException $e) {
            $this->update($record);
        }
    }

}
