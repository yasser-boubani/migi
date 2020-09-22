<?php

namespace App\Models;

class Model
{

    public function __construct()
    {
        if (!USING_DB) {
            eview("db_error", ["error" => "USING_DB constant is set to FALSE!"]);
        }
    }

    /*
    **
    ** function create($table, array $columns, array $data))
    ** create Row
    ** INSERT INTO $table (array_keys) VALUES (array_values)
    **
    */
    public function create($table, array $data)
    {
        global $con;

        $columns = array_keys($data);
        $values = array_values($data);
        $QMarks = str_repeat("?,", count($columns));
        $QMarks = substr($QMarks, 0, strlen($QMarks) - 1);
        $column_string = "";

        foreach ($columns as $column) {
            $column_string .= $column . ",";
        }

        $column_string = substr($column_string, 0, strlen($column_string) - 1);

        $query = "INSERT INTO $table
                    (" . $column_string . ")
                VALUES 
                    (" . $QMarks . ")";

        $stmt = $con->prepare($query);
        return $stmt->execute($values);
    }

    /*
    **
    ** get($colName, $value)
    ** get a record
    ** SELECT * FROM $this->table WHERE $colName = $value
    **
    */
    public function get($colName, $value)
    {
        global $con;

        $query = "SELECT * FROM $this->table WHERE $colName = ?";
        $stmt = $con->prepare($query);
        $stmt->execute(array($value));
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row;
    }

    /*
    **
    ** get($colName, $value)
    ** get all records
    ** SELECT * FROM $this->table WHERE $colName = $value
    **
    */
    public function get_all($options = null)
    {
        global $con;

        $query = "SELECT * FROM $this->table $options";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $rows;
    }

    /*
    **
    ** function update($table, array $columns, array $data))
    ** update Row
    ** INSERT INTO $table (array_keys) VALUES (array_values)
    **
    */
    public function update($table, array $data, $where)
    {
        global $con;

        $columns = array_keys($data);
        $values = array_values($data);
        $SET_string = ""; // SET c1 = v1, c2 = v2 ...

        foreach ($data as $column => $value) {
            if ($value == "NULL") {
                $SET_string .= "$column = $value,";
            } else {
                $SET_string .= "$column = '$value',";
            } 
        }

        $SET_string = substr($SET_string, 0, strlen($SET_string)-1);

        $query = "UPDATE $table SET $SET_string WHERE $where";

        $stmt = $con->prepare($query);
        return $stmt->execute($values);
    }

    /*
    **
    */
    public function delete($colName, $value)
    {
        global $con;

        $query = "DELETE FROM $this->table WHERE $colName =  ?";
        $stmt = $con->prepare($query);
        return $stmt->execute(array($value));
    }

    /*
    **
    ** function CQ($query)
    ** execute a custom query (to fetch data)
    ** 
    */
    public static function CQ($query, String $action = "fetch_all")
    {
        global $con;

        $stmt = $con->query($query);
        if ($action == "fetch_all") { // fetch all
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } elseif ($action == "fetch") { // fetch one item
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } elseif ($action == "count") { // get row count
            return $stmt->rowCount();
        } else {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
}
