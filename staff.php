<?php
session_start();
include("include/config.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="style/staff.css">

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src="https://kit.fontawesome.com/3a4d23485c.js" crossorigin="anonymous"></script>

    <title>Admin</title>

</head>

<body>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_SESSION['UID']) && !empty($_SESSION['UID'])) {
        $sql = $sql = "SELECT * FROM patient";
        $result = mysqli_query($conn, $sql);
    } else {
        header("location:./admin_staff.php");
    }
    ?>

    <div class="container-fluid navbar mb-5">
        <div class="col-12">
            <h1 class="text-center">Staff</h1>
        </div>
    </div>

    <div class="container">

        <h2 class="text-center mb-5">Upcoming Schedule</h2>


        <?php
        if ($_SESSION['position'] == 'dentist') {
            $sql = "SELECT s.id, s.dentistID, s.nurseID, s.date, s.time_from, s.time_to, s.room_number, s.update_date,
                CONCAT(n.firstName, ' ', n.lastName) AS nurseName
                FROM schedule s
                JOIN nurse n ON s.nurseID = n.id
                WHERE s.dentistID=" . $_SESSION['UID'];
        } else if ($_SESSION['position'] == 'nurse') {
            $sql = "SELECT s.id, s.dentistID, s.nurseID, s.date, s.time_from, s.time_to, s.room_number, s.update_date,
                CONCAT(d.firstName, ' ', d.lastName) AS dentistName
                FROM schedule s
                JOIN dentist d ON s.dentistID = d.id
                WHERE s.nurseID=" . $_SESSION['UID'];
        }
        $resultSchedule = mysqli_query($conn, $sql);
        ?>

        <table class="table table-bordered mb-5">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Room Number</th>
                    <th scope="col" class="text-center">Dentist</th>
                    <th scope="col" class="text-center">Nurse</th>
                    <th scope="col" class="text-center">Date</th>
                    <th scope="col" class="text-center">Time</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (mysqli_num_rows($resultSchedule) > 0) {
                    $numRow = 1;
                    if ($_SESSION['position'] == 'dentist') {
                        while ($rowSchedule = mysqli_fetch_array($resultSchedule)) {
                            echo "<tr>";
                            echo "<td class=\"text-center\">$numRow</td>";
                            echo "<td class=\"text-center\">Room " . $rowSchedule['room_number'] . "</td>";
                            echo "<td class=\"text-center\">" . $_SESSION['firstName']. " ". $_SESSION['lastName'] . "</td>";
                            echo "<td class=\"text-center\">" . $rowSchedule['nurseName'] . "</td>";
                            echo "<td class=\"text-center\">" . $rowSchedule['date'] . "</td>";
                            echo "<td class=\"text-center\">" . $rowSchedule['time_from'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        while ($rowSchedule = mysqli_fetch_array($resultSchedule)) {
                            echo "<tr>";
                            echo "<td class=\"text-center\">$numRow</td>";
                            echo "<td class=\"text-center\">Room " . $rowSchedule['room_number'] . "</td>";
                            echo "<td class=\"text-center\">" . $rowSchedule['dentistName'] . "</td>";
                            echo "<td class=\"text-center\">" . $_SESSION['firstName']. " ". $_SESSION['lastName'] . "</td>";
                            echo "<td class=\"text-center\">" . $rowSchedule['date'] . "</td>";
                            echo "<td class=\"text-center\">" . $rowSchedule['time_from'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    //     while ($row = mysqli_fetch_array($result)) {
                    //         echo "<tr>";
                    //         echo "<td class=\"text-center\">$numRow</td>";
                    //         echo "<td>Room " . $row['room_number'] . "</td>";
                    //         echo "<td>" . $row['nurseName'] . "</td>";
                    //         echo "<td> " . $row['date'] . "</td>";
                    //         echo "<td> " . $row['time_from'] . "</td>";

                    //         echo '<td class="text-center">';
                    //         echo '<a href="edit_schedule.php?id=' . $row['id'] . '">Edit</a>';
                    //         echo '&nbsp;&nbsp;';
                    //         echo '<a href="schedule_detail.php?id=' . $row['id'] . '">View</a>';
                    //         echo '&nbsp;&nbsp;';
                    //         echo '<a href="./include/delete_schedule_action.php?id=' . $row['id'] . '" class="text-danger" onClick="return confirm(\'Delete?\');">Delete</a>';
                    //         echo '</td>';

                    //         echo "</tr>";
                    //         $numRow = $numRow + 1;
                    //     }
                } else {
                    echo '<tr><td colspan="6">0 results</td></tr>';
                }
                ?>

            </tbody>
        </table>





        <h2 class="text-center mb-5">Patient List</h2>







        <table class="table table-bordered mb-5">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center w-80">Name</th>
                    <th scope="col" class="text-center w-20">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $numRow = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>$numRow</td>";
                        echo "<td>" . $row['firstName'] . " " . $row['lastName'] . "</td>";

                        echo '<td class="text-center">';
                        echo '<a href="edit_patient.php?id=' . $row['id'] . '">Edit</a>';
                        echo '&nbsp;&nbsp;';
                        echo '<a href="patient_detail.php?id=' . $row['id'] . '">View</a>';
                        echo '&nbsp;&nbsp;';
                        echo '<a href="./include/delete_patient_action.php?id=' . $row['id'] . '" class="text-danger" onClick="return confirm(\'Delete?\');">Delete</a>';
                        echo '</td>';

                        echo "</tr>";
                        $numRow = $numRow + 1;
                    }
                } else {
                    echo '<tr><td colspan="6">0 results</td></tr>';
                }
                ?>

            </tbody>
        </table>




        <div class="col-12 text-center">
            <a href="./add_patient.php" class="btn btn-primary">Add Patient</a>
        </div>

        <div class="col-12 text-center mt-5">
            <a href="./include/logout_action.php" class="btn btn-danger">Logout</a>
        </div>



    </div>

</body>

</html>