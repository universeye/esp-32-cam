<?php

$port = 3306;
$servername = "localhost";

// REPLACE with your Database name
$dbname = "production_database";
// REPLACE with Database user
$username = "application";
// REPLACE with Database user password
$password = "97xYGZhBqreSx7NVzn";

$conn = new mysqli($servername, $username, $password, $dbname, $port);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $imageFile  = "";
echo $_SERVER["REQUEST_METHOD"] ;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $imageFile = test_input($_POST["imageFile"]);

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname, $port);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO shrimp_photos (imageFile) VALUES ('" . $imageFile . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}


function test_input($data) {
    $data = trim($data);
    //$data = stripslashes($data);
    //$data = htmlspecialchars($data);
    return $data;
}