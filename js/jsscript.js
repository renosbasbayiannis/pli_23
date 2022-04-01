// Συνάρτηση που ελέγχει αν το όρισμά της είναι αριθμός
function validateNumber(param) {
	let digit;
	let str = String(param);
	// κάθε ψηφίο πρέπει να είναι αριθμός
	for (let i = 0; i < str.length; i++) {
		digit = Number(str.charAt(i));
		if (isNaN(digit)) {
			return false;
		}
	}
	return true;
}

// Συνάρτηση που ελέγχει αν το όρισμά της είναι έγκυρος ΑΜΞΑ
function validateAMKA(param) {
  let amkaNo = String(param); // ως string για να μην χαθούν 
							  // τα αρχικά 0 στο ΑΜΚΑ
  if (amkaNo == "") { // δεν πρέπει να είναι κενό
    alert("Εισάγετε το ΑΜΚΑ");
	return false;
  }
  if (amkaNo.length != 11) { // Το ΑΜΚΑ αποτελείται από 11 αριθμούς
	  alert("Εισάγετε έγκυρο ΑΜΚΑ");
	  return false;
  }
  if (validateNumber(amkaNo) == false) { //όλα τα ψηφία πρέπει να είναι 
									    //αριθμοί
	  alert("Εισάγετε έγκυρο ΑΜΚΑ");
	  return false;
  }
  return true;
}

// Συνάρτηση που ελέγχει αν το όρισμά της είναι έγκυρο ΑΦΜ
function validateAFM(param) {
  let afmNo = String(param);
  if (afmNo == "") { // δεν πρέπει να είναι κενό
    alert("Εισάγετε το ΑΦΜ");
    return false;
  }
  if (afmNo.length != 9) { // Το ΑΦΜ αποτελείται από 9 αριθμούς
	  alert("Εισάγετε έγκυρο ΑΦΜ");
	  return false;
  }
  if (validateNumber(afmNo) == false) { //όλα τα ψηφία πρέπει να είναι 
									    //αριθμοί
	  alert("Εισάγετε έγκυρο ΑΦΜ");
	  return false;
  }
  return true;
}

// Συνάρτηση που ελέγχει την εγκυρότητα των στοιχείων
// της φόρμας του login
function validateLoginForm() {
  let amka = document.forms["login_form"]["amka"].value;
  // ως string γιατί το ΑΜΚΑ μπορεί να ξεκινά από 0
  let amkaNo = String(amka);
  if (validateAMKA(amkaNo) == false)
	  return false;
  
  let afm = document.forms["login_form"]["afm"].value;
  // ως string γιατί το ΑΦΜ μπορεί να ξεκινά από 0
  let afmNo = String(afm);
  if (validateAFM(afmNo) == false)
	  return false;
  
  return true;
}

// Συνάρτηση που ελέγχει το email
function validateEmail(email) {
	// A valid email has a general form of personal_info@domain
	// https://www.w3resource.com/javascript/form/email-validation.php
	// Personal_info: 
	// It contains the following ASCII characters:
	// Uppercase (A-Z) and lowercase (a-z) English letters
	// Digits (0-9)
	// Characters ! # $ % & ' * + - / = ? ^ _ ` { | } ~
	// Character . ( period, dot or fullstop) provided that 
	// it is not the first or last character and it will not come 
	// one after the other.
	// domain:
	// The domain name [for example com, org, net, in, us, info] part 
	// contains letters, digits, hyphens, and dots.
    let email_format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email != '') {
  	    if (email.match(email_format)) {
  		    return true;
  	    }
  	    else {
  		    alert("Μη έγκυρη διεύθυνση email");
  		    return false;
  	    }
    }
	// το κενό email είναι αποδεκτό - δεν είναι υποχρεωτικό σε μια φόρμα
    return true;
}

// Συνάρτηση που ελέγχει την ηλικία
function validateAge(age) {
	if (age == "") { // δεν πρέπει να είναι κενό
		alert("Εισάγετε ηλικία");
		return false;
	}
	else {
		// να είναι αριθμός και  αριθμός > 0
		let ageNo = Number(age);
		if (isNaN(ageNo) || (age <= 0) ) {
			alert("Εισάγετε έγκυρη ηλικία");
			return false;
	    }
	}
	return true;
}

// Συνάρτηση που ελέγχει την ταυτότητα
function validateIdentity(identity) {
	if (identity == "") { // δεν πρέπει να είναι κενό
		alert("Εισάγετε αριθμό αστυνομικής ταυτότητας");
		return false;
	}
	return true;
}

// Συνάρτηση που ελέγχει το κινητό
function validateCellphone(cellphone) {
	if (cellphone == "") { // δεν πρέπει να είναι κενό
		alert("Εισάγετε κινητό τηλέφωνο");
		return false;
	}
	return true;
}

// Συνάρτηση που ελέγχει την εγκυρότητα των στοιχείων του χρήστη
// στη φόρμα αλλαγής στοιχείων στη σελίδα Λογαριασμός του
function validateUserData() {
	let identity = document.forms["changeUserDataForm"]["identity"].value;
    if (validateIdentity(identity) == false)
		return false;
  
	let age = document.forms["changeUserDataForm"]["age"].value;
	if (validateAge(age) == false)
		return false;
  
	let email = document.forms["changeUserDataForm"]["email"].value;
	if (validateEmail(email) == false)
		return false;
	
	let cellphone = document.forms["changeUserDataForm"]["cellphone"].value;
    if (validateCellphone(cellphone) == false)
		return false;
  
	return true;
}

// Συνάρτηση που ελέγχει την εγκυρότητα των στοιχείων
// της φόρμας Έγγραφής χρήστη
function validateRegistrationForm() {
  let name = document.forms["registration_form"]["name"].value;
  if (name == "") { // δεν πρέπει να είναι κενό
    alert("Εισάγετε όνομα");
	return false;
  }
  
  let surname = document.forms["registration_form"]["surname"].value;
  if (surname == "") { // δεν πρέπει να είναι κενό
    alert("Εισάγετε επώνυμο");
    return false;
  }
  
  let amka = document.forms["registration_form"]["amka"].value;
  let amkaNo = String(amka);
  // ως string γιατί το ΑΜΚΑ μπορεί να ξεκινά από 0
  if (validateAMKA(amkaNo) == false)
	  return false;
  
  let afm = document.forms["registration_form"]["afm"].value;
  // ως string γιατί το ΑΦΜ μπορεί να ξεκινά από 0
  let afmNo = String(afm);
  if (validateAFM(afmNo) == false)
	  return false;
  
  let identity = document.forms["registration_form"]["identity"].value;
  if (validateIdentity(identity) == false)
	  return false;
  
  let age = document.forms["registration_form"]["age"].value;
  if (validateAge(age) == false)
	  return false;
  
  let email = document.forms["registration_form"]["email"].value;
  if (validateEmail(email) == false)
	  return false;
  
  let cellphone = document.forms["registration_form"]["cellphone"].value;
  if (validateCellphone(cellphone) == false)
	  return false;
  
  return true;
}

// Συνάρτηση που κάνει ορατή τη φόρμα Επιλογής Εμβολιαστικού Κέντρου
function openDeclareVaccCenterForm() {
  document.getElementById("select_vacc_center_form_id").style.display = "block";
}
// Συνάρτηση που κάνει κρυφή τη φόρμα Επιλογής Εμβολιαστικού Κέντρου
function closeDeclareVaccCenterForm() {
  document.getElementById("select_vacc_center_form_id").style.display = "none";
}
// Συνάρτηση που κάνει ορατή τη φόρμα Αλλαγής στοιχείων λογαριασμού χρήστη
function openChangeUserDataForm() {
  document.getElementById("change_user_data_form_id").style.display = "block";
}
// Συνάρτηση που κάνει κρυφή τη φόρμα Αλλαγής στοιχείων λογαριασμού χρήστη
function closeChangeUserDataForm() {
  document.getElementById("change_user_data_form_id").style.display = "none";
}

// Συνάρτηση που ελέγχει αν υπάρχει ενεργή συνεδρία
// Αν δεν υπάρχει, παραπέμπει στη σελίδα εισόδου Login
function checkForActiveSession() {
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function() {
		if (this.responseText == 'no_session') {
			alert("Δεν έχετε συνδεθεί");
			location = "login.html";
		}
	}
	xhttp.open("GET", "http://localhost/ge3/php/getSessionData.php");
	xhttp.send();
}

// Συνάρτηση που ελέγχει αν υπάρχει ενεργή συνεδρία
// Χρησιμοποιείται στις σελίδες του αριστερού μενού της
// Πλατφόρμας Εμβολιασμού. Αν υπάρχει ενεργή συνεδρία, 
// θα κάνει ορατή τη γραμμή του μενού 'Αρχική Σελίδα Χρήστη'
function displayActiveSessionItems() {
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function() {
		let session_class_elem_arr = document.getElementsByClassName("active_session_class");
		
		if (this.responseText == 'active_session') {
			for (let i = 0; i < session_class_elem_arr.length; i++) {
				session_class_elem_arr[i].style.display = "block";
			}
		}
		else {
			for (let i = 0; i < session_class_elem_arr.length; i++) {
				session_class_elem_arr[i].style.display = "none";
			}
		}
	}
	xhttp.open("GET", "http://localhost/ge3/php/getSessionData.php");
	xhttp.send();
}

// Αναλόγως του ρόλου του χρήστη, τίθεται και ο υπερσύνδεσμος
// στη γραμμή του μενού 'Αρχική σελίδα Χρήστη΄'
function setUserHomepage() {
	{
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function() {
		let homepage_elem = document.getElementById("user_homepage_id");
		if (this.responseText == 'ΠΟΛΙΤΗΣ')
			homepage_elem.href = "citizenHomepage.html";
		else if (this.responseText == 'ΓΙΑΤΡΟΣ')
			homepage_elem.href = "doctorHomepage.html";
		else 
			homepage_elem.href = "";
	}
	xhttp.open("GET", "http://localhost/ge3/php/getUserRole.php");
	xhttp.send();
	}
}

// Συνάρτηση που εμφανίζει τα στοιχεία χρήστη στις σελίδες
// αρχική σελίδα και λογαριασμός χρήστη
function getUserData() {
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function() {
		let len = this.responseText.length;
		document.getElementById("user_data_id").innerHTML = this.responseText;
	}
	xhttp.open("GET", "http://localhost/ge3/php/getUserData.php");
	xhttp.send();
}

// Συνάρτηση που ανακτά τα στοιχεία εμβολιασμού του πολίτη
// Η παράμετρος συμβολίζει τη σελίδα στην οποία θα εμφανιστούν τα στοιχεία
// που θα επιστρέψει ο εξυπηρετητής και δίνεται ως παράμετρος στο php
function getVaccinationData(dest_page_param) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
	document.getElementById("vaccination_data_id").innerHTML = this.responseText;
  }
  xhttp.open("GET", "http://localhost/ge3/php/getVaccinationData.php?dest_page="+dest_page_param);
  xhttp.send();
}


