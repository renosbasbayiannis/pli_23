<?php
   
   # Στην αποσύνδεση του χρήστη
    session_start();
	// διαγραφή όλων των μεταβλητών συνεδρίας
	session_unset();
    // καταστροφή της συνεδρίας
	session_destroy();
	# Τερματισμός συνεδρίας
    session_write_close();
	
	# Ανακατεύθυνση στη σελίδα εισόδου
    header("Location: ../login.html");
   
?>