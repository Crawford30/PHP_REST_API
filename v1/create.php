<?php 


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


	//we submit data
//1. we initilaise the varriable, what we have define inside the student class: name, email and mobile


	//we get the object, $student  to acccess the varraibale

	$student -> name = "Joel";

	$student -> email = "joel@gmail.com";

	$student -> mobile = "0777677777";


	//we call the create method, but it returns a bool value so we need to check, call cr

	if ($student -> create_data()) {

		echo "Student has been created";



	} else {

		echo "Failed to insert data";  
	}




} else {

echo "Access Denied";

}














?>