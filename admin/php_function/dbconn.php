<?php

$dbUsername = "root";
$dbPassword = "";
$dbServername = "";
$dbName = "fairfields_db";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName) or die("connection failed");
