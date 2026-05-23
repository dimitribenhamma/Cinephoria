<!-- La Page d'UI payment.php : style K&R , indentation Ok -->
<?php
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

	$title_payment = "Paiement";
	$text_button = "Voir mon billet";

?>
<!DOCTYPE html> 
<html lang="fr">
  	<head>
			<title><?= $_ENV["APP_NAME"]; ?></title>
			<script src="js/form.js"></script> <!-- Fichier externe Javascript -->
	</head>
	<body> 	
	<?php		    	  		
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}		
	
			/* On inclus les scripts nécéssaires */
			include_once ROOT_PATH . $paymentForm_path ;
	?>	
<!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
<main>
	            <!-- On y applique nos classes -->
            <?php
                // Assignation de motifs (patterns) qui décrit le modèle d'une chaîne de caractères pour une donnée vraiment renseignée
                $creditCardPattern = "^(?:\d{4}\s){2,4}\d{1,4}$" ;
                $cryptogramPattern = "^\d{3,4}$" ;
				$nameCardPattern = "^[A-ZÀ-ÖØ-Ý]+(?:[ \'-][A-ZÀ-ÖØ-Ý]+)*$/u" ;

                    // Créée le formulaire
                    $form = new PaymentForm('index.php?page=' . $actionPaymentPage) ;
                    $form->addField(new FormField('creditCard', 'number', $creditCardPattern, "Veuillez saisir un numéro de carte valide (ex: 1234 5678 9012 3456)", 13, 19, "Carte de crédit", "font-size:20px;font-weight:bold;", "margin-top:10px;width:200px;height:35px;", '',"Carte de crédit", "on")) ;
                    $form->addField(new FormField('cryptogram', 'number', $cryptogramPattern, "3 à 4 caractères", 3, 4, 'Cryptogram', "font-size:20px;font-weight:bold;", "margin-top:10px;width:200px;height:35px;", '','Cryptogram', "on")) ;
                    $form->addField(new FormField('nameCard', 'text', $namePattern, "Nom invalide", 2, 40, 'Nom', "font-size:20px;font-weight:bold;", "margin-top:10px;width:200px;height:35px;", '','Nom', "on")) ;
                    // Affiche le formulaire
                    echo $form->render() ;
                ?> 
</main>

      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
		<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>			
			
			</div>
  </body>
</html>