<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# ανάκτηση μεταβλητών της συνεδρίας
$user_id = $_SESSION['user_id'];

require 'connectDB.php';

# Ενημέρωση του ραντεβού (κατάσταση και user id)
# Υπάρχει δυνατότητα μόνο για ένα προγραμματισμένο ραντεβού 
# για κάθε χρήστη
$sql="UPDATE rendezvous
		SET status='ελεύθερο', user_id = NULL
	WHERE user_id = '$user_id' AND status = 'προγραμματισμένο'";

# Ανακατεύθυνση στην Αρχική Σελίδα του Πολίτη
if ($mysqli->query($sql) == TRUE) {
	echo '  <script language="javascript" type="text/javascript">
		alert("Το ραντεβού ακυρώθηκε");
		location = \'../citizenHomepage.html\';
		</script>';
}
else {
	echo '  <script language="javascript" type="text/javascript">
		alert("Σφάλμα! Το ραντεβού δεν ακυρώθηκε");
		location = \'../citizenHomepage.html\';
		</script>';
}

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>