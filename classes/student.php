<?php 

class Student {

	//we declare some varaibles, making sure they correspond to the database details

	//we declared them public because we gonna access them in the create.php and databse.php

	 public $name;
	 public $email;
     public $mobile;

     //connection varaible and table name varaibele

     //mean while these two below are going tpo be internally used in this class.
     private $conn;
     private $table_name;


     //Define our condtrct function, ie construtor

     public function  __construct($db) {
     	//$db is the connect object variable


     	//initalisation

     	$this ->  conn = $db ; //will start the connection variable


     	$this -> table_name = "tbl_students";  //our table name is tbl_students



     }

     //Method for cresating data in the database tabele

     public function create_data() {

     	//we write the insert query, sql query to insert data

     	$query = "INSERT INTO ".$this->table_name." 
     	SET name = ?,  email = ?, mobile = ?";

     	//prepare the sql query
     	//$obj = $this -> conn -> prepare($query);   //use prepare method and pass our query variable

     	$obj = $this -> conn -> prepare($query);


     	//Before inserting , we need to sanitize the values, name, email, mobile. sanitizs we remove some special charaters

     	//sanitize input variables => removes the extra xters like some special symbols as well as if some tags avalioable in input values

     	//we use 2 php functions, one is html special character, and history tags


     	$this -> name = htmlspecialchars(strip_tags($this -> name)); 

     	$this -> email = htmlspecialchars(strip_tags($this -> email)); 

     	$this -> mobile = htmlspecialchars(strip_tags($this -> mobile)); 



     //We now bind the parameters to the placeholders,  name = ?,  email = ?, mobile = ?
     //ie $this -> name to  name = ?


     	$obj -> bind_param("sss", $this -> name, $this -> email, $this -> mobile); //emthod used to bind parameters  to the place holders, the sss means the name as a string  valeu, email as a string value and mobile as a string value. if it has interger we use i


     	//WE need to execute, we check the obj

     	if ($obj -> execute()) { //executin the query

     		return true;

     	}

     	return false;


     }





     //METHOD TO READ ALL DATA FOR list-all.php

     public function get_all_data() {

     	//returns all the data from the database table

     	$sql_query = "SELECT * FROM ".$this -> table_name;

     	//EXECUTE THE QUERY

     	$std_obj = $this -> conn -> prepare($sql_query); //prepare statement

     	//execute query

     	$std_obj  -> execute();

     	return $std_obj ->  get_result();  //returns all the data





     }





}





?>