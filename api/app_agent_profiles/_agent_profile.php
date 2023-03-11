<?php

class app_agent_profile
{

    // database connection and table name
    private $conn;
    private $table_name = "app_agent_profiles";

    // object properties
    public $id;
    public $owner_id;
    public $first_name;
    public $last_name;
    public $company_name;
    public $designation;
    public $photo;
    public $office_contact;
    public $fax;
    public $mobile_contact;
    public $address;
    public $facebook_url;
    public $twitter_url;
    public $website_url;
    public $instagram_url;
    public $linkedin_url;
    public $email_contact;
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
        $query = $query . " ( owner_id, first_name, last_name, company_name, designation, photo, office_contact, fax, mobile_contact, ";
        $query = $query . " address, facebook_url, twitter_url, website_url, instagram_url, email_contact, linkedin_url, created_on ) ";

        //Values
        $query = $query . " Values ( :owner_id, :first_name, :last_name, :company_name, :designation, :photo, :office_contact, :fax, :mobile_contact, ";
        $query = $query . " :address, :facebook_url, :twitter_url, :website_url, :instagram_url, :email_contact, :linkedin_url, now() ) ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':owner_id', $this->owner_id);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':company_name', $this->company_name);
        $stmt->bindParam(':designation', $this->designation);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':office_contact', $this->office_contact);
        $stmt->bindParam(':fax', $this->fax);
        $stmt->bindParam(':mobile_contact', $this->mobile_contact);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':facebook_url', $this->facebook_url);
        $stmt->bindParam(':twitter_url', $this->twitter_url);
        $stmt->bindParam(':website_url', $this->website_url);
        $stmt->bindParam(':instagram_url', $this->instagram_url);
        $stmt->bindParam(':email_contact', $this->email_contact);
        $stmt->bindParam(':linkedin_url', $this->linkedin_url);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name;

        //Columns
        $query = $query . " set first_name =:first_name ,
        last_name =:last_name,
        owner_id =:owner_id,
        company_name =:company_name,
        designation =:designation,
        photo =:photo,
        office_contact =:office_contact,
        fax =:fax,
        mobile_contact =:mobile_contact,
        address =:address,
        facebook_url =:facebook_url,
        twitter_url =:twitter_url,
        website_url =:website_url,
        instagram_url =:instagram_url,
        email_contact =:email_contact,
        linkedin_url =:linkedin_url
         ";

        $query = $query . " where id=:id ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':owner_id', $this->owner_id);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':company_name', $this->company_name);
        $stmt->bindParam(':designation', $this->designation);
        $stmt->bindParam(':office_contact', $this->office_contact);
        $stmt->bindParam(':fax', $this->fax);
        $stmt->bindParam(':mobile_contact', $this->mobile_contact);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':facebook_url', $this->facebook_url);
        $stmt->bindParam(':twitter_url', $this->twitter_url);
        $stmt->bindParam(':website_url', $this->website_url);
        $stmt->bindParam(':instagram_url', $this->instagram_url);
        $stmt->bindParam(':email_contact', $this->email_contact);
        $stmt->bindParam(':linkedin_url', $this->linkedin_url);
        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // filter
    function filter()
    {
        // select all query
        $cls = 'SELECT t1.* from ';
        $query = $cls . $this->table_name . ' as t1 ';
        $query = $query . ' where t1.id > 0';

        if(isset($this->owner_id)) {
            $query = $query . ' and t1.owner_id = ' . $this->owner_id;
        }

        if(isset($this->is_deleted)) {
            $query = $query . ' and t1.is_deleted = ' . $this->is_deleted;
        }

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

     // find
     function count()
     {
         // select all query
         $cls = 'SELECT count(*) as count from ';
         $query = $cls . $this->table_name . ' as t1 ';
         $query = $query . ' where t1.id > 0';
 
         if(isset($this->owner_id)) {
             $query = $query . ' and t1.owner_id = ' . $this->owner_id;
         }
 
         if(isset($this->is_deleted)) {
             $query = $query . ' and t1.is_deleted = ' . $this->is_deleted;
         }
 
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
