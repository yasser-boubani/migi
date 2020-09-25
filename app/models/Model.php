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

        /*
    ** The 'join' Method for make a join statement.
    ** $columns --> columns we want to select from the primary table
    ** $final_table_structure --> the finale joined table form:
        [
            [
                "table1" => "col1, col2, col3...",
                "join type (INNER, LEFT, RIGHT)" => "ON statement - eg: primary_table.id = table1.item_id"
            ],
            [
                "table2" => "col1, col2, col3...",
                "join type (INNER, LEFT, RIGHT)" => "ON statement - eg: primary_table.id = table2.item_id"
            ],
        ]
    ** $options --> If you want more options, for instance: 'ORDER BY --- ASC LIMIT 3'
    ** $table_name --> if you need to select a custom table name (For example you don't use a custom model)
    */
    public function join(
        $columns = "*",
        Array $final_table_structure = [],
        $options = null,
        $table_name = null // the primary table (leave it null if you use custom model with protected $_table property)
    )
    {
        global $con;

        if ($table_name == null) {
        $table = $this->_table;
        } else {
        $table = $table_name;
        }

        $join_on_list = [];

        /*
        ** in case we send the $columns parameter contains more than one item to select like:
        "col1, col2, col3..."
        ** We need to make the sentence like this:
        "table.col1, table.col2, table.col3..."
        ** to ignore any conflict problems
        */
        $temp_columns = str_replace(", ", ",", $columns);
        $temp_columns = explode(",", rtrim($temp_columns, ", "));
        $temp_columns = implode(", $table_name.", $temp_columns);
        $select = "$table_name.$temp_columns, ";

        // $current_table_structure_key -> table name
        // $current_table_structure_value -> columns

        for ($i = 0; $i < count($final_table_structure); $i++) {
        /*
        ** current_table_structure_keys[0] -> current table name
        ** current_table_structure_keys[1] -> join type (INNER, LEFt, RIGHT)
        ** current_table_structure_values[0] -> current table columns 
        ** current_table_structure_values[1] -> ON statement - eg: (table1.id = table2.item_id)
        */
        // 1- select statement
        $current_table_structure_keys = array_keys($final_table_structure[$i]);
        $current_table_structure_values = array_values($final_table_structure[$i]);

        $temp_values = str_replace(", ", ",", $current_table_structure_values[0]);
        $temp_values = explode(",", rtrim($temp_values, ", "));
        $temp_values = implode(", $current_table_structure_keys[0].", $temp_values);
        if ($i === count($final_table_structure)-1) {
            $select .= $current_table_structure_keys[0] . "." . $temp_values;
        } else {
            $select .= $current_table_structure_keys[0] . "." . $temp_values . ", ";
        }

        // 2- join_on_list statements
        $join_on_list[$i] = "$current_table_structure_keys[1] JOIN $current_table_structure_keys[0] ON $current_table_structure_values[1]";
        }

        $query = "SELECT $select FROM $table ";

        foreach($join_on_list as $join_on_item) {
        $query .= "$join_on_item ";
        }

        if ($options !== null) {
        $query .= " $options";
        }

        $stmt = $con->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $rows;
    }

    /*
    ** The 'join' Method for make a join statement.
    ** $columns --> columns we want to select from the primary table
    ** $final_table_structure --> Assoc Array of the tables we want to join them the the primary table:
        [
            "tbale1" => "col1, col2, col3...",
            "tbale2" => "col1, col2, col3..."
        ]
    ** $join_structure --> Indexed Array of JOIN type (INNER, LEFT, RIGHT):
        [
            "INNER", // for "tbale1"
            "INNER", // for "tbale2"
        ]
    ** $on_structure --> Indexed Array of ON condition statement:
        [
            "primary_table.id = table1.item_id", // for "tbale1"
            "primary_table.id = table2.item_id", // for "tbale2"
            "",
        ]
    ** Note: the length of the previous arrays must be same.
    ** $options --> If you want more options, for instance: 'ORDER BY --- ASC LIMIT 3'
    ** $table_name --> if you need to select a custom table name (For example you don't use a custom model)
    */
    public function join2(
                    $columns = "*",
                    Array $final_table_structure = [],
                    Array $join_structure = [],
                    Array $on_structure = [],
                    $options = null,
                    $table_name = null // the primary table (leave it null if you use custom model with protected $_table property)
    )
    {
        global $con;

        if ($table_name == null) {
            $table = $this->_table;
        } else {
            $table = $table_name;
        }

        if (count($final_table_structure) !== count($join_structure)
        || count($final_table_structure) !== count($on_structure))
        {
            exit("Check the parameters you sent in the 'join' method, arrays lengths do not match!");
        }

        $final_table_structure_keys = array_keys($final_table_structure);
        $final_table_structure_values = array_values($final_table_structure);

        /*
        ** in case we send the $columns parameter contains more than one item to select like:
            "col1, col2, col3..."
        ** We need to make the sentence like this:
            "table.col1, table.col2, table.col3..."
        ** to ignore any conflict problems
        */
        $temp_columns = str_replace(", ", ",", $columns);
        $temp_columns = explode(",", rtrim($temp_columns, ", "));
        $temp_columns = implode(", $table_name.", $temp_columns);
        $select = "$table_name.$temp_columns, ";
        
        for ($i = 0; $i < count($final_table_structure); $i++) {
            $temp_values = str_replace(", ", ",", $final_table_structure_values[$i]);
            $temp_values = explode(",", rtrim($temp_values, ", "));
            $temp_values = implode(", $final_table_structure_keys[$i].", $temp_values);
            if ($i === count($final_table_structure)-1) {
                $select .= $final_table_structure_keys[$i] . "." . $temp_values;
            } else {
                $select .= $final_table_structure_keys[$i] . "." . $temp_values . ", ";
            }
        }

        $query = "SELECT $select FROM $table ";

        for ($i = 0; $i < count($final_table_structure); $i++) {
            $query .= $join_structure[$i] . " JOIN " . $final_table_structure_keys[$i] . " ON " . $on_structure[$i] . " ";
        }

        if ($options !== null) {
            $query .= " $options";
        }
        
        $stmt = $con->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $rows;
    }
}
