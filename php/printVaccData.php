<?php
session_start();
header('Content-Type:text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

# λήψη των πεδίων από τη url
$center_name=$_GET['center_name'];
$date = $_GET['date'];
$time = $_GET['time'];

# ανάκτηση μεταβλητών της συνεδρίας
$name=$_SESSION['name'];
$surname=$_SESSION['surname'];
$amka = $_SESSION['amka'];
$afm = $_SESSION['afm'];

include('phpqrcode/qrlib.php');
# Φάκελος με τα QR code
$folder="../qr_codes/";
# Όνομα αρχείου με διακριτικό το ΑΦΜ
$file_name="qr"."_".$afm.".png";
# Πλήρες όνομα αρχείου
$file_name=$folder.$file_name;
$_SESSION['file_name'] = $file_name;
# Τι θα περιέχει το QR code 
$qr_text="ΟΝΟΜΑ: ".$name."\r\n".
		 "ΕΠΩΝΥΜΟ: ".$surname."\r\n".
		 "ΕΜΒΟΛΙΑΣΤΙΚΟ ΚΕΝΤΡΟ: ".$center_name."\r\n".
		 "ΗΜΕΡΟΜΗΝΙΑ: ".$date."\r\n".
		 "ΩΡΑ: ".$time."\r\n".
		 "ΚΑΤΑΣΤΑΣΗ: Ολοκληρωμένο";
# αποθήκευση του QR code στο αρχείο του χρήστη
QRcode::png($qr_text,$file_name);


# Δημιουργία html κειμένου με τα στοιχεία εμβολιασμού
# όπως αυτά λαμβάνονται από τις μεταβλητές συνεδρίας
echo "<!DOCTYPE html>";
echo "<head>";
echo '<link rel="stylesheet" href="../css/mystyle.css" type="text/css" media="screen">';
echo '<script>';
# On print, call window.print. But first make the buttons invisible.
# Then print the document.
# Finally make the buttons visible again.
echo 'function printPage() {
	document.getElementById("printButtonId").style.visibility = "hidden";
	document.getElementById("returnButtonId").style.visibility = "hidden";
	window.print();
	document.getElementById("printButtonId").style.visibility = "visible";
	document.getElementById("returnButtonId").style.visibility = "visible";
	}';
echo '</script>';
echo "</head>";

# προσθήκη του QR code στην εκτυπώσιμη σελίδα
echo '<table class="print_header_table">';
echo '<tr>';
echo '<td>';
echo '<div style="text-align: center">';
echo '<img id="logo" src="../images/hellenic_republic.jpg" alt="Σήμα εμβολιαστικού προγράμματος" /></a>';
echo '<p>ΕΛΛΗΝΙΚΗ ΔΗΜΟΚΡΑΤΙΑ</p>';
echo '</div>';
echo '</td>';
echo '<td style="width:40%">';
echo '</td>';
echo '<td>';
echo '<div style="text-align: left">';
echo '<p>Μπορείτε να ελέγξετε την ισχύ του <p>';
echo '<p>αντιγράφου σκανάροντας το QR code<p>';
echo '</div>';
echo '</td>';
echo '<td id="qrCodeId">';
echo '<img src="'.$file_name.'"/>';
echo '</td>';
echo '</tr>';
echo '</table>';

echo '<div style="text-align: left; padding: 15px;">';
echo '<h1 style="font-size: 30px; text-align: center; color=#006080"><strong>ΒΕΒΑΙΩΣΗ ΕΜΒΟΛΙΑΣΜΟΥ</strong></h1>';
echo '<table class="print_header_table" style="width:70%; margin: auto;">';

echo '<tr>';
echo '<td style="width: 40%; margin: auto;">';
echo '<p>Όνομα<p>';
echo '<p style="color: #006080;"><strong>'.$name.'</strong></p>';
echo '</td>';
echo '<td style="width: 40%; margin: auto;">';
echo '<p>Επώνυμο<p>';
echo '<p style="color: #006080;"><strong>'.$surname.'</strong></p>';
echo '</td>';
echo '<td style="width: 20%; margin: auto;">';
echo '<p>AMKA<p>';
echo '<p style="color: #006080;"><strong>'.$amka.'</strong></p>';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td style="width: 40%; margin: auto;">';
echo '<div style="background-color:#006080; color: white; padding: 20px;">';
echo '<p">ΣΤΟΙΧΕΙΑ</p>';
echo '<p>ΕΜΒΟΛΙΟΥ</p>';
echo '<br><br>';
echo '<p>Τύπος εμβολίου</p>';
echo '<p>SCI-FI MEDICINES</p>';
echo '<p>GREECE</p>';
echo '</div>';
echo '</td>';
echo '<td style="width: 60%; margin: auto;">';
echo '<div style="padding: 20px;">';
echo '<p>Εμβολιαστικό Κέντρο</p>';
echo '<p style="color: #006080;"><strong>'. $center_name . '</strong></p>';
echo '<br><br>';
echo '<p>Ημερομηνία</p>';
echo '<p style="color: #006080;"><strong>'. $date . '</strong></p>';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</table>';

echo '<br><br><br><br>';
echo '<table class="print_header_table" style="width:70%; margin: auto;">';
echo '<tr>';
echo '<td>';
echo '<button class="any-button" id="printButtonId" onclick="printPage()"> Εκτύπωση</button>';
echo '</td>';
echo '<td>';
echo '<button class="any-button" id="returnButtonId" onclick="location=\'../citizenHomepage.html\'"> Επιστροφή</button>';
echo '</td>';
echo '</tr>';
echo '</table>';

echo "</html>";

?>