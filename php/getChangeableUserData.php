<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# Έλεγχος ότι ο χρήστης είναι συνδεδεμένος
$the_user_is_logged = isset($_SESSION['loggedin']) ? true : false;
if ($the_user_is_logged == false) {
	exit;
}

# ανάκτηση μεταβλητών της συνεδρίας
$user_id = $_SESSION['user_id'];

require 'connectDB.php';

$user_data_array = array();
$idx = 0;

$sql="SELECT user_id, role, adt, age, email, mobile FROM user 
	WHERE user_id = '$user_id'";

$result = $mysqli->query($sql);
if ($result->num_rows == 0) {
	echo '  <script language="javascript" type="text/javascript">
			if (!alert ("Σφάλμα κατά την ανάκτηση των στοιχείων")) {
                history.go (-1);
			}
			</script>';
}
else if ($result->num_rows == 1){
	$row = $result->fetch_assoc();
	if (empty($row['email']))
		$email = '';
	else
		$email = $row['email']; 
	
	$rendezvous_array[$idx] = array($row['adt'],
									$row['age'],
									$email,
									$row['mobile']);

	$json_obj = json_encode($rendezvous_array);
	echo $json_obj;	
}

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>
