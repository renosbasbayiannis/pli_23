<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# Έλεγχος ότι ο χρήστης είναι συνδεδεμένος
$the_user_is_logged = isset($_SESSION['loggedin']) ? true : false;
if ($the_user_is_logged == false) {
	exit;
}

# ανάκτηση των μεταβλητών συνεδρίας
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$amka = $_SESSION['amka'];
$afm = $_SESSION['afm'];
$adt = $_SESSION['adt'];
$age = $_SESSION['age'];
$email = $_SESSION['email'];
$mobile = $_SESSION['mobile'];
$role = $_SESSION['role'];

require 'connectDB.php';

# Δημιουργία html κειμένου απάντησης με στοιχεία χρήστη
echo "<p>Όνομα: " . $name . "</p>";
echo "<p>Επώνυμο: " . $surname . "</p>";
echo "<p>Α.Μ.Κ.Α.: " . $amka . "</p>";
echo "<p>Α.Φ.Μ.: " . $afm . "</p>";
echo "<p>Α.Δ.Τ.: " . $adt . "</p>";
echo "<p>ΗΛΙΚΙΑ: " . $age . "</p>";
echo "<p>email: " . $email . "</p>";
echo "<p>Κινητό: " . $mobile . "</p>";

if ($role == 'ΓΙΑΤΡΟΣ') {
	# Επιλογή κέντρου στο οποίο έχει δηλωθεί ο γιατρός
	$sql="SELECT doctor_id, center_id FROM center_doctor
	WHERE doctor_id = '$user_id'";

	$result = $mysqli->query($sql);
	if ($result->num_rows != 0) {
		$row = $result->fetch_assoc();
		$center_id = $row['center_id'];
		$result->close();
		
		#Λήψη του ονόματος του εμβολιαστικού κέντρου
		$center_sql="SELECT name FROM center
		WHERE center_id = '$center_id'";
		
		$center_result = $mysqli->query($center_sql);
		if ($center_result->num_rows != 0) {
			$center_row = $center_result->fetch_row();
			$center_name = $center_row[0];
		}
		else
			$center_name = "";
		
		# Δημιουργία html κειμένου απάντησης με στοιχεία εμβολιαστικού κέντρου
		echo '<p> Εμβολιαστικό Κέντρο: '.$center_name.'</p>';
	}
	else {
		# Ο γιατρός δεν έχει δηλώσει εμβολιαστικό κέντρο
		# Δημιουργία html κειμένου απάντησης με στοιχεία εμβολιαστικού κέντρου
		echo '<p> Εμβολιαστικό Κέντρο: Δεν έχει δηλωθεί </p>';
	}
}
else if ($role == 'ΠΟΛΙΤΗΣ') {
	# Φάκελος με τα QR code
	$folder="../qr_codes/";
	# Όνομα αρχείου με διακριτικό το ΑΦΜ
	$file_name="qr"."_".$afm.".png";
	# Πλήρες όνομα αρχείου
	$file_name=$folder.$file_name;
	# Διαγραφή του QR αρχείου αν υπάρχει
	if (file_exists($file_name)) {
		unlink($file_name);
	}
}

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>
