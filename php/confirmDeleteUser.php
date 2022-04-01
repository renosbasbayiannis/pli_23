<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# Ζητείται από το χρήστη Επιβεβαίωση της διαγραφής του χρήστη
# Αν επιβεβαιώσει τη διαγραφή, ανακατευθύνεται στη σελίδα
# διαγραφής του χρήστη, αλλιώς στην προηγούμενη σελίδα
echo '  <script language="javascript" type="text/javascript">
		if (confirm("Επιθυμείτε τη διαγραφή του λογαριασμού σας ;") == true) {
			alert("Συνέχεια στη διαγραφή");
			location = "deleteUser.php";
		}
		else {
			alert("Ο λογαριασμός δεν διαγράφηκε");
			history.go (-1);
		}
		</script>';
		
?>