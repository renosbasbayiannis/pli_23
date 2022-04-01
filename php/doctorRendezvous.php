<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# ανάκτηση στοιχείων συνεδρίας
$user_id = $_SESSION['user_id'];

require 'connectDB.php';

# επιλογή του κέντρου που έχει δηλώσει ο γιατρός
$sql="SELECT doctor_id, center_id FROM center_doctor
WHERE doctor_id = '$user_id'";

$result = $mysqli->query($sql);
if ($result->num_rows == 0) {
	# Ο γιατρός δεν έχει δηλώσει εμβολιαστικό κέντρο
	# ανακατεύθυνση στην αρχική σελίδα του γιατρού
	echo '<p> Εμβολιαστικό Κέντρο:  </p>';
	echo '  <script language="javascript" type="text/javascript">
		alert("Δεν έχει δηλωθεί Εμβολιαστικό Κέντρο");
		location.href = "../doctorHomepage.html";
		</script>';
}
else {
	# Ο γιατρός έχει δηλώσει εμβολιαστικό κέντρο
	# ανακατεύθυνση στην σελίδα των ραντεβού
	echo '  <script language="javascript" type="text/javascript">
		location.href = "../doctorRendezvous.html";
		</script>';
}

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>