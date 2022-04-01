<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# ανάκτηση μεταβλητών της συνεδρίας
$user_id = $_SESSION['user_id'];
$selected_center = $_POST['selected_center'];

require 'connectDB.php';


if (strlen($selected_center) == 0) {
	# Έχει επιλεγεί η default επιλογή του drop down menu
	echo '  <script language="javascript" type="text/javascript">
		alert("Παρακαλώ επιλέξτε Εμβολιαστικό Κέντρο");
		location.href = "../doctorHomepage.html";
		</script>';
}
else {
	# Εύρεση αν ο γιατρός έχει δηλώσει center id
	$sql="SELECT doctor_id, center_id FROM center_doctor
	WHERE doctor_id = '$user_id'";

	$result = $mysqli->query($sql);
	if ($result->num_rows == 0) {
		# Ο γιατρός δεν έχει δηλώσει center id
		$result->close();
		# εύρεση του center_id βάσει ονόματος
		$sql="SELECT center_id, name FROM center 
		WHERE name = '$selected_center'";
			
		$center_result = $mysqli->query($sql);
		if ($center_result->num_rows != 0) {
			$row = $center_result->fetch_assoc();
			$center_id = $row['center_id'];
			$center_result->close();
			
			# Δήλωση του γιατρού στο εμβολιαστικό κέντρο
			$sql="INSERT INTO center_doctor (doctor_id, center_id)
				VALUES
				('$user_id','$center_id')";
            
			if ($mysqli->query($sql) == true) {
				echo '  <script language="javascript" type="text/javascript">
					if (!alert ("Η δήλωση του Εμβολιαστικού Κέντρου ήταν επιτυχής")) {
						location.href = "../doctorHomepage.html";
					}
					</script>';
			}
			else {
				echo '  <script language="javascript" type="text/javascript">
					if (!alert ("Μήνυμα λάθους: Η δήλωση του Εμβολιαστικού Κέντρου απέτυχε")) {
						location.href = "../doctorHomepage.html";
					}
					</script>';
			}
		}
		else {
			echo '  <script language="javascript" type="text/javascript">
				if (!alert ("Πρόβλημα στην εύρεση του Εμβολιαστικού Κέντρου")) {
					location.href = "../doctorHomepage.html";
				}
				</script>';
		}
	}
	else {
		# ο γιατρός έχει ήδη δηλώσει εμβολιαστικό κέντρο
		# Δεν μπορεί να αλλάξει εμβολιαστικό κέντρο
		echo '  <script language="javascript" type="text/javascript">
			alert("Έχετε ήδη δηλώσει Εμβολιαστικό Κέντρο");
			location.href = "../doctorHomepage.html";
			</script>';
	}
}

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>