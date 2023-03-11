<?php

class app_setting
{

    // database connection and table name
    private $conn;
    private $table_name = "app_properties_settings";

    // object properties
    public $id;
    public $property_id;
    public $key_name;
    public $key_value;
    public $is_deleted;
    public $created_on;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function add_new()
    {
        $query = "INSERT INTO " . $this->table_name;

        //Columns
        $query = $query . " ( property_id, key_name, key_value, created_on ) ";

        //Values
        $query = $query . " Values ( :property_id, :key_name, :key_value, now() ) ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':key_name', $this->key_name);
        $stmt->bindParam(':key_value', $this->key_value);
        $stmt->bindParam(':property_id', $this->property_id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update_delete_status_key()
    {
        $query = "Update " . $this->table_name;
        $query = $query . " set is_deleted =:is_deleted ";

        $query = $query . " where key_name=:key_name and property_id=:property_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':key_name', $this->key_name);
        $stmt->bindParam(':property_id', $this->property_id);
        $stmt->bindParam(':is_deleted', $this->is_deleted);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function delete_by_key()
    {
        $query = "DELETE FROM " . $this->table_name;

        $query = $query . " where key_name=:key_name ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':key_name', $this->key_name);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function find_by_key()
    {
        $query = "select * from " . $this->table_name;

        $query = $query . " where key_name=:key_name and property_id=:property_id and is_deleted=0 ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':key_name', $this->key_name);
        $stmt->bindParam(':property_id', $this->property_id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // filter
    function filter()
    {
        // select all query
        $cls = 'SELECT * from ';
        $query = $cls . $this->table_name . ' as t1 ';
        $query = $query . ' where t1.id > 0 ';

        $query = $query . ' order by t1.id desc; ';

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

}
