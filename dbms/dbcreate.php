<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if($conn -> connect_error) {
    die("Connection failed:". $conn -> connect_error);
}

$sql = "CREATE DATABASE Elearn";
if($conn -> query($sql) === TRUE)
    echo "Database Created Successfully!";
else
    echo "Error creating database: ".$conn->error;

$conn->select_db('Classicstore');

if($conn->select_db('Elearn') === FALSE)
    echo "Error selecting database: ".$conn->error;
else 
    echo "Database selected successfully";

$sql = "SHOW DATABASE";
$result = $conn -> query($sql);

$conn->close();
?>