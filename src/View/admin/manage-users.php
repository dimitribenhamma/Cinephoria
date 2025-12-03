<!-- Style K&R , indentation Ok -->
<!-- Code pour afficher des utilisateurs -->
<?php 
	  if (session_status() === PHP_SESSION_NONE) {
    	  session_start();} 	
		  $title_table = "Liste des Membres";
?>

<!DOCTYPE html>				
<html lang="fr"> 			  
	<head>
			<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title><?= $_ENV["APP_NAME"]; ?></title>
			<link href="css/style.css" rel="stylesheet">
	</head>
<body> 	
	<?php		    	  		
		include_once ROOT_PATH . $header_path; // notre top logo + menu + boutons					  			
		include_once ROOT_PATH . $menu_admin_path; // notre menu administrateur
	?>	

		<?php 
		// Vérification si l'utilisateur est employé ou administrateur
        if(($_SESSION['role'] == "employe") || ($_SESSION['role'] == "admin")){	
							
					// On essaie de se connecter en base
		try {		

				$conn = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
				// On veut définir le mode d'erreur de PDO sur Exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);																		

					$sth = $conn->prepare("SELECT id,nom,prenom,user,email,date from `membres`"); // demander la correspondance identifiant et mot de passe		
					$sth->execute();
					
					$resultat = $sth->fetchAll(PDO::FETCH_ASSOC);

					/* cas avec succès */
					

					// password_verify entre clair et haché : 
					// 1. le résultat est différent car un "salt" aléatoire est ajouté
					// 2. le hash change à chaque password_hash()
					if (!empty($resultat)) {
						echo '<main style="margin-left:30%;margin-top:5%;"><table border="1">
								<caption><strong>' . $title_table . '</strong></caption>
								<tr>
									<th style="border: 1px solid black; padding: 10px;">ID</th>
									<th style="border: 1px solid black; padding: 10px;">Nom</th>
									<th style="border: 1px solid black; padding: 10px;">Prénom</th>
									<th style="border: 1px solid black; padding: 10px;">User</th>
									<th style="border: 1px solid black; padding: 10px;">Email</th>
									<th style="border: 1px solid black; padding: 10px;">Date</th>
								</tr>';
						
						foreach($resultat as $ligne){
							echo "<tr>
									<td style='border: 1px solid black; padding: 10px;'>{$ligne['id']}</td>
									<td style='border: 1px solid black; padding: 10px;'>{$ligne['nom']}</td>
									<td style='border: 1px solid black; padding: 10px;'>{$ligne['prenom']}</td>
									<td style='border: 1px solid black; padding: 10px;'>{$ligne['user']}</td>
									<td style='border: 1px solid black; padding: 10px;'>{$ligne['email']}</td>
									<td style='border: 1px solid black; padding: 10px;'>{$ligne['date']}</td>
								</tr>";
						}
						echo "</table></main>";				
						exit();
					} else {											
						error_log("Erreur (Bdd) : pas de résultats dans la base d'utilisateurs");	   																
						exit();
					}
				}
			
		
		catch(PDOException $e){
			error_log('Erreur Connexion : ' . $e->getMessage());		
			}} ?>

		<!-- Partie php pied de page -->
		    <footer class="under">
                    <?php include_once ROOT_PATH . $bottom_path; ?>
			</footer>
								


	<script>
		/* Début Javascript */
    		
		const imgApercu = document.getElementById('preview');
		const inputFile = document.getElementById('imageUpload');
		const bouton = document.getElementById('monBouton');
	    const boutonEffacer = document.getElementById('effacer');
		const monFormulaire = document.getElementById('monForm');
    
	function afficherApercu(event) {
		const fichier = event.target.files[0]; /* première, unique image */
      if (!fichier) {
        imgApercu.style.display = 'none';
        imgApercu.src = '';
		bouton.style.display = 'none';
		return;
      }
	  else {
      const lecteur = new FileReader();
      lecteur.onload = function (e) {		
        imgApercu.src = e.target.result;
		imgApercu.style.width = "150px";  // styles personnalisés s'appliquent en javascript
		imgApercu.style.height = "200px";
        imgApercu.style.display = 'block';
		bouton.style.display = 'inline';
      };
      lecteur.readAsDataURL(fichier);
      
	}
	};

	boutonEffacer.addEventListener('click', function () {
		inputFile.value = "";       // Réinitialise l'input file
		imgApercu.src = "";        // Efface l'image
		imgApercu.style.width = "";  // styles personnalisés réinitialisés à 0
		imgApercu.style.height = "";
		bouton.style.display = 'none';	

		monFormulaire.querySelectorAll('input[type="text"], textarea').forEach(el => {
    	el.value = '';
  		});		
});

	// Pour vider le formulaire complètement, pas aux valeurs d’origine du HTML
	// en ciblant tous les champs


	// on veux prévisualiser une image et donc utiliser, sur le bouton file, l'événement change 
	inputFile.addEventListener('change', afficherApercu);

	console.log("Cinéphoria : Gérer les produits");
	</script>



	</body>
</html>