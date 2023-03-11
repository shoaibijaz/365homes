<?php

class app_property_feature
{

    // database connection and table name
    private $conn;
    private $table_name = "app_properties_features";

    // object properties
    public $id;
    public $property_id;
    public $title;
    public $image;
    public $value;
    public $sort_order;
    public $created_on;
    public $is_deleted;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function add_new()
    {
        $query = "INSERT INTO " . $this->table_name;

        //Columns
        $query = $query . " ( property_id, title, image, value, sort_order, created_on ) ";

        //Values
        $query = $query . " Values ( :property_id, :title, :image, :value, :sort_order, now() ) ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':property_id', $this->property_id);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':value', $this->value);
        $stmt->bindParam(':sort_order', $this->sort_order);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set title =:title,
        value =:value,
        sort_order =:sort_order,
        image =:image
         ";

        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':value', $this->value);
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
