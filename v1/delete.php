<?php 

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




	//FIRST WE NEED TO RECIEVE THE ID

	$student_id = isset($_GET['id']) ? $_GET['id'] : "";


	if (!empty($student_id)) {

		//means we have some value

		$student -> id =  $student_id;  //$student -> id, property id of student from  $student = new Student($connection); 


		//CALLING THE METHOD 

		if($student -> delete_student()) {

				//means we succesffully deleted

				http_response_code(200); //ok

				echo json_encode(array(

				"status" => 1,
				"message" => "Student deleted successfully"
				));




			} else {

				http_response_code(500); //server error

				echo json_encode(array(

				"status" => 0,
				"message" => "Failed to delete student"
				));

		}







	} else {
		//no value

		http_response_code(404); //data not found

		echo json_encode(array(

		"status" => 0,
		"message" => "All data needed"
	));



}






} else {
		//PROTECTION OF ALL REQUEST TYPE

	http_response_code(503); //service unavalibale

	echo json_encode(array(

		"status" => 0,
		"message" => "Access Denied"
	));
}







?>