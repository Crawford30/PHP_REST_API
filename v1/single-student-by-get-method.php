<?php 

//displaying error

ini_set("display_errors", 1);  //error flag


//SETTING/INCLUDING HEADERS

header("Access-Control-Allow-Origin: *"); //Access from every site where the api is used. ie it allows all localhost, any domain or subdomains


header("Access-Control-Allow-Methods: GET"); //Should only be accessible for the POST request type ie method type


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


if($_SERVER['REQUEST_METHOD'] === "GET") {

	//we pass a student id to get a single record

	//WE NEED TO PASS A PARAMETER OF id WHILE CALLING A SINGLE STUDENT

	$student_id = isset($_GET['id']) ? intval($_GET['id']) : ""; //we pass the id in the query string as URL and convert to in using inval, if it doesnt have id we return an empty string

	//CHECKING FOR ID VALUE INSIDE PARAM

	if (!empty($student_id)) { //means if it has a value

		
		$student -> id = $student_id; //initalising the id  and putting a value in a student property


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
				"message" => "Student not found  "


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