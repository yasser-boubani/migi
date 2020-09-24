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
    ** function create(array $data, $table_name = null))
    ** create Row
    ** INSERT INTO $table (array_keys) VALUES (array_values)
    **
    */
    public function create(array $data, $table_name = null)
    {
        global $con;

        if ($table_name == null) {
            $table = $this->_table;
        } else {
            $table = $table_name;
        }

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
    ** get($col_name, $value, $columns = "*", $table_name = null)
    ** get a record
    ** SELECT $columns FROM $table WHERE $col_name = $value
    **
    */
    public function get($col_name, $value, $columns = "*", $table_name = null)
    {
        global $con;

        if ($table_name == null) {
            $table = $this->_table;
        } else {
            $table = $table_name;
        }

        $query = "SELECT $columns FROM $table WHERE $col_name = ?";
        $stmt = $con->prepare($query);
        $stmt->execute(array($value));
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row;
    }

    /*
    **
    ** get_all($columns = "*", $options = null, $table_name = null)
    ** get all records
    ** SELECT $columns FROM $table WHERE $col_name = $value
    **
    */
    public function get_all($columns = "*", $options = null, $table_name = null)
    {
        global $con;

        if ($table_name == null) {
            $table = $this->_table;
        } else {
            $table = $table_name;
        }

        $query = "SELECT $columns FROM $table $options";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $rows;
    }

    /*
    **
    ** function update(array $data, $where, $table_name = null)
    ** update Row
    ** INSERT INTO $table (array_keys) VALUES (array_values)
    **
    */
    public function update(array $data, $where, $table_name = null)
    {
        global $con;

        if ($table_name == null) {
            $table = $this->_table;
        } else {
            $table = $table_name;
        }

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
    ** function delete($col_name, $value, $table_name = null)
    ** Delete Row
    ** INSERT INTO $table (array_keys) VALUES (array_values)
    **
    */
    public function delete($col_name, $value, $table_name = null)
    {
        global $con;

        if ($table_name == null) {
            $table = $this->_table;
        } else {
            $table = $table_name;
        }

        $query = "DELETE FROM $table WHERE $col_name =  ?";
        $stmt = $con->prepare($query);
        return $stmt->execute(array($value));
    }

    /*
    **
    ** function CQ($query)
    ** execute a custom query
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
        } elseif ($action == "execute") { // execute a query
            return $stmt->execute();
        } else {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
}
