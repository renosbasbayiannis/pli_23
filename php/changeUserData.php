<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# λήψη των πεδίων της φόρμας
$identity = $_POST['identity'];
$age = $_POST['age'];
$email = $_POST['email'];
$cellphone = $_POST['cellphone'];

# ανάκτηση μεταβλητών της συνεδρίας
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

require 'connectDB.php';

# Ενημέρωση του στοιχείων του χρήστη με user_id
$sql="UPDATE user
		SET adt = '$identity', 
			age = '$age',
			email = '$email',
			mobile = '$cellphone'
WHERE user_id = '$user_id'";

if ($mysqli->query($sql) == true) {
	$sql="SELECT user_id, role, adt, age, email, mobile FROM user 
	WHERE user_id = '$user_id'";

	$result = $mysqli->query($sql);
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		# Οι αρχικές σελίδες χρήστη και λογαριασμού του
		# εμφανίζουν τις τιμές των μεταβλητών συνεδρίας
		# Οπότε: 
		# ανανέωση τιμών του SESSION που άλλαξαν
		$_SESSION['adt'] = $row['adt'];
		$_SESSION['age'] = $row['age'];
		# Αν δεν έχει εισαχθεί email, για την αποφυγή εμφάνισης "null"
		# σε μετέπειτα ανάκτηση του email σε φόρμα του χρήστη
		if (empty($row['email']))
			$_SESSION['email'] = "";
		else
			$_SESSION['email'] = $row['email'];
		$_SESSION['mobile'] = $row['mobile'];
	}
	else {
		require 'logout.php';
	}
	$result->close();
	
	# ανακατεύθυνση στη σωστή σελίδα λογαριασμού του χρήστη αναλόγως ρόλου
	if ($role == 'ΠΟΛΙΤΗΣ') {
		echo '  <script language="javascript" type="text/javascript">
		if (!alert ("Τα στοιχεία χρήστη ενημερώθηκαν")) {
			location.href = "../citizenAccount.html";
		}
		</script>';
	}
	else {
		echo '  <script language="javascript" type="text/javascript">
		if (!alert ("Τα στοιχεία χρήστη ενημερώθηκαν")) {
			location.href = "../doctorAccount.html";
		}
		</script>';
	}
}
else {
	# αποτυχία ενημέρωσης
	# ανακατεύθυνση στη σωστή σελίδα λογαριασμού του χρήστη αναλόγως ρόλου
	if ($role == 'ΠΟΛΙΤΗΣ') {
		echo '  <script language="javascript" type="text/javascript">
		if (!alert ("Μήνυμα λάθους: Τα στοιχεία χρήστη δεν ενημερώθηκαν")) {
			location.href = "../citizenAccount.html";
		}
		</script>';
	}
	else {
		echo '  <script language="javascript" type="text/javascript">
		if (!alert ("Μήνυμα λάθους: Τα στοιχεία χρήστη δεν ενημερώθηκαν")) {
			location.href = "../doctorAccount.html";
		}
		</script>';
	}
}

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>
