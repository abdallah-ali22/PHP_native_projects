<?php

class Db_object {
    public $errors = array();
    public $upload_errors_array = array(
        UPLOAD_ERR_OK => "There is no error",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the upload_max_filesize directive that was specified in the HTML ... ",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partial uploaded",
        UPLOAD_ERR_NO_FILE => "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
        UPLOAD_ERR_EXTENSION => "A php extension stopped the file upload"
    );
    static function find_all() {
        $sql = "SELECT * FROM ". static::$db_table;
        return static::find_this_query($sql);
    }

    static function search_by_id($id) {
        global $database;
        $result = static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE id = $id");
        // $found_user = mysqli_fetch_assoc($result);
        return !empty($result)?array_shift($result):false;
        // return $found_user;
    }

    static function find_this_query($sql) {
        global $database;
        $result = $database->query($sql);
        $the_object_array = array();
        while($row = mysqli_fetch_array($result)) {
            $the_object_array[] = static::instantiation($row);
        }
        return $the_object_array;
    }
    static function instantiation($result) {
        $the_obj = new static;

        foreach($result as $the_attribute => $value) {
            if($the_obj->has_the_attribute($the_attribute)) {
                $the_obj->$the_attribute = $value;
            }
        }
        return $the_obj;
    }
    protected function properties() {
        // return get_object_vars($this);
        $properties = array();
        foreach(static::$db_table_fields as $db_field) {
            if(property_exists($this,$db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }
    protected function clean_properties() {
        global $database;
        $clean_properties = array();
        foreach($this->properties() as $key=> $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }
    function create() {
        global $database;
        // $the_username = $database->escape_string($this->username);
        // $the_password = $database->escape_string($this->password);
        // $the_firstname = $database->escape_string($this->first_name);
        // $the_lastname = $database->escape_string($this->last_name);
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " . static::$db_table ."(". implode(",",array_keys($properties)) . ") VALUES ('" . implode("','", array_values($properties)) . "')";
        if($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
    }
    function update() {
        global $database;
        $the_id = $database->escape_string($this->id);
        // $the_username = $database->escape_string($this->username);
        // $the_password = $database->escape_string($this->password);
        // $the_firstname = $database->escape_string($this->first_name);
        // $the_lastname = $database->escape_string($this->last_name);
        $properties = $this->clean_properties();
        $properties_pairs = array();
        foreach($properties as $key=>$value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE " . static::$db_table . " SET ".implode(", ",$properties_pairs)." WHERE id = $the_id";
        $database->query($sql);        
        return (mysqli_affected_rows($database->connect) == 1 ) ? true : false;

    }
    function save() {
        return isset($this->id) ? $this->update() : $this->create(); 
    }
    function delete() {
        global $database;
        $the_id = $database->escape_string($this->id);
        $sql = "DELETE FROM " . static::$db_table . " WHERE id = {$the_id}";
        $database->query($sql);        
        return (mysqli_affected_rows($database->connect) == 1 ) ? true : false;
    }
    function has_the_attribute($the_attribute) {
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute,$object_properties);
    }
    static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $result = $database->query($sql);
        $row = mysqli_fetch_array($result);
        return array_shift($row);
    }
    

}

?>