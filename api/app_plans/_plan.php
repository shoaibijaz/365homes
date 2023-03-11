<?php

class app_plan
{

    // database connection and table name
    private $conn;
    private $table_name = "app_plans";

    // object properties
    public $id;
    public $plan_name;
    public $image;
    public $description;
    public $credits;
    public $months;
    public $price;
    public $level;
    public $special_tag;
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
        $query = $query . " ( plan_name, image, description, credits, months, price, level, special_tag, is_deleted, created_on ) ";

        //Values
        $query = $query . " Values ( :plan_name, :image, :description, :credits, :months, :price, :level, :special_tag, 0, now() ) ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':plan_name', $this->plan_name);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':credits', $this->credits);
        $stmt->bindParam(':months', $this->months);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':level', $this->level);
        $stmt->bindParam(':special_tag', $this->special_tag);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set plan_name =:plan_name, image=:image, description=:description, credits=:credits ";
        $query = $query . " , months=:months, price=:price, level=:level, special_tag=:special_tag";
        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':plan_name', $this->plan_name);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':credits', $this->credits);
        $stmt->bindParam(':months', $this->months);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':level', $this->level);
        $stmt->bindParam(':special_tag', $this->special_tag);
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
        $query = $cls . $this->table_name . ' as t1 ';
        $query = $query . ' where t1.id > 0';

        if (isset($this->is_deleted)) {
            $query = $query . ' and t1.is_deleted = '. $this->is_deleted;
        }
        
        $query = $query . ' order by t1.level; ';

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function find()
    {
        // select all query
        $cls = 'SELECT t1.* from ';
        $query = $cls . $this->table_name . ' as t1 ';

        $query = $query . ' where t1.id = '.$this->id;
  
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
          
    function update_delete_status()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set is_deleted =:is_deleted";

        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':is_deleted', $this->is_deleted);
        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

}
