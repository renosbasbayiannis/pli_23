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

# Η απάντηση με τα κέντρα είναι ένας πίνακας
$centers_array = array();
# Επιλογή όλων των κέντρων
$center_sql="SELECT center_id, name FROM center";
			
$center_result = $mysqli->query($center_sql);
if ($center_result->num_rows != 0) {
	$index = 0;
	# Για κάθε κέντρο
	while ($row = $center_result->fetch_assoc()) {
		$center_id = $row['center_id'];
		
		# Εισαγωγή νέας γραμμής στον πίνακα με τα κέντρα
		$centers_array[$index] = $row['name'];
		$index ++;
	}
}
# Μετατροπή των στοιχείων ραντεβού σε JSON 
$json_obj = json_encode($centers_array);
# Επιστροφή JSON στοιχείων ραντεβού
echo $json_obj;


$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>
