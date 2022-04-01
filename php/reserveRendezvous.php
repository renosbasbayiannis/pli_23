<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# λήψη των πεδίων από τη url
$date = $_GET['date'];
$time = $_GET['time'];

# ανάκτηση μεταβλητών της συνεδρίας
$user_id = $_SESSION['user_id'];
$center_id = $_SESSION['rendezvous_reservation_at_center_id'];

require 'connectDB.php';

# έλεγχος αν υπάρχει ήδη ραντεβού για αυτό το χρήστη
# Τα ελεύθερα ραντεβού δεν έχουν χρήστη
$sql="SELECT user_id, status FROM rendezvous
WHERE  user_id = '$user_id'";

$result = $mysqli->query($sql);
if ($result->num_rows != 0) {
	# έλεγχος σε όλα τα πιθανά ραντεβού του χρήστη
	while($row = $result->fetch_assoc()) {
		$status = $row['status'];
		if ($status == 'προγραμματισμένο') {
			echo '  <script language="javascript" type="text/javascript">
			if (!alert ("Έχετε ήδη ραντεβού")) {
				location.href = "../citizenHomepage.html";
			}
			</script>';
		}
		else if ($status == 'ολοκληρωμένο') {
			echo '  <script language="javascript" type="text/javascript">
			if (!alert ("Έχετε ολοκληρώσει τον εμβολιασμό")) {
				location.href = "../citizenHomepage.html";
			}
			</script>';
		}
	}
	echo '  <script language="javascript" type="text/javascript">
		if (!alert ("Έχετε ήδη ραντεβού")) {
			location.href = "../citizenHomepage.html";
		}
		</script>';
	exit;
}
$result->close();


# Ανάκτηση του επιλεγμένου ραντεβού
$sql="SELECT user_id, rendezvous_id, center_id, rendezvous_date, rendezvous_time, status FROM rendezvous
WHERE rendezvous_date = '$date' AND rendezvous_time = '$time' 
AND center_id = '$center_id' AND status = 'ελεύθερο'";

$result = $mysqli->query($sql);
if ($result->num_rows != 0) {
	$row = $result->fetch_assoc();
	$rendezvous_id = $row['rendezvous_id'];
}
else {
	echo '  <script language="javascript" type="text/javascript">
		if (!alert ("Η κράτηση του ραντεβού απέτυχε")) {
			location.href = "../citizenHomepage.html";
		}
		</script>';
}



$sql="UPDATE rendezvous
		SET user_id='$user_id',
		status='προγραμματισμένο'
	WHERE rendezvous_id = '$rendezvous_id'";

if ($mysqli->query($sql) == true) {
	echo '  <script language="javascript" type="text/javascript">
		if (!alert ("Η κράτηση του ραντεβού ήταν επιτυχής")) {
			location.href = "../citizenHomepage.html";
		}
		</script>';
}
else {
	echo '  <script language="javascript" type="text/javascript">
		if (!alert ("Μήνυμα λάθους: Η κράτηση του ραντεβού απέτυχε")) {
			location.href = "../citizenRendenvous.html";
		}
		</script>';
}



$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>
