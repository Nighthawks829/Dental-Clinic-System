<?php
session_start();
include("config.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Variables
$id = "";
$firstName = "";
$lastName = "";
$gender = "";
$phone = "";
$ic = "";
$email = "";
$address = "";
$photo = "";

//for upload
$target_dir = "./../uploads/";
$target_file = "";
$uploadOk = 0;
$imageFileType = "";
$uploadfileName = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $ic = $_POST["ic"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    // Check if there is an image to be uploaded
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        $filetmp = $_FILES["fileToUpload"];
        $uploadfileName = $filetmp["name"];
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            $message = "Sorry, image file $uploadfileName already exists";
            $uploadOk = 0;
            include("./edit_patient_message.php");
        }

        // Check file size <= 488.28KB or 500000 bytes
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $message = "Sorry, your file is too large. Try resizing your image.";
            $uploadOk = 0;
            include("./edit_patient_message.php");
        }

        // Allow only these file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
            $uploadOk = 0;
            include("./edit_patient_message.php");
        }

        // Check if uploadOk==1 and continue
        if ($uploadfileName != "" && $uploadOk == 1) {

            $sql = "UPDATE patient SET ic='$ic',email='$email',mobile='$phone',address='$address',firstName='$firstName',lastName='$lastName',photo='$uploadfileName' WHERE id='$id' ";


            $status = update_DbTable($conn, $sql);

            if ($status) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $message = "Form data and file updated successfully";
                    include("./edit_patient_message.php");
                } else {
                    $message = "Sorry, there was an error uploding your file $target_file";
                    include("./edit_patient_message.php");
                }
            } else {
                $message = "Sorry, there was an error uploading your data";
                include("./edit_patient_message.php");
            }
        }
    }   // There is no image to be uploaded so save the record
    else {
        $sql = "UPDATE patient SET ic='$ic',email='$email',mobile='$phone',address='$address',firstName='$firstName',lastName='$lastName' WHERE id='$id' ";


        $status = update_DbTable($conn, $sql);

        if ($status) {
            $message = "Form data updated successfully";
            include("./edit_patient_message.php");
        } else {
            $message = "Sorry, there was an error uploading your data";
            include("./edit_patient_message.php");
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
