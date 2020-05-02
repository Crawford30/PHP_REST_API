<?php 

//displaying error

//ini_set("display_errors", 1);  //error flag


//SETTING/INCLUDING HEADERS

header("Access-Control-Allow-Origin: *"); //Access from every site where the api is used. ie it allows all localhost, any domain or subdomains

header("Access-Control-Allow-Methods: GET"); //Should only be accessible for the GET request type ie method type




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

//WE CHECK THE FILE TO BE ONLY ACCESSIBLE FOR THE GET REQUEST TYPE

if($_SERVER['REQUEST_METHOD'] === "GET") {

	//means we have get request type

	$data = $student  -> get_all_data();

	//print_r($data); //produces num_rows

	//we check for number of rows to be >0 meaning it has record

	if ($data -> num_rows > 0) {
		//we have some data inside table

		//we have to loop over all values

		//we use while loop


		//Lets declare array of students, we a key records

		$students["records"] = array();

		while($row = $data -> fetch_assoc()) {

			//print_r($row);

			//we push the data in array

			array_push($students["records"], array(

				"id" => $row['id'],

				"name" => $row['name'],


				"email" => $row['email'],

				"mobile" => $row['mobile'],

				"status" => $row['status'],

				"created_at" => date("Y-m-d",strtotime($row['created_at']))




			));

		}

		//after end of while loop

		http_response_code(200); //ok status

		echo json_encode(array(

			"status" => 1,
			"data"  => $students["records"]


		));


	}


} else {

	//means we dont have get request type


	http_response_code(503); //service unavaliable

	echo json_encode(array(

		"status" => 0,
		"message" => "Access Denied"


	));
}







?>