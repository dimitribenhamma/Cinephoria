	let minLength = 8;
  
	function verifier(champ) {
        
		switch (champ.name) {            
  
	// Minimum 2 caractères		
		case 'name':
		case 'surname':
		case 'user':
            if (champ.value.trim() === "") {
                champ.style.border = "3px solid red"; // invalide
                }
			else if (champ.value.trim().length < 2) {
				champ.style.border = '3px solid red'; // invalide
			    }
            else {
				champ.style.border = '3px solid green'; // valide
			    }
        break;    
	// Minimum 8 caractères				
		case 'password':
		case 'email':
		case 'date':
            if (champ.value.trim() === "") {
                champ.style.border = "3px solid red"; // invalide
            }
			else if (champ.value.trim().length < minLength) {
			    champ.style.border = '3px solid red'; // invalide
			} else {
			    champ.style.border = '3px solid green'; // valide
			}
        break;    								
	}
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
			else if (champ.value.trim().length < minLength) {
			    msg.textContent = "❌";}
			else {
			    msg.textContent = "✅";} // valide
			
        break;    								
	}
}
	