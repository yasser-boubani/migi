<?php

namespace App\Controllers;

use App\Models\TestModel;

class Test extends Controller
{
    protected $_view = "test";

    public function show_num($num_id) {
        $testModel = new TestModel;
        $number_row = $testModel->get_number_by_id($num_id);
        view("show.number", [ "number" => $number_row["value"] ]);
    }

    public function show_all() {
        $testModel = new TestModel;
        $all_numbers = $testModel->CQ("SELECT * FROM numbers");
        view("show.all", ["all_numbers" => $all_numbers]);
    }

    public function update_num($num_id, $new_value) {
        $testModel = new TestModel;
        if ($testModel->update_num($num_id, $new_value)) {
            view("updated", ["msg" => "Number has beed updated successfully!"]);
        } else {
            view("updated", ["msg" => "Something went wrong!"]);
        }
    }

    public function add_num($value, $note) {
        $data = [
            "value" => $value,
            "note" => $note,
        ];
        $testModel = new TestModel;
        if ($testModel->add_num($data)) {
            view("Added", ["msg" => "A new number has been added successfully!"]);
        } else {
            view("Added", ["msg" => "Something went wrong!"]);
        }
    }

    public function del_num($id) {
        $testModel = new TestModel;
        if ($testModel->del_num($id)) {
            view("deleted", ["msg" => "deleted successfully!"]);
        } else {
            view("deleted", ["msg" => "Something went wrong!"]);
        }
    }
}