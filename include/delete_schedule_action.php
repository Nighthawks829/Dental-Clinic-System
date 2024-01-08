<?PHP
include('config.php');
//this action is called when the Delete link is clicked
if (isset($_GET["id"]) && $_GET["id"] != "") {
    $id = $_GET["id"];
    $sqlAppointment = "DELETE FROM appointment WHERE appointment_id=" . $id;
    $sqlSchedule = "DELETE FROM schedule WHERE id=" . $id;

    if (mysqli_query($conn, $sqlAppointment) && mysqli_query($conn, $sqlSchedule)) {
        $message = "Record deleted successfully<br>";
        include("./delete_schedule_message.php");
    } else {
        $message = "Error deleting record: " . mysqli_error($conn) . "<br>";
        include("./delete_schedule_message.php");
    }
}
mysqli_close($conn);
