	var form = document.querySelector(".form");
	var button = document.querySelector(".buttons-text");
	var miniLength = 8;
  
	function verifier(champ) {
        let valid = true;
		switch (champ.name) {            
  
	// Minimum 2 caractères		
		case 'name':
		case 'surname':
		case 'user':
            if (champ.value.trim() === "") {
                champ.style.border = "2px solid black"; // invalide
				valid = false ;
                }
			else if (champ.value.trim().length < 2) {
				champ.style.border = '3px solid red'; // invalide
				valid = false ;
			    }
            else {
				champ.style.border = '3px solid green'; // valide
				valid = true ;
			    }
        break;    
	// Minimum 8 caractères
		case 'password':
		case 'email':
		case 'date':
            if (champ.value.trim() === "") {
                champ.style.border = "2px solid black"; // invalide
				valid = false ;
            }
			else if (champ.value.trim().length < miniLength) {
			    champ.style.border = '3px solid red'; // invalide
				valid = false ;
			} else {
			    champ.style.border = '3px solid green'; // valide
				valid = true ;
			}
        break;

	// Minimum 13 caractères
		case 'creditCard':
			if (champ.value.trim() === "") {
                champ.style.border = "2px solid black"; // invalide
				valid = false ;
            }
			else if (champ.value.trim().length < 13) {
			    champ.style.border = '3px solid red'; // invalide
				valid = false ;
			} else {
			    champ.style.border = '3px solid green'; // valide
				valid = true ;
			}
        break;

	// Minimum 3 caractères
		case 'cryptogram':
			if (champ.value.trim() === "") {
                champ.style.border = "2px solid black"; // invalide
				valid = false ;
            }
			else if (champ.value.trim().length < 3) {
			    champ.style.border = '3px solid red'; // invalide
				valid = false ;
			} else {
			    champ.style.border = '3px solid green'; // valide
				valid = true ;
			}
        break;

	// Minimum 2 caractères
		case 'nameCard':
			if (champ.value.trim() === "") {
                champ.style.border = "2px solid black"; // invalide
				valid = false ;
            }
			else if (champ.value.trim().length < 2) {
			    champ.style.border = '3px solid red'; // invalide
				valid = false ;
			} else {
			    champ.style.border = '3px solid green'; // valide
				valid = true ;
			}
        break;
	}
	return valid;
}

    function confirmer(champ){

        const msg = document.getElementById("msg_" + champ.name);

        	switch (champ.name) {            
  
	// Minimum 2 caractères		
		case 'name':
		case 'surname':
		case 'user':
            if (champ.value.trim() === "") {
				
                msg.textContent = "❌";}
			else if (champ.value.trim().length < 2) {
			    msg.textContent = "❌";}
            else {
			    msg.textContent = "✅";} // valide
        break;    
	// Minimum 8 caractères				
		case 'password':
		case 'email':
		case 'date':
            if (champ.value.trim() === "") {
                msg.textContent = "❌";}
			else if (champ.value.trim().length < miniLength) {
			    msg.textContent = "❌";}
			else {
			    msg.textContent = "✅";} // valide
        break;

	// Minimum 13 caractères				
		case 'creditCard':
            if (champ.value.trim() === "") {
                msg.textContent = "❌";}
			else if (champ.value.trim().length < 13) {
			    msg.textContent = "❌";}
			else {
			    msg.textContent = "✅";} // valide
        break;

	// Minimum 3 caractères				
		case 'cryptogram':
            if (champ.value.trim() === "") {
                msg.textContent = "❌";}
			else if (champ.value.trim().length < 3) {
			    msg.textContent = "❌";}
			else {
			    msg.textContent = "✅";} // valide
        break;

	// Minimum 2 caractères				
		case 'nameCard':
            if (champ.value.trim() === "") {
                msg.textContent = "❌";}
			else if (champ.value.trim().length < 2) {
			    msg.textContent = "❌";}
			else {
			    msg.textContent = "✅";} // valide
        break;
	}
}

// Vérification globale pour activer le bouton
    function verifierForm() {
    let allValid = true;
	

    form.querySelectorAll("input").forEach(champ => {
        if(champ.type !== "submit") {
            allValid = verifier(champ) && allValid;
        }
    });

    button.disabled = !allValid;
    button.style.opacity = allValid ? "1" : "0.5";
    button.style.cursor = allValid ? "pointer" : "not-allowed";
}

	document.addEventListener("DOMContentLoaded", function() {

    var form = document.querySelector(".form");
    var button = document.querySelector(".buttons-text");

    form.querySelectorAll("input").forEach(champ => {
        if (champ.type !== "submit") {

            champ.addEventListener("input", function() {
                verifier(champ);
                confirmer(champ);
                verifierForm();
            });

            champ.addEventListener("blur", function() {
                verifier(champ);
                confirmer(champ);
                verifierForm();
            });

        }
    });

    // Vérification initiale
    verifierForm();
});
