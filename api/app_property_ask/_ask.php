<?php

include_once dirname(__DIR__) . '/mailer.php';

class app_property_ask
{

    // database connection and table name
    private $conn;
    private $table_name = "app_property_ask";

    // object properties
    public $id;
    public $property_id;
    public $agent_id;
    public $full_name;
    public $email;
    public $phone;
    public $message;
    public $mail_status;
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
        $query = $query . " ( property_id, agent_id, full_name, email, phone, message, is_deleted, created_on ) ";

        //Values
        $query = $query . " Values ( :property_id, :agent_id, :full_name, :email, :phone, :message, 0, now() ) ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':property_id', $this->property_id);
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':message', $this->message);
        $stmt->bindParam(':agent_id', $this->agent_id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // filter
    function get_messages($owner_id)
    {

        // select all query
        $cls = 'SELECT t1.*, t2.address as property_name from ';
        $query = $cls . $this->table_name . ' as t1 ';
        $query = $query . ' INNER JOIN app_properties as t2 on t1.property_id = t2.id ';
        $query = $query . ' where t1.id > 0 ';

        if (isset($owner_id)) {
            $query = $query . ' and t2.owner_id = ' . $owner_id;
        }

        if (isset($this->property_id)) {
            $query = $query . ' and t1.property_id = ' . $this->property_id;
        }

        if (isset($this->is_deleted)) {
            $query = $query . ' and t1.is_deleted = ' . $this->is_deleted;
        }

        $query = $query . ' order by t1.id desc;';

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

    function update_mail_status()
    {
        try {

            $query = "Update " . $this->table_name;
            $query = $query . " set mail_status = :mail_status ";
            $query = $query . ' where id=:id ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':mail_status', $this->mail_status);

            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            return;
        }
    }

    function send_mail($address, $agent_email)
    {
        try {

            $myfile = fopen("__message.html", "r") or die("Unable to open file!");
            $body_html = fread($myfile, filesize("__message.html"));
            fclose($myfile);

            $title = 'CONTACT REQUEST: '.$address;

            $body_html = str_replace("{{address}}",$address, $body_html);
            $body_html = str_replace("{{full_name}}",$this->full_name, $body_html);
            $body_html = str_replace("{{email}}",$this->email, $body_html);
            $body_html = str_replace("{{phone}}",$this->phone, $body_html);
            $body_html = str_replace("{{message}}",$this->message, $body_html);

            $body_text = 'CONTACT REQUEST: '.$address . ' Email: '.$this->email;

           $mr = sendmail($agent_email, $body_html, $body_text, $title);

           return $mr;
           
        } catch (Exception $e) {
            return $e;
        }
    }
}
