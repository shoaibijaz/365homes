<?php

class app_user_plan_payment
{

    // database connection and table name
    private $conn;
    private $table_name = "app_user_plan_payments";

    // object properties
    public $id;
    public $user_plan_id;
    public $user_id;
    public $gateway;
    public $amount_total;
    public $amount_paid;
    public $data;
    public $details;
    public $order_id;
    public $status_id;
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
        $query = $query . " ( user_plan_id, user_id, gateway, amount_total, amount_paid, data, details, order_id ,status_id, created_on ) ";

        //Values
        $query = $query . " Values ( :user_plan_id, :user_id, :gateway, :amount_total, :amount_paid, :data, :details, :order_id, 1, now() ) ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_plan_id', $this->user_plan_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':gateway', $this->gateway);
        $stmt->bindParam(':amount_total', $this->amount_total);
        $stmt->bindParam(':amount_paid', $this->amount_paid);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':data', $this->data);
        $stmt->bindParam(':order_id', $this->order_id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // filter
    function filter_agent()
    {
        // select all query
        $query = "SELECT t1.* FROM " . $this->table_name . ' as t1 ';
        $query = $query . ' where t1.id > 0 ';

        if (isset($this->user_id)) {
            $query = $query . ' and t1.user_id = ' . $this->user_id;
        }

        if (isset($this->user_plan_id)) {
            $query = $query . ' and t1.user_plan_id = ' . $this->user_plan_id;
        }

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
