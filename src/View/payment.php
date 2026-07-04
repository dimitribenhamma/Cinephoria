<!-- La Page d'UI payment.php : style K&R , indentation Ok -->
<?php
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
	include_once ROOT_PATH . $paymentForm_path ;
	

	$title_payment = "Paiement";
	$text_button = "Voir mon billet";

?>
<!DOCTYPE html> 
<html lang="fr">
  	<head>
			<title><?= $_ENV["APP_NAME"]; ?></title>
			<script src="js/form.js"></script> <!-- Fichier externe Javascript -->
 <style>	   
input[type='text'] {
    width: 300px;
    text-align:center;
	margin-bottom:10px;
}
</style>			
	</head>
	<body> 	
	<?php		    	  		
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
           // Inclu le menu admin si le visiteur est admin ou employé
			if ($roleCustomer) {		  			
				include_once ROOT_PATH . $menuAdmin_path ;
				}		
		
			/* On inclus les scripts nécéssaires */
			include_once ROOT_PATH . $paymentForm_path ;
	?>	
<!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
<main>
	            <!-- On y applique nos classes -->
            <?php
                // Assignation de motifs (patterns) qui décrit le modèle d'une chaîne de caractères pour une donnée vraiment renseignée
                $creditCardPattern = "^[0-9 ]{13,23}$";
                $cryptogramPattern = "^[0-9]{3,4}$";			
				$nameCardPattern = '/^(?:M|MME\s)?[A-ZÀ-Ö]{1,20}(?:[\'-][A-ZÀ-Ö]{1,20})*\s[A-ZÀ-Ö]{1,20}(?:[\'-][A-ZÀ-Ö]{1,20})*$/u';


                    // Créée le formulaire
                    $form = new PaymentForm('index.php?page=' . $actionPaymentPage) ;
                    $form->addField(new FormField('creditCard', 'text', '', "Veuillez saisir un numéro de carte valide (ex: 1234 5678 9012 3456)", 13, 19, "Carte de crédit", "font-size:20px;font-weight:bold;", "margin-top:10px;width:200px;height:35px;", '',"Carte de crédit", "on")) ;
                    $form->addField(new FormField('cryptogram', 'text', '', "3 à 4 caractères", 3, 4, 'Cryptogram', "font-size:20px;font-weight:bold;", "margin-top:10px;width:200px;height:35px;text-align:center", '','Cryptogram', "on")) ;
                    $form->addField(new FormField('nameCard', 'text', '', "Nom invalide", 2, 40, 'Nom', "font-size:20px;font-weight:bold;", "margin-top:10px;width:200px;height:35px;", '','Nom', "on")) ;
                    // Affiche le formulaire
                    echo $form->render() ;
                ?> 
</main>

      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>					
			
			</div>
  </body>
</html>