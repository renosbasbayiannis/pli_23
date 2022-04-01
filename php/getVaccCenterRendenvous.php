<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# Έλεγχος ότι ο χρήστης είναι συνδεδεμένος
$the_user_is_logged = isset($_SESSION['loggedin']) ? true : false;
if ($the_user_is_logged == false) {
	exit;
}

require 'connectDB.php';

# ανάκτηση στοιχείων φόρμας
$center_name = $_GET['center_name'];

# Η απάντηση με τα ραντεβού είναι ένας πίνακας
$rendezvous_array = array();
$idx = 0;
# Επιλογή center id βάσει ονόματος
$sql="SELECT center_id, name FROM center 
WHERE name = '$center_name'";
	
$result = $mysqli->query($sql);
if ($result->num_rows != 0) {
	$row = $result->fetch_assoc();
	$center_id = $row['center_id'];
	# Ενημέρωση μεταβλητών συνεδρίας
	$_SESSION['rendezvous_reservation_at_center_id'] = $center_id;
}
$result->close();

# Επιλογή στοιχείων ραντεβού του εμβολιαστικού κέντρου
$sql="SELECT center_id, rendezvous_date, rendezvous_time, status 
FROM rendezvous 
WHERE center_id = '$center_id'";
$rendezvous_result = $mysqli->query($sql);
if ($rendezvous_result->num_rows != 0) {
	# Για κάθε διαφορερικό ραντεβού (ημέρα, ώρα)
	while ($row = $rendezvous_result->fetch_assoc()) {
		# Εισαγωγή νέας γραμμής στον πίνακα με στοιχεία ραντεβού
		$rendezvous_array[$idx] = array($row['rendezvous_date'],
									    $row['rendezvous_time'],
										$row['status']);
		$idx++;
	}
}

# Μετατροπή των στοιχείων ραντεβού σε JSON 
$json_obj = json_encode($rendezvous_array);
# Επιστροφή JSON στοιχείων ραντεβού
echo $json_obj;

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>