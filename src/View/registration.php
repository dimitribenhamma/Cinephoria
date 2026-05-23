<!-- La Page d'UI registration.php : style K&R , indentation Ok -->
<?php 
		// Le code empêche une nouvelle session d’être appelée plusieurs fois
	  	if (session_status() === PHP_SESSION_NONE) {
    	    session_start();
		  }

		/* Fichiers à inclure */
		$appName = 'app' ;
		$app_path = "/config/$appName.php" ;
		include_once ROOT_PATH . $app_path ;
		include_once ROOT_PATH . "/src/View/components/IP.php" ;
		$currentLang = language_nav() ;
		include_once ROOT_PATH . "/lang/$currentLang.php" ;
		$paths_path = "/config/paths.php" ;
		include_once ROOT_PATH . $paths_path ;
		
		// le visiteur est client par défaut
		if (!isset($_SESSION['role'])) {
            $_SESSION['role'] = $customer;
       	  }

?>
<!-- DOCTYPE déclare du HTML → navigateur lit le HTML → DOM est créé → affichage navigateur correct -->
<!DOCTYPE html>
<!-- Le HTML DOM (Document Object Model) construit l'arbre d’objets avec chaque élément HTML manipulable par JavaScript -->
<html lang="fr">
	<!-- Head contient les dépendances d’une page HTML, pas le contenu affiché -->
  <head>
	<!-- On y inclu les metas essentielles d'indexation -->
	<?php include_once ROOT_PATH . $meta_path; ?>
	<!-- Notre fichier .env est situé à la racine du projet -->
    <title><?= $_ENV["APP_NAME"]; ?></title>
	<script src="<?= $form_js ; ?>" defer></script> <!-- Fichier externe Javascript -->
  </head>
  <body>  			
	<?php			  
		// Le header et le menu-admin sont à inclure sur chaque page
			include_once ROOT_PATH . $header_path ;                   		  			
			include_once ROOT_PATH . $registrationForm_path ;

		// Inclu le menu admin si le visiteur est admin ou employé
        if (!$roleCustomer) {		  			
            include_once ROOT_PATH . $menuAdmin_path ;
		}
	?>
<!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
 <main>
	<!-- Méthode Oriéntée Objet --> 
	<?php
			
		/* Obtenir le formulaire (Orienté objet) */
		$form = new RegistrationForm("index.php?page=$registrationController") ;

		// Méthode d'affichage
		echo $form->render() ;

	?>
</main>	
      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>

	<script>
		console.log("<?= $consoleRegistration ; ?>");
	</script>	
  </body>
</html