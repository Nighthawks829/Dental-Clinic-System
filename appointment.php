<?php
session_start();
include("include/config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="style/appointment.css">
	
	<!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src="https://kit.fontawesome.com/3a4d23485c.js" crossorigin="anonymous"></script>

    <title>Book Appointment</title>
</head>

<body>
	
	<div class="container" style="padding:0 10px;" align="center">
		<h1 align="center">Book Appointment</h1>
		
		<form method="POST" action="appointment_action.php" enctype="multipart/form-data">
		
			<label for="appointment_patient_name">Patient Name:</label>
			<input type="text" name="appointment_patient_name" size="20" required>
			
			<label for="user_ic">Patient IC:</label>
			<input type="text" name="user_ic" size="20" required>
				
			<label for="appointment_date">Appointment Date:</label>
			<input type="date" id="appointment_date" name="appointment_date" required>
			
			<label for="appointment_time">Appointment Time:</label>
			<input type="time" id="appointment_time" name="appointment_time" required>
				
			<label for="dentist_id">Select Dentist:</label>
			<select id="dentist_id" name="dentist_id" required>
				
				<?php
					
				$query = "SELECT id, firstName, lastName FROM dentist";
				$result = mysqli_query($conn, $query);
					
				if($result) {
					while ($row = mysqli_fetch_assoc($result)) {
						//fetch all dentist name from table dentist
						echo "<option value='{$row['id']}'>{$row['firstName']} {$row['lastName']}</option>";
					}
					mysqli_free_result($result);
				} else {
					//when there is no dentist detail in dentist table
					echo "<option value=''>No Dentist Available</option>";
				}
			
				mysqli_close($conn);
				?>
			</select>
				
			<label for="appointment_reason">Appointment Reason:</label>
			<textarea rows="2" name="appointment_reason" colspan="6" required></textarea>
			
			<button type="submit">Book Appointment</button>
			
		</form>
	</div>
</body>
</html>