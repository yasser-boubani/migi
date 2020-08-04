<?php

namespace App\Models;

class TestModel extends Model
{
    protected $table = "numbers";

    public function get_number_by_id($id) {
        return $this->getRow("id", $id);
    }

    public function get_all_numbers() {
        return $this->getRows();
    }

    public function update_num($id, $value) {
        $data = [
            "value" => $value
        ];
        return $this->updateRow($this->table, $data, "id = $id");
    }

    public function add_num($data) {
        return $this->createRow($this->table, $data);
    }

    public function del_num($id) {
        return $this->deleteRow("id", $id);
    }
}