<!-- La Page d'UI registration.php : style K&R , indentation Ok -->
<?php 
		// Le code empêche une nouvelle session d’être appelée plusieurs fois
	  	if (session_status() === PHP_SESSION_NONE) {
    	    session_start();
		  }
?>
<!-- DOCTYPE déclare du HTML → navigateur lit le HTML → DOM est créé → affichage navigateur correct -->
<!DOCTYPE html>
<!-- Le HTML DOM (Document Object Model) construit l'arbre d’objets avec chaque élément HTML manipulable par JavaScript -->
<html lang="fr">
	<!-- Head contient les dépendances d’une page HTML, pas le contenu affiché -->
  <head>
	<?php 
	// Donnée de départ
    $_SESSION['role'] = $roleCustomer ;
	// On y inclu les metas essentielles d'indexation
	include_once ROOT_PATH . $meta_path; ?>
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