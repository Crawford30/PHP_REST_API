<?php 

//SETTING/INCLUDING HEADERS

header("Access-Control-Allow-Origin: *"); //Access from every site where the api is used. ie it allows all localhost, any domain or subdomains

header("Content-type: application/json; Charset = UTF-8");  //Recieves the data in json format

header("Access-Control-Allow-Methods: POST"); //Should only be accessible for the post request type ie method type


//include database.php

include_once("../config/database.php"); //  ./ from current directory  ../ means go back two steps

//include student.php

include_once("../classes/student.php");


//Create object for database

$db = new Database();  //Database in the class inside database.php


//we call connect, still connect is a method inside database.php

$connection = $db  -> connect();


//create object for student


$student = new Student($connection); //Student is the class inside student.php, we pass the connection inside the student object since inside the Student class, there is a contructor with connction object


//WE CHECK FILE TO ONLY BE ACCESSED FOR THE POST REQUEST

if ($_SERVER['REQUEST_METHOD'] === "POST") { 

	//we have to receive all the post data

	$data = json_decode(file_get_contents("php://input")); //reading data from the body using "php://input"

	if (!empty($data -> name) && !empty($data -> email) && !empty($data -> mobile) && !empty($data -> id)) {
		//checking to make sure that all values are required


		//INITIALISING
		$student -> name = $data -> name; // student.name = data.name
		$student -> email = $data -> email;
		$student -> mobile = $data -> mobile;
		$student -> id = $data -> id;



		//WE CALL UPDATE METHOD FROM THE STUDENT CLASS

		if ($student -> update_student()) {

			//if we successfully updated 

			http_response_code(200); //ok

			echo json_encode(array(

				"status" => 1,
				"message" => "Student data successfully updated."
			));





		} else {
			http_response_code(500); //server error

			echo json_encode(array(

				"status" => 0,
				"message" => "Failed to update data"
			));



		}

	} else {



			http_response_code(404); //page not found

			echo json_encode(array(

				"status" => 0,
				"message" => "All data needed"
			));



	}

} else {


http_response_code(503);  //service unavaliable


echo json_encode( array (

	"status" => 0,
	"message" => "Access Denied"


)
);



}






?>