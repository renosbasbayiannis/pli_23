<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# Έλεγχος ότι ο χρήστης είναι συνδεδεμένος
# και επιστροφή αντίστοιχης απάντησης
$the_user_is_logged = isset($_SESSION['loggedin']) ? true : false;
if ($the_user_is_logged == false) {
	echo 'no_session';
}
else {
	echo 'active_session'; 
}

?>