<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# ανάκτηση μεταβλητών της συνεδρίας
$user_id = $_SESSION['user_id'];

require 'connectDB.php';

# Εύρεση αν ο γιατρός έχει δηλώσει center id
$sql="SELECT doctor_id, center_id FROM center_doctor
WHERE doctor_id = '$user_id'";

$result = $mysqli->query($sql);
if ($result->num_rows == 0) {
	# Δεν έχει δηλώσει εμβολιαστικό κέντρο. 
	# Δεν μπορεί να δει ραντεβού
	echo "";
}
else {
	# Έχει δηλώσει εμβολιαστικό κέντρο. 
	$row = $result->fetch_assoc();
	$center_id = $row['center_id'];
	# ενημέρωση μεταβλητών συνεδρίας
	$_SESSION['doctor_center_id'] = $center_id;
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
	$center_result->close();
		
	# Η απάντηση με τα ραντεβού είναι ένας πίνακας
	$rendezvous_array = array();
	$idx = 0;
	
	# Επιλογή στοιχείων ραντεβού για το εμβολιαστικό κέντρο
	$sql="SELECT rendezvous_id, center_id, user_id, rendezvous_date, rendezvous_time, status 
	FROM rendezvous 
	WHERE center_id = '$center_id'";
	$rendezvous_result = $mysqli->query($sql);
	if ($rendezvous_result->num_rows != 0) {
		# Υπάρχουν στοιχεία ραντεβού
		# Για κάθε διαφορερικό ραντεβού (ημέρα, ώρα)
		while ($row = $rendezvous_result->fetch_assoc()) {
			$citizen_id = $row['user_id'];
			
			# αρχικοποίηση στοιχείων πολίτη
			$citizen_name = '';
			$citizen_surname = '';
			$citizen_amka = '';
			# Εύρεση στοιχείων πολίτη που είχε επιλέξει το ραντεβού
			$citizen_sql="SELECT user_id, name, surname, amka 
				FROM user 
				WHERE user_id = '$citizen_id'";
			$citizen_result = $mysqli->query($citizen_sql);
			if ($citizen_result->num_rows != 0) {
				# Το ραντεβού είχε επιλεγεί από πολίτη
				$citizen_row = $citizen_result->fetch_assoc();
				$citizen_name = $citizen_row['name'];
				$citizen_surname = $citizen_row['surname'];
				$citizen_amka = $citizen_row['amka'];
			}
			# else - Το ραντεβού δεν είχε επιλεγεί από πολίτη
			# Χρήση των αρχικοποιημένων στοιχείων πολίτη
			
			# Εισαγωγή νέας γραμμής στον πίνακα με στοιχεία ραντεβού
			$rendezvous_array[$idx] = array($row['rendezvous_date'],
											$row['rendezvous_time'],
											$row['status'],
											$citizen_name,
											$citizen_surname,
											$citizen_amka);
			$idx++;
		}
		# Μετατροπή των στοιχείων ραντεβού σε JSON 
		$json_obj = json_encode($rendezvous_array);
	}
	else {
		$json_obj = "";
	}
	# Επιστροφή JSON στοιχείων ραντεβού
	echo $json_obj;
	
}

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>