<?php 

class Student {

	//we declare some varaibles, making sure they correspond to the database details

	//we declared them public because we gonna access them in the create.php and databse.php

	 public $name;
	 public $email;
     public $mobile;

     public $id; //used when updating a student

     //connection varaible and table name varaibele

     //mean while these two below are going tpo be internally used in this class.
     private $conn;
     private $table_name;


     //Define our construct function, ie construtor

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

     //READ SINGLE STUDENT DATA

     public function get_single_student() {

     	$sql_query = "SELECT * FROM ".$this ->  table_name." WHERE id = ?"; //? means dynamic id we gonna pass by request of api


     	//PREPARE STAEMENT

     	$obj = $this -> conn -> prepare($sql_query);

     	//FIND PLACEHOLDER
     	$obj -> bind_param("i", $this -> id); //use i for integer id value ie bind paramwtere with the prepared statemnt


     	//EXECUTE

     	$obj -> execute();


     	//GET THE RESULTS

     	$data = $obj -> get_result();

     	//WE RETURN THE DATA AND FETCH IT AS ASSOCAITIVE ARRAY

     	return $data -> fetch_assoc();  //converting the data into assocaitive array


     }


     //UPDATING STUDENT AND INFORMTION

     public function update_student() {

     	//QUERY

     	//on updating we need to pass the table name

     	$query_update = "UPDATE  tbl_students SET  name = ?, email = ?, mobile = ?  WHERE id = ?";  //using the id to update name, email, mobile number


     	//PREPARE STATEMENT
     	$query_object = $this -> conn -> prepare($query_update);

     	//SANITIZE OUR INPUTS as we know from the post data, we gonna take the name, email,mobile and the id


     	$this -> name = htmlspecialchars(strip_tags($this -> name)); 

     	$this -> email = htmlspecialchars(strip_tags($this -> email)); 

     	$this -> mobile = htmlspecialchars(strip_tags($this -> mobile)); 

     	$this -> id = htmlspecialchars(strip_tags($this -> id)); 

     	//BINDING PARAMETERS WITH THE QUERY

     	$query_object -> bind_param("sssi", $this -> name, $this -> email, $this -> mobile, $this -> id); //should correspnd with the places  holder sssi

     	//EXECUTE THE QUERY

     	if ($query_object -> execute()) { //returns true or false value

     		//if sucess, return true

     		return true;

     	}

     	//else return false value

     	return false;

     }



//DELETE STUDENT

 public function delete_student() {

 	$delete_query = "DELETE from  ".$this -> table_name." WHERE  id = ?";

 	//PREPARE STATEMENT

 	$delete_obj = $this -> conn -> prepare($delete_query);

 	
 	//SANITIZE THE INPUTS
 	$this -> id = htmlspecialchars(strip_tags($this -> id)); //the id will be used in delete.php  


 	//BINDING THE PARAMETER WITH THE PLACE HOLDER,ie id

 	 $delete_obj -> bind_param("i", $this -> id); //attached the value to the placeholder

 	 //EXECUTE THE QUERY

 	 if ($delete_obj -> execute()) {

 	 	//if succesfully  executed

 	 	return true;
 	 }

 	 //if not successfully 

 	 return false;


 }



}





?>