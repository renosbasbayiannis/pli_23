<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# Έλεγχος ότι ο χρήστης είναι συνδεδεμένος
$the_user_is_logged = isset($_SESSION['loggedin']) ? true : false;
if ($the_user_is_logged == true) {
	if ($_SESSION['loggedin'] == true) {
		# Αναλόγως του ρόλου του χρήστη
		if ($_SESSION['role'] == 'ΠΟΛΙΤΗΣ') {
			# ανακατεύθυνση στην Αρχική Σελίδα του Πολίτη
			echo '  <script language="javascript" type="text/javascript">
				if (!alert ("Είστε ήδη συνδεδεμένος")) {
					location.href = "../citizenHomepage.html";                
				}
				</script>';
		}
		else if ($_SESSION['role'] == 'ΓΙΑΤΡΟΣ') {
			# ανακατεύθυνση στην Αρχική Σελίδα του Γιατρού
			echo '  <script language="javascript" type="text/javascript">
				if (!alert ("Είστε ήδη συνδεδεμένος")) {
					location.href = "../doctorHomepage.html";                
				}
				</script>';
		}
		else {
			echo '  <script language="javascript" type="text/javascript">
				if (!alert ("Είστε ήδη συνδεδεμένος")) {
					location.href = "../login.html";                
				}
				</script>';
		}
		exit;
	}
}

require 'connectDB.php';

# λήψη των πεδίων της φόρμας
$amka = $_POST['amka'];
$afm = $_POST['afm'];

# Έλεγχος ύπαρξης του χρήστη βάσει των ΑΦΜ, ΑΜΚΑ που εισήγαγε
$sql="SELECT user_id, role, name, surname, amka, afm, adt, age, email, mobile FROM user 
	WHERE amka = '$amka' AND afm = '$afm'";

$result = $mysqli->query($sql);
if ($result->num_rows == 0) {
	echo '  <script language="javascript" type="text/javascript">
			if (!alert ("Σφάλμα! Δεν είστε εγγεγραμμένος χρήστης")) {
                history.go (-1);
			}
			</script>';
}
else if ($result->num_rows == 1){
	# ο Χρήστης υπάρχει
	$row = $result->fetch_assoc();
	# Αρχικοποίηση των μεταβλητών της συνεδρίας
	$_SESSION['loggedin'] = true; # Αυτή η μεταβλητή δηλώνει ότι ο χρήστης είναι συνδεδεμένος
	$_SESSION['user_id'] = $row['user_id'];
	$_SESSION['name'] = $row['name'];
	$_SESSION['surname'] = $row['surname'];
	$_SESSION['amka'] = $row['amka'];
	$_SESSION['afm'] = $row['afm'];
	$_SESSION['adt'] = $row['adt'];
	$_SESSION['age'] = $row['age'];
	# Αν δεν έχει εισαχθεί email, για την αποφυγή εμφάνισης "null"
	# σε μετέπειτα ανάκτηση του email σε φόρμα του χρήστη
	if (empty($row['email']))
		$_SESSION['email'] = "";
	else 
		$_SESSION['email'] = $row['email'];
	$_SESSION['mobile'] = $row['mobile'];
	$_SESSION['role'] = $row['role'];
	
	# Αναλόγως του ρόλου του χρήστη
	if ($_SESSION['role'] == "ΠΟΛΙΤΗΣ") {
		# ανακατεύθυνση στην Αρχική Σελίδα του Πολίτη
		echo '  <script language="javascript" type="text/javascript">
				if (!alert ("Επιτυχής σύνδεση")) {		
					location.href = "../citizenHomepage.html";
				}
			</script>';
	}
	else {
		# ανακατεύθυνση στην Αρχική Σελίδα του Γιατρού
		echo '  <script language="javascript" type="text/javascript">
				if (!alert ("Επιτυχής σύνδεση")) {
					location.href = "../doctorHomepage.html";
				}
				</script>';
	}
}
else { // λάθος: Ενώ υπάρχει ο χρήστης, δεν επιστράφηκαν στοιχεία
	echo "Πρόβλημα στο λογαριασμό."."<br>";
	echo '  <script language="javascript" type="text/javascript">
			if (!alert ("Σφάλμα! Πρόβλημα στο λογαριασμό.")) {
                history.go (-1);
			}
			</script>';
}


$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>