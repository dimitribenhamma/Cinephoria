<!-- La page d'UI du site manage-users.php : Style K&R , indentation Ok -->
<?php 
	    if (session_status() === PHP_SESSION_NONE) {
    	  	session_start() ;} 	
			
		/* Fichiers à inclure */
				include_once ROOT_PATH . "/src/View/components/IP.php" ;
				$currentLang = language_nav() ;
				include_once ROOT_PATH . "/lang/$currentLang.php" ;
				$appName = 'app' ;
				$app_path = "/config/$appName.php" ;
				include_once ROOT_PATH . $app_path ;
				$paths_path = "/config/paths.php" ;
				include_once ROOT_PATH . $paths_path ;
				include_once ROOT_PATH . $cookiesBanner_path ;
				$sql= "/config/sql.php" ;
				include_once ROOT_PATH . $sql ;

?>
<!DOCTYPE html>				
<html lang="fr"> 			  
<head>
	<?php
		/* On y inclus les fichiers meta essentiels */
		include_once ROOT_PATH . $meta_path ;
	?>
		<title><?= $_ENV["APP_NAME"]; ?></title>
</head>
<body> 	
	<?php		    	  		
		include_once ROOT_PATH . $header_path; // notre top logo + menu + boutons					  			
	if(($_SESSION['role'] == "employe") || ($_SESSION['role'] == "admin")) {
		include_once ROOT_PATH . $menuAdmin_path; } // notre menu administrateur		
	?>	

	<?php 
       											
		try {		
				/* On essaie de se connecter en base */
				$conn = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
				// On veut définir le mode d'erreur de PDO sur Exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);																		

					// Demander la correspondance de tous les utilisateurs clients
					$sth = $conn->prepare($users);
					$sth->execute();
					
					$resultats = $sth->fetchAll(PDO::FETCH_ASSOC);

					
				/* Cas avec succès, on affiche les membres */
					if (!empty($resultats)) {
						echo "<main style='margin-left:30%;margin-top:5%;margin-bottom:5%;background-color:white;'>
								<table border='1'>
									<caption style='margin-bottom:2%;'><strong>" . ucfirst($titleUsers) . "</strong></caption>
									<tr>
										<th style='border: 1px solid black; padding: 10px;'>". strtoupper($IdLabel) . "</th>
										<th style='border: 1px solid black; padding: 10px;'>". ucfirst($nameLabel) . "</th>
										<th style='border: 1px solid black; padding: 10px;'>". ucfirst($surnameLabel) . "</th>
										<th style='border: 1px solid black; padding: 10px;'>". ucfirst($userNameLabel) . "</th>
										<th style='border: 1px solid black; padding: 10px;'>". ucfirst($emailNameLabel) . "</th>
										<th style='border: 1px solid black; padding: 10px;'>". ucfirst($dateLabel) . "</th>
									</tr>";
						
						foreach($resultats as $line) { 
							echo "<tr>
									<td style='border: 1px solid black; padding: 10px;'>" . htmlspecialchars($line['id']) . "</td>
									<td style='border: 1px solid black; padding: 10px;'>" . htmlspecialchars($line['nom']) . "</td>
									<td style='border: 1px solid black; padding: 10px;'>" . htmlspecialchars($line['prenom']) . "</td>
									<td style='border: 1px solid black; padding: 10px;'>" . htmlspecialchars($line['user']) . "</td>
									<td style='border: 1px solid black; padding: 10px;'>" . htmlspecialchars($line['email']) . "</td>
									<td style='border: 1px solid black; padding: 10px;'>" . htmlspecialchars($line['date_inscription']) . "</td>
								</tr>";
						}
							echo "</table>
							</main>";				
						
					} 
					else {											
						error_log("$emptyUserDatabase");	   																
						exit("Erreur (Bdd) : pas de résultats d'utilisateurs dans la base");
					  }
				}
			
		
		catch (PDOException $e) {
			error_log('Erreur Connexion : ' . $e->getMessage());		
			} 
	?>

		<!-- Partie php pied de page -->
		    <footer class="under">
                    <?php include_once ROOT_PATH . $bottom_path; ?>
			</footer>
								


	<script>
		/* Début Javascript */
	console.log("Cinéphoria : Gérer les utilisateurs");
	</script>



	</body>
</html>