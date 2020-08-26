<?php

$dbUsername = "fairfields_db";
$dbPassword = "fairfields_db";
$dbServername = "localhost";
$dbName = "fairfields_db";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName) or die("connection failed");
