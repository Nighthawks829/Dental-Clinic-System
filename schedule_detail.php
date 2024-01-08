<?php
session_start();
include("include/config.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/edit_schedule.css">

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src="https://kit.fontawesome.com/3a4d23485c.js" crossorigin="anonymous"></script>

    <title>Edit Schedule</title>
</head>

<body>

    <?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);


    if (isset($_SESSION['UID']) && !empty($_SESSION['UID'])) {
        $sql = "SELECT s.id, s.dentistID, s.nurseID, s.date, s.time_from, s.time_to, s.room_number, s.update_date,
    CONCAT(n.firstName, ' ', n.lastName) AS nurseName,
    CONCAT(d.firstName, ' ',d.lastName) AS dentistName
    FROM schedule s
    JOIN nurse n ON s.nurseID = n.id
    JOIN dentist d ON s.dentistID=d.id
    WHERE s.id=" . $_GET['id'];
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
        }
    } else {
        header("location:./admin_staff.php");
    }
    ?>

    <div class="container-fluid navbar mb-5">
        <div class="col-12">
            <h1 class="text-center">Schedule Details</h1>
        </div>
    </div>

    <div class="container">

        <div class="row g-4 mb-5">
            <div class="col-md-6">
                Room Number: <?php echo $row['room_number'] ?>
                </select>
            </div>

            <div class="col-md-6">
                Dentist : <?php echo $row['dentistName'] ?>
            </div>

            <div class="col-md-6">
                Nurse : <?php echo $row['nurseName'] ?>
            </div>

            <div class="col-md-6">
                Date: <?php echo $row['date'] ?>
            </div>

            <div class="col-md-6">
                Time From: <?php echo $row['time_from'] ?>

            </div>

            <div class="col-md-6">
                Time To: <?php echo $row['time_to'] ?>
            </div>
        </div>

        <div class="col-12 text-center mb-3">
            <?php
            echo '<a href="edit_schedule.php?id=' . $_GET['id'] . '"class="btn btn-primary mb-3">Edit Schedule</a>';
            ?>

        </div>

        <div class="col-12 text-center">
            <!-- <a href="./admin.php" class="btn btn-danger">Back</a> -->
            <?php
            echo '<a href="staff_detail.php?id=' . $_GET['staffid'] . '&position=' . $_GET['position'] . '" class="btn btn-danger">Back</a>';
            ?>
        </div>
    </div>
</body>

</html>