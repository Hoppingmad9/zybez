<?php

$testing = true;

include_once("header.php");

$updateTimedoutUsersQuery = "UPDATE users set setup_state = 1, setup_state_change = NOW() WHERE setup_state = 7 AND TIMESTAMPDIFF(MINUTE, setup_state_change, NOW()) > 5;";
$updateTimedoutUsersResult = $mysqli->query($updateTimedoutUsersQuery);
if (!$updateTimedoutUsersResult) {
  print_p("ERROR: ".mysqli_error($mysqli).". From sql query - \"$updateTimedoutUsersQuery\"", true);
}

 ?>
