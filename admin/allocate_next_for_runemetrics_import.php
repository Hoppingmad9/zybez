<?php

$testing = false;

include_once("header.php");

$checkForAllocatedUserQuery = "SELECT id FROM users WHERE setup_state = 7;";
$checkForAllocatedUserResult = $mysqli->query($checkForAllocatedUserQuery);
if (!$checkForAllocatedUserResult) {
    print_p("ERROR: ".mysqli_error($mysqli).". From sql query - \"$checkForAllocatedUserQuery\"", true);
}
else {
    if ($checkForAllocatedUserResult->num_rows == 0) {
        $getUserToAllocateQuery = "SELECT id FROM users WHERE setup_state = 1 LIMIT 1;";
        $getUserToAllocateResult = $mysqli->query($getUserToAllocateQuery);
        if (!$checkForAllocatedUserResult) {
            print_p("ERROR: ".mysqli_error($mysqli).". From sql query - \"$getUserToAllocateQuery\"", true);
        }
        else {
            if ($getUserToAllocateResult->num_rows > 0) {
                $userId = $getUserToAllocateResult->fetch_assoc()['id'];
                $allocateUserQuery = "UPDATE users SET setup_state = 7, setup_state_change = NOW() WHERE id = $userId;";
                $allocateUserResult = $mysqli->query($allocateUserQuery);
                if (!$allocateUserResult) {
                    print_p("ERROR: ".mysqli_error($mysqli).". From sql query - \"$allocateUserQuery\"", true);
                }
                else {
                    print_p("$userId newly allocated");
                }
            }
            else {
                print_p("No one to allocate.");
            }
        }
    }
    else {
        $userId = $checkForAllocatedUserResult->fetch_assoc()['id'];
        print_p("$userId currently allocated.");
    }
}
