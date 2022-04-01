<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# ανάκτηση των στοιχείων της φόρμας
$date = $_GET['date'];
$time = $_GET['time'];
$status = $_GET['status'];

# ανάκτηση μεταβλητών της συνεδρίας
$user_id = $_SESSION['user_id'];
$center_id = $_SESSION['doctor_center_id'];


require 'connectDB.php';

# Εύρεση του συγκεκριμένου ραντεβού
$sql="SELECT user_id, rendezvous_id, center_id, rendezvous_date, rendezvous_time, status FROM rendezvous
WHERE rendezvous_date = '$date' AND rendezvous_time = '$time' 
AND center_id = '$center_id'";

$result = $mysqli->query($sql);
if ($result->num_rows != 0) {
	$row = $result->fetch_assoc();
	#κρατάμε το id του ραντεβού
	$rendezvous_id = $row['rendezvous_id'];
}
else {
	# ανακατεύθυνση στην Αρχική Σελίδα του Γιατρού 
	echo '  <script language="javascript" type="text/javascript">
		if (!alert ("Το ραντεβού δεν βρέθηκε")) {
			location.href = "../doctorRendezvous.html";
		}
		</script>';
}
$result->close();

# Αναλόγως της τελικής κατάστασης του ραντεβού
if ($status == 'cancelled') {
	$sql="UPDATE rendezvous
		SET status='ελεύθερο', user_id = NULL
	WHERE rendezvous_id = '$rendezvous_id'";
	
	if ($mysqli->query($sql) == true) {
		echo '  <script language="javascript" type="text/javascript">
			if (!alert ("To ραντεβού ακυρώθηκε")) {
				location.href = "../doctorRendezvous.html";
			}
			</script>';
	}
	else {
		echo '  <script language="javascript" type="text/javascript">
			if (!alert ("Μήνυμα λάθους: To ραντεβού δεν ακυρώθηκε")) {
				location.href = "../doctorRendezvous.html";
			}
			</script>';
	}
}
else if ($status == 'completed') {
	$sql="UPDATE rendezvous
		SET status='ολοκληρωμένο'
	WHERE rendezvous_id = '$rendezvous_id'";
	
	if ($mysqli->query($sql) == true) {
		echo '  <script language="javascript" type="text/javascript">
			if (!alert ("To ραντεβού ολοκληρώθηκε")) {
				location.href = "../doctorRendezvous.html";
			}
			</script>';
	}
	else {
		echo '  <script language="javascript" type="text/javascript">
			if (!alert ("Μήνυμα λάθους: To ραντεβού δεν ολοκληρώθηκε")) {
				location.href = "../doctorRendezvous.html";
			}
			</script>';
	}
}

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>
