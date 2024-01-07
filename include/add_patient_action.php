<?php

session_start();
include("config.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$target_dir = "../uploads/";

$target_file = "";
$uploadOk = 0;
$imageFileType = "";
$uploadfileName = "";

$firstName = "";
$lastName = "";
$pwdHash = "";
$exist = "";
//STEP 1: Form data handling using mysqli_real_escape_string function to 
// escape special characters for use in an SQL query,
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = mysqli_real_escape_string($conn, $_POST["firstName"]);
    $lastName = mysqli_real_escape_string($conn, $_POST["lastName"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
    $phone = $_POST["phone"];
    $ic = $_POST["ic"];
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);

    $sql = "SELECT * FROM patient  WHERE ic='$ic' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $exist = true;
        $message = "Error: Dentist exist, please register a new dentist";
        include("./add_patient_message.php");
    }


    // Check if there is an image to be uploaded
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK && $exist == false) {

        $filetmp = $_FILES["fileToUpload"];
        $uploadfileName = $filetmp["name"];
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            $message = "Sorry, image file $uploadfileName already exists";
            $uploadOk = 0;
            include("./add_patient_message.php");
        }

        // Check file size <= 488.28KB or 500000 bytes
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $message = "Sorry, your file is too large. Try resizing your image.";
            $uploadOk = 0;
            include("./add_patient_message.php");
        }

        // Allow only these file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
            $uploadOk = 0;
            include("./add_patient_message.php");
        }

        // Check if uploadOk==1 and continue
        if ($uploadfileName != "" && $uploadOk == 1) {


            $sql = "INSERT INTO patient(ic,email,mobile,gender,address,firstName,lastName,photo) VALUES ('$ic','$email',$phone,'$gender','$address','$firstName','$lastName','$uploadfileName')";

            $status = update_DbTable($conn, $sql);

            if ($status) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $message = "Form data updated successfully";
                    include("./add_patient_message.php");
                } else {
                    $message = "Sorry, there was an error uploding your file";
                    include("./add_patient_message.php");
                }
            } else {
                $message = "Sorry, there was an error uploading your data";
                include("./add_patient_message.php");
            }
        }
    }
    // There is no image to be uploaded so save the record
    else if ($exist == false) {
        // $sql = "UPDATE Profile SET name='$name',email='$email',program='$program',mentorName='$mentorName',motto='$motto' WHERE matricNo='$matricNo'";
        $sql = "INSERT INTO patient(ic,email,mobile,gender,address,firstName,lastName) VALUES ('$ic','$email','$phone','$gender','$address','$firstName','$lastName')";

        $status = update_DbTable($conn, $sql);

        if ($status) {
            $message = "Success Add New Patient $firstName $lastName";
            include("./add_patient_message.php");
        } else {
            $message = "Sorry, there was an error uploading your data";
            include("./add_patient_message.php");
        }
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
