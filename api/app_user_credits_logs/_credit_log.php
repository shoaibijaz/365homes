<?php

class app_user_credit_log
{

    // database connection and table name
    private $conn;
    private $table_name = "app_user_credits_logs";

    // object properties
    public $id;
    public $user_id;
    public $credits;
    public $last_credits;
    public $created_by;
    public $created_on;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function add_new()
    {
        $query = "INSERT INTO " . $this->table_name
            . " ( user_id, credits, last_credits, created_by, created_on) "
            . " Values (:user_id, :credits, :last_credits, :created_by, now() );";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':credits', $this->credits);
        $stmt->bindParam(':last_credits', $this->last_credits);
        $stmt->bindParam(':created_by', $this->created_by);

        // execute query
        $stmt->execute();

        return $stmt;
    }

}
