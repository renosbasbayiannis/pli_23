<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# Ζητείται από το χρήστη Επιβεβαίωση της ακύρωσης του ραντεβού
# Αν επιβεβαιώσει την ακύρωση, ανακατευθύνεται στη σελίδα
# ακύρωσης του ραντεβού, αλλιώς στην αρχική σελίδα του πολίτη
echo '  <script language="javascript" type="text/javascript">
		if (confirm("Επιθυμείτε την ακύρωση του ραντεβού σας ;") == true) {
				alert("Συνέχεια στην ακύρωση του ραντεβού");
				location = \'cancelRendenvous.php\';
			}
		else {
			alert("Το ραντεβού εξακολουθεί να ισχύει");
			location = \'../citizenHomepage.html\';
		}
		</script>';
		
?>