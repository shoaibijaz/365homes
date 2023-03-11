<?php

class app_property
{

    // database connection and table name
    private $conn;
    private $table_name = "app_properties";

    // object properties
    public $id;
    public $owner_id;
    public $title;
    public $address;
    public $map_location;
    public $price;
    public $property_type;
    public $details_short;
    public $details_long;
    public $sort_order;
    public $is_deleted;
    public $created_on;
    public $main_image;
    public $is_published;
    public $published_on;
    public $transaction_type;
    public $logo;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function add_new()
    {
        $query = "INSERT INTO " . $this->table_name;

        //Columns
        $query = $query . " ( owner_id, address, title, map_location, sort_order, is_deleted, created_on) ";

        $query = $query . " Values ( :owner_id, :address, :title, :map_location, :sort_order, 0, now() )  ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':owner_id', $this->owner_id);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':map_location', $this->map_location);
        $stmt->bindParam(':sort_order', $this->sort_order);
        $stmt->bindParam(':title', $this->title);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update_basic()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set title =:title,
        price =:price,
        property_type =:property_type,
        details_short =:details_short,
        details_long =:details_long,
        transaction_type =:transaction_type
         ";

        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title);
       
        $stmt->bindParam(':property_type', $this->property_type);
        $stmt->bindParam(':details_short', $this->details_short);
        $stmt->bindParam(':details_long', $this->details_long);
        $stmt->bindParam(':transaction_type', $this->transaction_type);
        $stmt->bindParam(':id', $this->id);

        if(isset($this->price) && !empty($this->price)) {
            $stmt->bindParam(':price', $this->price);
        }
        else{
            $stmt->bindValue(":price", null, PDO::PARAM_NULL);
        }

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // filter
    function filter()
    {
        // select all query
        $cls = 'SELECT t1.*, t2.first_name, t2.last_name, t2.email from ';
        $query = $cls . $this->table_name . ' as t1 ';
        $query = $query . ' LEFT JOIN app_users as t2 on t1.owner_id = t2.id ';

        $query = $query . ' where t1.id > 0 ';

        if (isset($this->is_deleted)) {
            $query = $query . ' and t1.is_deleted = ' . $this->is_deleted;
        }

        if (isset($this->owner_id)) {
            $query = $query . ' and t1.owner_id = ' . $this->owner_id;
        }

        if (isset($this->logo) && !empty($this->logo)) {
            $query = $query . ' and t1.id in (select property_id from app_property_agents where agent_id = '.$this->logo.') ';
        }

        $query = $query . ' order by t1.id desc; ';

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // find
    function find()
    {
        // select all query
        $cls = 'SELECT t1.*, t2.first_name, t2.last_name, t2.email from ';
        $query = $cls . $this->table_name . ' as t1 ';
        $query = $query . ' LEFT JOIN app_users as t2 on t1.owner_id = t2.id ';

        $query = $query . ' where t1.id = ' . $this->id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // find_details
    function find_details()
    {
        // select all query
        $cls = 'SELECT t1.*, MIN(t2.sort_order) as sort_order, t2.image, t3.tracking_id from ';
        $query = $cls . $this->table_name . ' as t1 ';
        $query = $query . ' LEFT JOIN app_property_images as t2 on t1.id = t2.property_id ';
        $query =  $query. ' LEFT JOIN app_properties_analytics as t3 on t3.property_id = t1.id ';

        $query = $query . ' where t1.id = ' . $this->id . ' GROUP BY t1.id; ';

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

    function update_main_image()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set main_image =:main_image";

        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':main_image', $this->main_image);
        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update_logo()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set logo =:logo";

        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':logo', $this->logo);
        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update_address()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set address =:address,
        map_location =:map_location,
        sort_order =:sort_order";

        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':map_location', $this->map_location);
        $stmt->bindParam(':sort_order', $this->sort_order);
        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function count_by_user()
    {
        $query = "select count(*) as count from  " . $this->table_name;

        //Columns
        $query = $query . " where id > 0 ";

        $query = $query . " and owner_id = ". $this->owner_id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
