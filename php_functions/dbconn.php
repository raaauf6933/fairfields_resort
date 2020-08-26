<?php

$dbUsername = "fairfields";
$dbPassword = "fairfields";
$dbServername = "localhost";
$dbName = "fairfields_db";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName) or die("connection failed");
