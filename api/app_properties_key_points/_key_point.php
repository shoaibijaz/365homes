<?php

class app_property_key_point
{

    // database connection and table name
    private $conn;
    private $table_name = "app_properties_key_points";

    // object properties
    public $id;
    public $property_id;
    public $key_point;
    public $sort_order;
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
        $query = $query . " ( property_id, key_point, sort_order, is_deleted, created_on ) ";

        //Values
        $query = $query . " Values ( :property_id, :key_point, :sort_order, 0, now() ) ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':property_id', $this->property_id);
        $stmt->bindParam(':key_point', $this->key_point);
        $stmt->bindParam(':sort_order', $this->sort_order);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set key_point =:key_point, sort_order =:sort_order ";
        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':key_point', $this->key_point);
        $stmt->bindParam(':sort_order', $this->sort_order);
        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // filter
    function filter()
    {

        // select all query
        $cls = 'SELECT * from ';
        $query = $cls . $this->table_name . ' where id > 0 ';

        if (isset($this->property_id)) {
            $query = $query . ' and property_id = ' . $this->property_id;
        }

        if (isset($this->is_deleted)) {
            $query = $query . ' and is_deleted = ' . $this->is_deleted;
        }

        $query = $query . ' order by sort_order';

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update_delete_status()
    {
        try {

            $query = "Update " . $this->table_name;
            $query = $query . " set is_deleted = :is_deleted ";
            $query = $query . ' where id=:id ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':is_deleted', $this->is_deleted);

            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            return;
        }
    }

}
