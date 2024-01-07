<?php
    //session_start();
    include('include/config.php');
    //$loggedInUserId = $_SESSION['patient_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="style/style.css">
  <link rel="stylesheet" href="style/review.css">

  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <script src="https://kit.fontawesome.com/3a4d23485c.js" crossorigin="anonymous"></script>

  <title>Reviews</title>
</head>
<body>

  <div class="container-fluid navbar mb-5">
    <div class="col-12">
        <h1 class="text-center">Reviews</h1>
    </div>
  </div>

  <section class="review" id="review">
  <div class="container">
  <?php
  $sql = "SELECT review_id, first_name, last_name, rating, comments, date FROM review";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo 
        '<div class="mb-4">
            <div class="card">';
            //if ($loggedInUserId == $row['patient_id']) {
                echo '<div class="mt-4">
                        <a class="btn btn-primary" style=margin-left:14px; href="edit_review.php?id=' . $row['review_id'] . '">Edit</a> 
                        <a class="btn btn-primary" href="include/delete_review_action.php?id=' . $row['review_id'] . '">Delete</a>
                    </div>';
            // }
                      echo'<div class="card-body">
                          <div class="text-end mb-2">';
          // Assuming your "rating" column contains the number of stars
          for ($i = 1; $i <= $row['rating']; $i++) {
              echo '<i class="fa-solid fa-star"></i>';
          }
          echo '</div>
                  <p class="review-text">' . $row['comments'] . '</p>
                </div>
              <div class="card-footer">
                  <div class="col-12 d-flex align-items-center">
                      <div></div>
                      <div>
                          <p class="mb-0 name">' . $row['first_name'] . ' ' . $row['last_name'] . '</p>
                          <p class="mb-0 patient">Patient</p>
                          <p class="mb-0 date">' . $row['date'] . '</p>
                      </div>
                </div>
              </div>';

            echo '</div>
            </div>';
      }
  } else {
      echo "0 results";
  }
  
  $conn->close();
  ?>
  </div>

  <div class="container">
    <a class="btn btn-primary" href="index.html">Back</a>
  </div>
</section>
  
</body>
</html>