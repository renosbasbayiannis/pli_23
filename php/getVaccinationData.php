<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# ανάκτηση σελίδας εμβολιασμού. Έχει δηλωθεί ως παράμετρος στη σελίδα php
$dest_page = $_GET['dest_page'];

# Έλεγχος ότι ο χρήστης είναι συνδεδεμένος
$the_user_is_logged = isset($_SESSION['loggedin']) ? true : false;
if ($the_user_is_logged == false) {
	exit;
}

# ανάκτηση στοιχείων συνεδρίας
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
  	  
# Ανάκτηση στοιχείων ραντεβού που δεν είναι ελεύθερα,
# (άρα προγραμματισμένα ή ολοκληρωμένα)
# και τα είχε δηλώσει ο χρήστης
$sql="SELECT user_id, rendezvous_id, center_id, rendezvous_date, rendezvous_time, status FROM rendezvous
WHERE user_id = '$user_id' AND status != 'ελεύθερο'";

$result = $mysqli->query($sql);
if ($result->num_rows != 0) {
	# Δημιουργία επικεφαλίδας πίνακα στοιχείων ραντεβού
	if ($dest_page == 'home_page') {
		echo '<table>
		  <tr style="padding:10px;">
			<th style="padding:10px;">Εμβολιαστικό κέντρο</th>
			<th style="padding:10px;">Ημερομηνία</th>
			<th style="padding:10px;">Ώρα</th>
			<th style="padding:10px;">Ενέργεια</th>
		  <tr>';
	}
	else {
		echo '<table>
		  <tr style="padding:10px;">
			<th style="padding:10px;">Εμβολιαστικό κέντρο</th>
			<th style="padding:10px;">Ημερομηνία</th>
			<th style="padding:10px;">Ώρα</th>
			<th style="padding:10px;">Κατάσταση</th>
		  <tr>';
	}
	
	# Για κάθε ραντεβού που είχε δηλώσει ο χρήστης
	# Σε ένα περιβάλλον πολλών εμβολιαστικών περιόδων
	# θα είχε περισσότερες από μια γραμμές ραντεβού
	while ($row = $result->fetch_assoc()) {
		#Λήψη του ονόματος του εμβολιαστικού κέντρου
		$center_id = $row['center_id'];
		$center_sql="SELECT name FROM center
		WHERE center_id = '$center_id'";
		
		$center_result = $mysqli->query($center_sql);
		if ($center_result->num_rows != 0) {
			$center_row = $center_result->fetch_row();
			$center_name = $center_row[0];
		}
		else
			$center_name = "";
		# ενημέρωση μεταβλητών συνεδρίας
		$_SESSION['center_name'] = $center_name;
		
		# Προσθήκη γραμμής πίνακα στοιχείων ραντεβού
		echo '<tr>';
		echo '<td style="padding:10px;">';
		echo $center_name;
		echo '</td>';
		echo '<td style="padding:10px;">';
		echo $row['rendezvous_date'];
		echo '</td>';
		echo '<td style="padding:10px;">';
		echo $row['rendezvous_time'];
		echo '</td>';
		
		# αναλόγως της κατάστασης του ραντεβού
		if ( $row['status'] == "προγραμματισμένο" ) {
			# Αν είναι προγραμματισμένο, προσθήκη κουμπιού ακύρωσης στην αρχική σελίδα χρήστη
			echo '<td style="padding:10px;">';
			if ($dest_page == 'home_page')
				echo '<button class="any-button" onclick="location=\'php/confirmCancelRendenvous.php\'"> Ακυρώστε το ραντεβού σας</button>';
			else
				echo $row['status'];
		}
		else if ( $row['status'] == "ολοκληρωμένο" ) {
			# Αν είναι ολοκληρωμένο, προσθήκη κουμπιού εκτύπωσης στην αρχική σελίδα χρήστη
			echo '<td style="padding:10px;">';
			if ($dest_page == 'home_page') {
				$php_location = "http://localhost/ge3/php/printVaccData.php?center_name=".$center_name.
								"&date=".$row['rendezvous_date'].
								"&time=".$row['rendezvous_time'];
				echo '<button class="any-button" onclick="location=\''.$php_location.'\'"> Εκτυπώστε το ραντεβού σας</button>';
			}
			else
				echo $row['status'];
		}
		echo '</td>';
		echo '</tr>'; # τέλος γραμμής
		
	}
	echo '</table>'; # τέλος πίνακα
}
else {
	# Ο χρήστης δεν είχε επιλέξει ποτέ κάποιο ραντεβού
	echo '<p>Δεν έχετε εμβολιαστεί.</p>';
	if ($dest_page == 'home_page') {
		echo '<p>Μπορείτε να κλείσετε ραντεβού για εμβολιασμό.</p>';
		echo '<button class="any-button" onclick="location=\'php/validateVaccAge.php\'"> Κλείστε το ραντεβού σας</button>';
	}
	else {
		echo '<p>Επιλέξτε εμβολιστιακό κέντρο.</p>';
	}
}

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>
