<?php 

//displaying error

//ini_set("display_errors", 1);  //error flag


//SETTING/INCLUDING HEADERS

header("Access-Control-Allow-Origin: *"); //Access from every site where the api is used. ie it allows all localhost, any domain or subdomains

header("Content-type: application/json; Charset = UTF-8");  //Recieves the data in json format

header("Access-Control-Allow-Methods: POST"); //Should only be accessible for the GET request type ie method type


//include database.php

include_once("../config/database.php"); //  ./ from current directory  ../ means go back two steps

//include student.php

include_once("../classes/student.php");


//Create object for database

$db = new Database();  //Database in the class inside database.php


//we call connect, still connect is a method inside database.php
$connection = $db  -> connect();  //connectivity to the databse


//create object for student
$student = new Student($connection); 


if($_SERVER['REQUEST_METHOD'] === "POST") {

	//we pass a student id to get a single record

	//WE NEED TO PASS A PARAMETER OF id WHILE CALLING A SINGLE STUDENT

	$param = json_decode(file_get_contents("php://input"));

	//CHECKING FOR ID VALUE INSIDE PARAM

	if (!empty($param -> id)) {

		
		$student -> id = $param -> id; //getting the id 

		$student_data = $student -> get_single_student(); //calling the method

		//print_r($student_data);

		//CECH IF THE DATA IS NOT EMPTY

		if (!empty($student_data)) {

			http_response_code(200); //means ok status

			echo json_encode(array(

				"status" => 1,
				"data" => $student_data


			));


		} else {
			//if empty


			http_response_code(404); // data not found

			echo json_encode(array(
				"status" => 0,
				"message" => "Student not found"


			));



		}

	}



} else {

	http_response_code(503); //service unavaliable


	echo  json_encode(array(


		"status" => 0,
		"message" => "Access Denied"


	));


}




?>