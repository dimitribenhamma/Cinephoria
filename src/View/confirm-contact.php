<!-- script exécutable confirm-contact.php : style K&R , indentation Ok -->
<?php
		// en-tête HTTP
		if (session_status() === PHP_SESSION_NONE) {
			session_start() ;
		}
		// 
		$_SESSION['errorContact'] = isset($_SESSION['errorContact']) ?? "" ;
	?>
		<?php
			// Inclut le fichier autoload.php de Composer
			use PHPMailer\PHPMailer\PHPMailer ;
			use PHPMailer\PHPMailer\Exception ;

			require '../vendor/autoload.php' ;

			// Créer une nouvelle instance de PHPMailer
			$mail = new PHPMailer(true) ;
            
            // Formulaire de contact
			if (isset($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['description'])) {	

				/* traitement spécifique via SMTP */ 											     																				

				// Configuration du serveur SMTP
				$mail->isSMTP() ;
				$mail->CharSet = 'UTF-8' ;
				$mail->Host = 'smtp.gmail.com' ; // Notre serveur SMTP
				$mail->SMTPAuth = true ;
				$mail->Username = 'suivi.cinephoria@gmail.com' ; // Notre email
				$mail->Password = 'xjnfmzyxdlpyhkco' ; // Le mot de passe smtp de l'application 'Mail' gmail 'myaccount.com/apppaswords'
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS ;
				$mail->Port = 587 ;

				// Destinataires
				$mail->setFrom('suivi.cinephoria@gmail.com', 'Cinéphoria') ;
				$mail->addAddress('suivi.cinephoria@gmail.com', $_POST['nom'] . '' . $_POST['prenom']) ; // Adresse du destinataire
				$mail->addReplyTo('suivi.cinephoria@gmail.com', 'Cinéphoria') ;

				// Contenu de l'e-mail
				$mail->isHTML(true) ;
				$mail->CharSet = 'UTF-8' ;
				$mail->Subject = 'Cinéphoria : formulaire de contact' ;
				$mail->Body    = $_POST['description'] ;
				$mail->AltBody = 'La description de la réclamation' ;

				// Envoi de l'e-mail
				$mail->send() ;
				

				header("Location: index.php?page=$successContactPage") ; 
				exit("L'email a été envoyé avec succès") ;
			}	

			else {
				$_SESSION['errorContact'] = "Erreur de saisie du formulaire" ;
				exit("L'email n'a pas pu être envoyé (erreur de saisie du formulaire)") ;
			}								                                    
        ?>
	</body>
</html>	