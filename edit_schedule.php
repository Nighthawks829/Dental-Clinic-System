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
        //         $sql = "SELECT s.id, s.dentistID, s.nurseID, s.date, s.time_from, s.time_to, s.room_number, s.update_date,
        // CONCAT(n.firstName, ' ', n.lastName) AS nurseName
        // FROM schedule s
        // JOIN nurse n ON s.nurseID = n.id
        // WHERE s.id=" . $_GET['id'];
        $sql = "SELECT * FROM schedule WHERE id=" . $_GET['id'];
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
        }

        $sqlNurse = "SELECT * FROM nurse";
        $resultNurse = mysqli_query($conn, $sqlNurse);
        $sqlDentist="SELECT * FROM dentist";
        $resultDentist = mysqli_query($conn, $sqlDentist);
    } else {
        header("location:./admin_staff.php");
    }
    ?>

    <div class="container-fluid navbar mb-5">
        <div class="col-12">
            <h1 class="text-center">Edit Schedule</h1>
        </div>
    </div>

    <div class="container">

        <form action="./include/edit_schedule_action.php" method="POST">
            <input type="text" id="id" name="id" value="<?= $_GET['id'] ?>" hidden>
            <div class="row g-4 mb-5">
                <div class="col-12 mb-3">
                    <label for="room" class="mb-2">Room Number</label>
                    <select name="room" id="room" class="form-select">
                        <option selected>Open this select menu</option>
                        <option value="1" <?php echo $row['room_number'] == 1 ? "selected" : "" ?>>1</option>
                        <option value="2" <?php echo $row['room_number'] == 2 ? "selected" : "" ?>>2</option>
                        <option value="3" <?php echo $row['room_number'] == 3 ? "selected" : "" ?>>3</option>
                        <option value="4" <?php echo $row['room_number'] == 4 ? "selected" : "" ?>>4</option>
                        <option value="5" <?php echo $row['room_number'] == 5 ? "selected" : "" ?>>5</option>
                        <option value="6" <?php echo $row['room_number'] == 6 ? "selected" : "" ?>>6</option>
                        <option value="7" <?php echo $row['room_number'] == 7 ? "selected" : "" ?>>7</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="nurseID" class="mb-2">Nurse</label>
                    <select name="nurseID" id="nurseID" class="form-select">
                        <?php
                        if (mysqli_num_rows($resultNurse) > 0) {
                            while ($rowNurse = mysqli_fetch_array($resultNurse)) {
                                $selected = ($rowNurse['id'] == $row['nurseID']) ? 'selected' : '';
                                echo "<option value=" . $rowNurse['id'] . " $selected >" . $rowNurse['id'] . " - " . $rowNurse['firstName'] . " " . $rowNurse['lastName'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>


                <div class="col-12">
                    <label for="dentistID" class="mb-2">Dentist</label>
                    <select name="dentistID" id="dentistID" class="form-select">
                        <?php
                        if (mysqli_num_rows($resultDentist) > 0) {
                            while ($rowDentist = mysqli_fetch_array($resultDentist)) {
                                $selected = ($rowDentist['id'] == $row['dentistID']) ? 'selected' : '';
                                echo "<option value=" . $rowDentist['id'] . " $selected >" . $rowDentist['id'] . " - " . $rowDentist['firstName'] . " " . $rowDentist['lastName'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-12">
                    <label for="date" class="mb-2">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="<?php echo $row['date'] ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="timeFrom" class="mb-2">Time From</label>
                    <input type="time" name="timeFrom" id="timeFrom" class="form-control" value="<?php echo $row['time_from'] ?>" required>
                </div>


                <div class="col-md-6">
                    <label for="timeTo" class="mb-2">Time To</label>
                    <input type="time" name="timeTo" id="timeTo" class="form-control" value="<?php echo $row['time_to'] ?>" required>
                </div>
            </div>

            <div class="col-12 text-center mb-5">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

        <div class="col-12 text-center">
            <!-- <a href="./admin.php" class="btn btn-danger">Back</a> -->
            <?php
                echo '<a href="staff_detail.php?id=' . $_GET['staffid'] . '&position=' . $_GET['position'] . '" class="btn btn-danger">Back</a>';
                ?>
        </div>
    </div>
</body>

</html>