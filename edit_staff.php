<?php
session_start();
include("include/config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/edit_staff.css">

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src="https://kit.fontawesome.com/3a4d23485c.js" crossorigin="anonymous"></script>

    <title>Staff Detail</title>
</head>

<body>

    <?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_SESSION['UID']) && !empty($_SESSION['UID'])) {
        if ($_GET['position'] == 'dentist') {
            $sql = "SELECT * FROM dentist WHERE id='" . $_GET['id'] . "' LIMIT 1";
        } else {
            $sql = "SELECT * FROM nurse WHERE id='" . $_GET['id'] . "' LIMIT 1";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            $position = $_GET['position'];
            $ic = $row['ic'];
            $email = $row['email'];
            $phone = $row['mobile'];
            $gender = $row['gender'];
            $address = $row['address'];
            $firstName = $row["firstName"];
            $lastName = $row["lastName"];
            $photo = $row['photo'];
            $isAdmin = $row['isAdmin'];
        }
    }
    ?>

    <div class="container-fluid navbar mb-5">
        <div class="col-12">
            <h1 class="text-center">Staff Detail</h1>
        </div>
    </div>


    <div class="container">
        <form action="./include/edit_staff_action.php" method="POST" enctype="multipart/form-data">
            <input type="text" id="id" name="id" value="<?= $_GET['id'] ?>" hidden>
            <div class="row g-4 mb-5 justify-content-center">
                <div class="col-lg-6 col-7 d-flex justify-content-center align-items-center mb-lg-0 mb-4">
                    <div class="text-center">
                        <?php
                        if ($photo != "")
                            echo "<img src=\"uploads/" . $row['photo'] . "\" alt=\"profile picture\" class=\"img-thumbnail mb-3\">";
                        else
                            echo '<img src="./image/anonymous.png" alt="profile picture" class="img-thumbnail mb-3" />';

                        ?>

                        <div class="text-center">
                            <small class="my-2 d-inline-block">Max size: 488.28KB</small><br>
                            <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="row g-4">

                        <div class="col-12 d-flex align-items-center justify-content-between">
                            <label for="firstName" class="me-3">First&nbsp;Name</label>

                            <input type="text" name="firstName" id="firstName" class="form-control w-100" value="<?php echo $firstName ?>" required>
                        </div>

                        <div class="col-12 d-flex align-items-center justify-content-between">
                            <label for="lastName" class="me-3">Last&nbsp;Name</label>
                            <input type="text" name="lastName" id="lastName" class="form-control" value="<?php echo $lastName ?>" required>
                        </div>

                        <div class="col-12 d-flex align-items-center justify-content-between">
                            <label for="ic" class="me-3">IC&nbsp;No</label>
                            <input type="text" name="ic" id="ic" class="form-control" value="<?php echo $ic ?>" required>
                        </div>

                        <div class="col-sm-6 d-flex align-items-center">
                            <label for="gender" class="me-3">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option selected>Open this select menu</option>
                                <option value="male" <?php echo $gender == 'male' ? "selected" : "" ?>>Male</option>
                                <option value="female" <?php echo $gender == 'female' ? "selected" : "" ?>>Female</option>
                            </select>
                        </div>

                        <div class="col-sm-6 d-flex align-items-center">
                            <label for="position" class="me-3">Position</label>
                            <select name="position" id="position" class="form-select">
                                <option selected>Open this select menu</option>
                                <option value="dentist" <?php echo $position == 'dentist' ? "selected" : "" ?>>Dentist</option>
                                <option value="nurse" <?php echo $position == 'nurse' ? "selected" : "" ?>>Nurse</option>
                            </select>
                        </div>


                        <div class="col-12 d-flex align-items-center justify-content-between">
                            <label for="email" class="me-3">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo $email ?>" required>
                        </div>

                        <div class="col-12 d-flex align-items-center justify-content-between">
                            <label for="phone" class="me-3">Phone&nbsp;Number</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $phone ?>" required>
                        </div>

                        <div class="col-12">
                            <label for="address" class="mb-3">Address</label>
                            <input type="text" name="address" id="address" class="form-control" value="<?php echo $address ?>" required>
                        </div>

                        <div class="col-12 d-flex align-items-center">
                            <label for="isAdmin" class="me-3">Admin</label>
                            <select name="isAdmin" id="isAdmin" class="form-select">
                                <option selected>Open this select menu</option>
                                <option value="0" <?php echo $isAdmin ? "" : "selected" ?>>No</option>
                                <option value="1" <?php echo $isAdmin ? "selected" : "" ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="col-12 text-center mb-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </form>

    <div class="col-12 text-center">
        <a href="./admin.php" class="btn btn-danger mb-3">Back</a>
        <?php
        // echo '<a href="staff_detail.php?id=' . $_GET['id'] . '&position=' . $_GET['position'] . '" class="btn btn-danger mb-3">Back</a>';

        ?>
    </div>
    </div>
</body>

</html>