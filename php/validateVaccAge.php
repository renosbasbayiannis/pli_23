<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# Έλεγχος ότι ο χρήστης είναι συνδεδεμένος
$the_user_is_logged = isset($_SESSION['loggedin']) ? true : false;
if ($the_user_is_logged == false) {
	exit;
}

# ανάκτηση στοιχείων συνεδρίας
$age = $_SESSION['age'];

if ((40 <= $age) && ($age <= 65)) {
	# Αν ο χρήστης ανακατευθύνεται στη σελίδα των ραντεβού
	echo '  <script language="javascript" type="text/javascript">
		alert("Ανήκετε στην ηλικιακή ομάδα εμβολιασμού τη συγκεκριμένη περίοδο");
		location.href = "../citizenRendezvous.html";
		</script>';
}
else {
	# Αν ο χρήστης ανακατευθύνεται στην αρχική σελίδα του
	echo '  <script language="javascript" type="text/javascript">
		alert("Δεν ανήκετε στην ηλικιακή ομάδα εμβολιασμού τη συγκεκριμένη περίοδο");
		location.href = "../citizenHomepage.html";
		</script>';
}

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>