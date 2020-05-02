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

	//AFTER SETTING THE HEADER< WE ARE GOING TO RECEIVE THE DATA

	$data  = json_decode(file_get_contents("php://input")); //getting data from the requested body parameter

	//print_r($data); die;

	//checking the data


	if (!empty($data -> name) && !empty($data -> email) && !empty($data -> mobile) ) {


		//we gonna use variable, and set s offset

	$student -> name = $data -> name;

	$student -> email =  $data -> email;

	$student -> mobile =  $data -> mobile;


	//we call the create method, but it returns a bool value so we need to check, call cr
	//we submit data
//1. we initilaise the varriable, what we have define inside the student class: name, email and mobile

	if ($student -> create_data()) {

		//echo "Student has been created";


		//we return a proper format of message to postman that record has been inserted

		http_response_code(200);  //status code, 200 means we are returning OK value

		echo json_encode(array(
			"status" => 1,

			"message" =>  "Student has been created"
		));

		





	} else {

		//echo "Failed to insert data";  

		http_response_code(500);  //status code, 500 means we some internal server error

		echo json_encode(array(
			"status" => 0,

			"message" =>  "Failed to insert data"
		));
	}



	}




	//ELSE FOR ALL FIELDS ARE REQUIRED

	else {


		http_response_code(404);  //status code, 404 means page not found

		echo json_encode(array(
			"status" => 0,

			"message" =>  "All values needed"
		));
	}




} else {

		//echo "Access Denied";

		http_response_code(503);  //status code, 503 means server unavaliable

		echo json_encode(array(
			"status" => 0,

			"message" =>  "Access Denied"
		));

}




?>