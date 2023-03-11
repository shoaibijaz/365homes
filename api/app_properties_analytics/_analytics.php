<?php

class app_property_analytics
{

    // database connection and table name
    private $conn;
    private $table_name = "app_properties_analytics";

    // object properties
    public $id;
    public $property_id;
    public $tracking_id;
    public $tracking_type;
    public $tracking_script;
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
        $query = $query . " ( property_id, tracking_id, tracking_type, tracking_script, created_on ) ";

        //Values
        $query = $query . " Values ( :property_id, :tracking_id, :tracking_type, :tracking_script, now() ) ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':property_id', $this->property_id);
        $stmt->bindParam(':tracking_id', $this->tracking_id);
        $stmt->bindParam(':tracking_type', $this->tracking_type);
        $stmt->bindParam(':tracking_script', $this->tracking_script);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // filter
    function filter($user_id)
    {

        // select all query
        $cls = 'SELECT t1.*, t2.address from ';
        $query = $cls . $this->table_name. ' as t1 ';
        $query = $query . 'inner join app_properties as t2 on t2.id = t1.property_id ';

        $query = $query .' where t1.id > 0 ';

        if (isset($this->property_id)) {
            $query = $query . ' and t1.property_id = ' . $this->property_id;
        }

        if (isset($user_id)) {
            $query = $query . ' and t2.owner_id = ' . $user_id;
        }

        $query = $query . ' order by t1.id desc;';

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

}
