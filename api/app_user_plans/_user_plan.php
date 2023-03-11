<?php

class app_user_plan
{

    // database connection and table name
    private $conn;
    private $table_name = "app_user_plans";

    // object properties
    public $id;
    public $user_id;
    public $plan_id;
    public $status_id;
    public $action_by;
    public $started_on;
    public $end_on;
    public $created_on;
    public $action_on;
    public $total_credits;
    public $is_cancelled;
    public $cancelled_on;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function add_new()
    {
        $query = "INSERT INTO " . $this->table_name;

        //Columns
        $query = $query . " ( user_id, plan_id, status_id, created_on, started_on, end_on, total_credits ) ";

        //Values
        $query = $query . " Values ( :user_id, :plan_id, 1, now(), now(), DATE_ADD(NOW(), INTERVAL 1 MONTH), :total_credits ) ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':plan_id', $this->plan_id);
        $stmt->bindParam(':total_credits', $this->total_credits);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // filter
    function filter()
    {
        // select all query
        $query = "SELECT t1.*, t2.plan_name, t2.credits, t2.price, t2.months, t3.status_name, t4.login_name, t4.first_name, t4.last_name FROM " . $this->table_name . ' as t1 ';
        $query = $query . ' INNER JOIN app_plans as t2 on t1.plan_id = t2.id';
        $query = $query . ' INNER JOIN app_user_plan_status as t3 on t1.status_id = t3.id';
        $query = $query . ' INNER JOIN app_users as t4 on t1.user_id = t4.id';
        $query = $query . ' where t1.id > 0 ';

        if (isset($this->user_id)) {
            $query = $query . ' and t1.user_id = ' . $this->user_id;
        }

        if (isset($this->is_cancelled)) {
            $query = $query . ' and t1.is_cancelled = ' . $this->is_cancelled;
        }

        $query = $query . ' order by t1.id desc; ';

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // filter
    function count_user_credits()
    {
        // select all query
        $query = "SELECT SUM(t2.credits) as credits FROM " . $this->table_name . ' as t1 ';
        $query = $query . ' INNER JOIN app_plans as t2 on t1.plan_id = t2.id';
        $query = $query . '  WHERE t1.status_id = 1 and started_on is not null and end_on is not null and date(end_on) >= Date(Now()) ';

        $query = $query . ' and t1.user_id = ' . $this->user_id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update_status()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set status_id =:status_id";

        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':status_id', $this->status_id);
        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update_cancel_status()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set is_cancelled =:is_cancelled, cancelled_on = now() ";

        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':is_cancelled', $this->is_cancelled);
        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
