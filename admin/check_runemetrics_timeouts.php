<?php

$testing = true;

include_once("header.php");

$resetTimedoutUsersQuery = "UPDATE users set setup_state = 1 WHERE setup_state = 7;";
$resetTimedoutUsersResult = $mysqli->query($resetTimedoutUsersQuery);
if (!$resetTimedoutUsersResult) {
  print_p("ERROR: ".mysqli_error($mysqli).". From sql query - \"$getUsersInProcessQuery\"", true);
}

$getUsersInProcessQuery = "SELECT id FROM users WHERE setup_state = 7;";
$getUsersInProcessResult = $mysqli->query($getUsersInProcessQuery);
if (!$getUsersInProcessResult) {
  print_p("ERROR: ".mysqli_error($mysqli).". From sql query - \"$getUsersInProcessQuery\"", true);
}

 ?>
