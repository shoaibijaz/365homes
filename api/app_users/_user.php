<?php

include_once dirname(__DIR__) . '/mailer.php';

class app_user
{

    // database connection and table name
    private $conn;
    private $table_name = "app_users";

    // object properties
    public $id;
    public $first_name;
    public $last_name;
    public $login_name;
    public $password;
    public $email;
    public $photo;
    public $phone;
    public $is_super;
    public $user_type;
    public $status;
    public $is_deleted;
    public $verified_token;
    public $mail_verified;
    public $password_reset_token;
    public $created_on;
    public $credits;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function add_new()
    {
        $query = "INSERT INTO " . $this->table_name
            . " ( first_name, last_name, login_name, email, phone, password, photo, user_type, is_super, status, credits, created_on) "
            . " Values (:first_name, :last_name, :login_name, :email, :phone, :password, :photo, :user_type, :is_super, :status, :credits, now() );";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':login_name', $this->login_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':user_type', $this->user_type);
        $stmt->bindParam(':is_super', $this->is_super);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':credits', $this->credits);

        // execute query
        $stmt->execute();

        return $stmt;
    }

     //update_admin
     function update_admin()
     {
         try {
 
             $query = "UPDATE " . $this->table_name . ' set first_name =:first_name, ';
             $query = $query . ' last_name =:last_name, phone =:phone, photo =:photo, ';
             $query = $query . ' email =:email, login_name =:login_name, password =:password, ';
             $query = $query . ' user_type =:user_type, is_super =:is_super, status =:status ';
             $query = $query . ' where id =:id; ';
 
             $stmt = $this->conn->prepare($query);
 
             $stmt->bindParam(':first_name', $this->first_name);
             $stmt->bindParam(':last_name', $this->last_name);
             $stmt->bindParam(':login_name', $this->login_name);
             $stmt->bindParam(':email', $this->email);
             $stmt->bindParam(':password', $this->password);
             $stmt->bindParam(':phone', $this->phone);
             $stmt->bindParam(':photo', $this->photo);
             $stmt->bindParam(':user_type', $this->user_type);
             $stmt->bindParam(':is_super', $this->is_super);
             $stmt->bindParam(':status', $this->status);
             $stmt->bindParam(':id', $this->id);
 
             $stmt->execute();
 
             return $stmt;
         } catch (Exception $e) {
             return;
         }
     }

    //update_profile
    function update_profile()
    {
        try {

            $query = "UPDATE " . $this->table_name . ' set first_name =:first_name, ';
            $query = $query . ' last_name =:last_name, phone =:phone, photo =:photo, email =:email ';
            $query = $query . ' where id =:id; ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':photo', $this->photo);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            return;
        }
    }

    function check_login()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name;
        $query = $query . ' Where (email = :email or login_name = :login_name) and password = :password ';
        $query = $query . ' and (status = "active") limit 1;';

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':login_name', $this->email);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function email_count()
    {
        // select all query
        $query = "SELECT count(*) FROM " . $this->table_name . ' Where email = :email';

        if(isset($this->id)) {
            $query = $query . ' and id != ' .$this->id;
        }

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email);

        // execute query
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    // filter user
    function filter()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name . ' where id > 0 ';

        if (isset($this->is_deleted)) {
            $query = $query . ' and is_deleted in (' . $this->is_deleted . ') ';
        }

        if (isset($this->id)) {
            $query = $query . ' and id in (' . $this->id . ') ';
        }

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    //find
    function find()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name . ' Where id=:id  limit 1;';

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update_delete()
    {
        try {

            $query = "UPDATE " . $this->table_name . ' set is_deleted = :is_deleted where id = :id; ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':is_deleted', $this->is_deleted);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            return;
        }
    }

    function update_credits()
    {
        try {

            $query = "UPDATE " . $this->table_name . ' set credits = :credits where id = :id; ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':credits', $this->credits);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            return;
        }
    }

    function get_credits()
    {
       // select all query
       $query = "SELECT credits FROM " . $this->table_name . ' Where id = :id;';

       // prepare query statement
       $stmt = $this->conn->prepare($query);

       $stmt->bindParam(':id', $this->id);

       // execute query
       $stmt->execute();

       return $stmt->fetchColumn();
    }

    function verify_email()
    {

        $query = "UPDATE " . $this->table_name . ' set mail_verified = 1, status="active" where verified_token = :verified_token; ';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':verified_token', $this->verified_token);

        $stmt->execute();

        return $stmt;
    }

    function forgot_password()
    {
        try {

            $obj = (object) [
                'user_email' => $this->email,
                'created_on' => date('Y-m-d H:i:s'),
                'expired_on' => Date('y:m:d', strtotime("+3 days"))
            ];

            $query = "UPDATE " . $this->table_name . ' set password_reset_token = :password_reset_token where email = :email; ';

            $stmt = $this->conn->prepare($query);

            $ekey = $this->my_simple_crypt(json_encode($obj));

            $stmt->bindParam(':password_reset_token', $ekey);
            $stmt->bindParam(':email', $this->email);

            $stmt->execute();

            $myfile = fopen("__pass_reset.html", "r") or die("Unable to open file!");
            $body_html = fread($myfile, filesize("__pass_reset.html"));
            fclose($myfile);

            $title = 'Reset your 365HOMES password';

            $body_html = str_replace("{{action_url}}", "https://365homes.net/reset_password.php?token=" . $ekey, $body_html);

            $body_text = "We got a request to reset your 365HOMES password. Please open following link. https://365homes.net/reset_password.php?token=" . $ekey;

            sendmail($this->email, $body_html, $body_text, $title);

            return $stmt;
        } catch (Exception $e) {
            return;
        }
    }

    function reset_token_password()
    {
        try {

            $query = "UPDATE " . $this->table_name . ' set password = :password where password_reset_token = :password_reset_token; ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':password_reset_token', $this->password_reset_token);
            $stmt->bindParam(':password', $this->password);

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            return;
        }
    }

    function update_password()
    {
        try {

            $query = "UPDATE " . $this->table_name . ' set password = :password where id = :id; ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':password', $this->password);

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            return;
        }
    }

    function change_password()
    {
        try {

            $query = "UPDATE " . $this->table_name . ' set password = :password_reset_token where id = :id and password =:password; ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':password_reset_token', $this->password_reset_token);

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            return;
        }
    }

    function send_verification_email($id)
    {
        try {

            $obj = (object) [
                'user_id' => $id,
                'created_on' => date('Y-m-d H:i:s'),
                'expired_on' => Date('y:m:d', strtotime("+3 days"))
            ];

            $query = "UPDATE " . $this->table_name . ' set verified_token = :verified_token where id = :id; ';

            $stmt = $this->conn->prepare($query);

            $ekey = $this->my_simple_crypt(json_encode($obj));

            $stmt->bindParam(':verified_token', $ekey);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            $myfile = fopen("__verify_email.html", "r") or die("Unable to open file!");
            $body_html = fread($myfile, filesize("__verify_email.html"));
            fclose($myfile);

            $title = 'Confirm your 365HOMES account, ' . $this->first_name . ' ' . $this->last_name;

            $body_html = str_replace("{{action_url}}", "https://365homes.net/verify.php?token=" . $ekey, $body_html);

            $body_text = "Thanks for signing up for 365HOMES! Please open following link. https://365homes.net/verify.php?token=" . $ekey;

            $rr = sendmail($this->email, $body_html, $body_text, $title);

            return $stmt;
        } catch (Exception $e) {
            return;
        }
    }

    function my_simple_crypt($string, $action = 'e')
    {

        $secret_key = 'my_simple_secret_key1';
        $secret_iv = 'my_simple_secret_iv1';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } else if ($action == 'd') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
}
