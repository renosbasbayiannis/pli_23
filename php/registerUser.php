<?php
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

require 'connectDB.php';

# λήψη των πεδίων της φόρμας
$role = $_POST['role'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$amka = $_POST['amka'];
$afm = $_POST['afm'];
$identity = $_POST['identity'];
$age = $_POST['age'];
$sex = $_POST['sex'];
$email = $_POST['email'];
$cellphone = $_POST['cellphone'];

# Έλεγχος ότι δεν υπάρχει χρήστης με το ίδιο ΑΦΜ
# για μήνυμα λάθους στα ελληνικά
# Το ΑΦΜ είναι UNIQUE στον πίνακα των χρηστών
$sql="SELECT afm from user
WHERE afm = '$afm'";
$result = $mysqli->query($sql);
if ($result->num_rows == 1) {
	echo '  <script language="javascript" type="text/javascript">
			if (!alert ("Σφάλμα! Η εγγραφή δεν πραγματοποιήθηκε: Ο χρήστης με αυτό το ΑΦΜ υπάρχει.")) {
				location.href = "../login.html";
			}
			</script>';	
}
$result->close();

# Εισαγωγή του νέου χρήστη στη ΒΔ
$sql="INSERT INTO user (role, name, surname, amka, afm, adt, age, sex, email, mobile)
VALUES
('$role','$name','$surname','$amka','$afm','$identity','$age','$sex','$email','$cellphone')";

if ($mysqli->query($sql) == TRUE) {
	echo '  <script language="javascript" type="text/javascript">
			if (!alert ("Συγχαρητήρια! Η εγγραφή πραγματοποιήθηκε. Μπορείτε πλέον να συνδεθείτε.")) {
				location.href = "../login.html";
			}
			</script>';
}
else {
	echo "Αποτυχία εγγραφής. ".$mysqli->error;
	echo '  <script language="javascript" type="text/javascript">
			if (!alert ("Σφάλμα! Η εγγραφή δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
                history.go (-1);
			}
			</script>';
}


$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>