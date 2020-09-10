<?php

namespace Workers;

class Uploader
{
    // ERR MSG NUMBERS
    const UPLOADED_SUCCESSFULLY = 10;
    const NOT_ALLOWED_TYPE = 20;
    const SMALLER_THAN_MIN_SIZE = 30;
    const LARGER_THAN_MAX_SIZE = 40;
    const UNEXPECTED_ERR = 50;

    public $result;

    /*
    $_files_request_name ==> We shouldn't use ($_FILES["_files_request_name"]) but ("_files_request_name")

    $options = [
        "name" => "file_name",
        "extension" => "ext",
        "allowed_types" => "ext1, ext2, ...",
        "max_size" => 10, // Bytes
        "min_size" => 0 // Bytes
    ]

    Note: This Method does not support multiple download, if you choose multi file to upload it will pick the first one only.
    */
    public function __construct(String $_files_request_name, String $dir_path, Array $options = []) {

        // check file request & choose the file to upload
        if (!isset($_FILES[$_files_request_name])) {
            exit("Invalid file request!");
        } else {
            $_files_request = $_FILES[$_files_request_name];
        }
        
        $file = [];

        // if there is muli files, take the first one only
        if (isset($_files_request["name"]) && is_array($_files_request["name"])) {
            $file["name"] = $_files_request["name"][0];
            $file["type"] = $_files_request["type"][0];
            $file["tmp_name"] = $_files_request["tmp_name"][0];
            $file["error"] = $_files_request["error"][0];
            $file["size"] = $_files_request["size"][0];
        } else {
            $file["name"] = $_files_request["name"];
            $file["type"] = $_files_request["type"];
            $file["tmp_name"] = $_files_request["tmp_name"];
            $file["error"] = $_files_request["error"];
            $file["size"] = $_files_request["size"];
        }

        // check if there is a file to upload
        if ($file["error"] != UPLOAD_ERR_OK) {
            return $file["error"]; // return the default error
        }

        // Path check
        if (!is_dir($dir_path)) {
            exit("There is no such directory '$dir_path'!");
        }

        // start uploading
        $def_name = $file["name"];
        $def_ext = explode(".", $file["name"]);
        $def_ext = end($def_ext);
        $def_ext = \strtolower($def_ext);

        $working_options = [
            "name" => (isset($options["name"])) ? $options["name"] : $def_name,
            "extension" => (isset($options["extension"])) ? $options["extension"] : $def_ext,
            "allowed_types" => (isset($options["allowed_types"])) ? $options["allowed_types"] : null,
            "max_size" => (isset($options["max_size"]) && $options["max_size"] >= 0) ? $options["max_size"] : null,
            "min_size" => (isset($options["min_size"]) && $options["min_size"] >= 0) ? $options["min_size"] : 0,
        ];

        if ($working_options["allowed_types"] !== null) {
            $working_options["allowed_types"] = \strtolower($working_options["allowed_types"]);
            $working_options["allowed_types"] = \str_replace(" ", "", $working_options["allowed_types"]);
            $allowed_types = explode(",", $working_options["allowed_types"]);
        } else {
            $allowed_types = null;
        }

        if ($allowed_types != null && !in_array($def_ext, $allowed_types)) {
            $this->result = self::NOT_ALLOWED_TYPE;
            return $this->result;
        }

        if ($working_options["min_size"] != null && $file["size"] < $working_options["min_size"]) {
            $this->result = self::SMALLER_THAN_MIN_SIZE;
            return $this->result;
        }

        if ($working_options["max_size"] != null && $file["size"] > $working_options["max_size"]) {
            $this->result = self::LARGER_THAN_MAX_SIZE;
            return $this->result;
        }

        $dir_path = str_replace("/", DS, $dir_path);
        $dir_path = str_replace("\\", DS, $dir_path);

        if (!Helper::str_ends_with($dir_path, DS)) {
            $dir_path = $dir_path . DS;
        }

        if ($working_options["name"] != $def_name) {
            $working_options["name"] = $working_options["name"] . ".$def_ext";
        }

        if ($working_options["extension"] != null) {
            $working_options["name"] = explode(".", $working_options["name"]);
            $working_options["name"][count($working_options["name"])-1] = $working_options["extension"];
            $working_options["name"] = implode(".", $working_options["name"]);
        }

        $full_path = $dir_path . $working_options["name"];

        if (move_uploaded_file($file["tmp_name"], $full_path)) {
            $this->result = self::UPLOADED_SUCCESSFULLY;
        } else {
            $this->result = self::UNEXPECTED_ERR;
        }

        return $this->result;
    }
}
