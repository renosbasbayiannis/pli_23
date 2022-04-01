<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

require 'connectDB.php';

# ανάκτηση στοιχείων συνεδρίας
$user_id = $_SESSION['user_id'];

# Επιλογή ρόλου του χρήστη (χρήση για ανακατεύθυνση στη σελίδα επιστροφής)
$sql="SELECT user_id, role FROM user 
	WHERE user_id = '$user_id'";

$result = $mysqli->query($sql);
if ($result->num_rows != 0) {
	$row = $result->fetch_assoc();
	$result->close();
	
	# Διαγραφή χρήστη. Η δήλωσή του στον πίνακα center_doctor διαγράφεται
	# αυτόματα με τον περιορισμό ON DELETE CASCADE του ξένου κλειδιού του 
	# γιατρού 
	$sql="DELETE FROM user
	WHERE user_id = '$user_id'";
			
	if ($mysqli->query($sql) == TRUE) {
		echo '  <script language="javascript" type="text/javascript">
			alert("Ο χρήστης διαγράφηκε");
			</script>';
		require 'logout.php';
	}
	else {
		echo '  <script language="javascript" type="text/javascript">
			alert("Σφάλμα! Ο χρήστης δεν διαγράφηκε");
			</script>';
		# ανακατεύθυνση στην αρχική σελίδα χρήστη βάσει ρόλου
		if ($_SESSION['role'] == 'ΠΟΛΙΤΗΣ')
			header("Location: ../citizenHomepage.html");
		else
			header("Location: ../doctorHomepage.html");
	}
}
else {
	echo '  <script language="javascript" type="text/javascript">
		alert("Σφάλμα!");
		</script>';
	# ανακατεύθυνση στην αρχική σελίδα χρήστη βάσει ρόλου
	if ($_SESSION['role'] == 'ΠΟΛΙΤΗΣ')
		header("Location: ../citizenHomepage.html");
	else
		header("Location: ../doctorHomepage.html");
}


$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>