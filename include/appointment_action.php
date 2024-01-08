<?php
session_start();
include('include/config.php');

//this bloock is called when button submit is clicked
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$appointment_patient_name = $_POST['appointment_patient_name'];
	$user_ic = $_POST['user_ic'];
	$dentist_id = $_POST['dentist_id'];
	$appointment_date = $_POST['appointment_date'];
	$appointment_time = $_POST['appointment_time'];
	$appointment_reason = $_POST['appointment_reason'];
	$appointment_status = 'Pending';

	//check if user with provided ic exists
	$sqlUser = "SELECT id FROM user WHERE ic = '$user_ic'";
	$resultUser = $conn->query($sqlUser);
	
	if($resultUser->num_rows > 0) {
		$user = $resultUser->fetch_assoc();
		$user_id = $user["id"];
		
		
		$sqlAppointment = "INSERT INTO appointment (appointment_patient_name, user_ic, dentist_id, appointment_date, appointment_time, appointment_reason, appointment_status) VALUES ('$appointment_patient_name', '$user_ic', '$dentist_id', '$appointment_date', '$appointment_time', '$appointment_reason', '$appointment_status')";
		
		if($conn->query($sqlAppointment) === TRUE) {
			$message = "Appointment booked successfully!<br>";
			include("include/appointment_message.php");
			
			//retrieve the dentist_id associated with the selected dentist
			$sqlDentist = "SELECT id FROM dentist WHERE id = '$dentist_id'";
			$resultDentist = $conn->query($sqlDentist);
			
			if($resultDentist->num_rows > 0) {
				$dentist = $resultDentist->fetch_assoc();
				$dentist_id = $dentist["id"];
				
				//insert schedule details into schedule table
				$update_date = new DateTime("now", new DateTimeZone("Asia/Kuala_Lumpur"));
				$update_date_str = $update_date->format('Y-m-d H:i:s');
				
				$sqlSchedule = "INSERT INTO schedule (dentistID, date, time_from, update_date) VALUES ('$dentist_id', '$appointment_date', '$appointment_time', '$update_date_str')";
				
				if($conn->query($sqlSchedule) === TRUE) {
					echo "Schedule updated successfully!<br>";
					
				} else {
					$message = "Error updating schedule: " . $conn->error;
					include("include/appointment_message.php");
				}
			}
		} else {
			echo "Error: " . $sqlAppointment . "<br>" . $conn->error;
		}
	} else {
		echo "User not found. Please register first.";
	}
}

mysqli_close($conn);
?>