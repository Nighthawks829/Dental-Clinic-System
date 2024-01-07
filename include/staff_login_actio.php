<?php

session_start();
include("config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);


// login values from login form
$userEmail = $_POST["email"];
$userPwd = $_POST["password"];

$sql = "SELECT 'dentist' AS position, id, email,firstName,lastName, password FROM dentist WHERE email='$userEmail' 
        UNION 
        SELECT 'nurse' AS position, id, email,firstName,lastName ,password FROM nurse WHERE email='$userEmail' LIMIT 1";

$result = mysqli_query($conn, $sql);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (mysqli_num_rows($result) == 1) {
        // Check password hash
        $row = mysqli_fetch_assoc($result);
        if (password_verify($userPwd, $row['password'])) {
            //echo "Login successful. <br> Welcome <b>".$userEmail."</b>.<br /><br />";		
            //echo '<a href="index.php">Home</a> &nbsp;&nbsp;&nbsp; <br>';
            // Echo JavaScript for a popup window
            // echo '<script type="text/javascript"> alert("Login successful!"); </script>';
            $_SESSION['UID'] = $row["id"];
            $_SESSION['email'] = $row['email'];
            $_SESSION['position'] = $row['position'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['lastName'] = $row['lastName'];
            // set loggied in time
            $_SESSION["loggedin_time"] = time();
            header("location: ../staff.php");
        } else {
            // matricNo & pwd not correct
            $dbpwd = $row['password'];
            $userPwd = $_POST["password"];
            $message = "Login error, user and password is incorrect.";
            include("./staff_login_message.php");
        }
    } else {
        // user matricNo not exist
        $message = "Login error, user email does not exist";
        include("./staff_login_message.php");
    }

    mysqli_close($conn);
}
