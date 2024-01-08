<?php
session_start();
include("config.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // prepare data
    $id = $_POST["id"];
    $room_number = $_POST["room"];
    $date = $_POST["date"];
    $nurseID = $_POST['nurseID'];
    $dentistID = $_POST['dentistID'];
    $time_from = $_POST["timeFrom"];
    $time_to = $_POST["timeTo"];
    // $update_date = new DateTime("now", new DateTimeZone("Asia/Kuala_Lumpur"));

    // $sql = "UPDATE schedule SET room_number='$room_number',date='$date',time_from=$time_from,time_to='$time_to',update_date='$update_date' WHERE id='$id'";
    $sql = "UPDATE schedule SET room_number='$room_number',nurseID='$nurseID',dentistID='$dentistID' ,date='$date',time_from='$time_from',time_to='$time_to' WHERE id='$id'";

    $status = update_DbTable($conn, $sql);

    if ($status) {
        $message = "Form data and file updated successfully";
        include("./edit_schedule_message.php");
    } else {
        $message = "Sorry, there was an error uploading your data";
        include("./edit_schedule_message.php");
    }
}

mysqli_close($conn);

// Function to insert data to database table
function update_DbTable($conn, $sql)
{
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {

        return false;
    }
}
