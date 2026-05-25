<!-- PasswordController.php (gestion PHP + requêtes SQL) style K&R , indentation Ok -->
<?php
		// en-tête HTTP
		if (session_status() === PHP_SESSION_NONE) {
			session_start() ;
		}	
			
			// Assignation
			$catchPage = "password" ;
			$emailInvalid = "E-mail invalide" ;
			$emailMember = "L'E-mail est absent dans la base de données" ;

			// Normalise la donnée du formulaire de $_POST[] (supprime les espaces)
			$email = isset($_POST['email']) ? trim($_POST['email']) : null ;
			// Vérifie une adresse e-mail avec filter_var()
			$email = filter_var($email, FILTER_VALIDATE_EMAIL) ;
				if (!$email) {
					// Affiche le message dans le journal de log Apache 	
					error_log($emailInvalid) ;
					// Un message en rouge pour signaler un e-mail invalide
					$_SESSION['error'] = "E-mail invalide" ;
					header("Location: index.php?page=" . $passwordPage) ;
					exit("Format de l'E-mail invalide") ;
				}
            
            try {
				/* On veut se connecter au SGBD MySQL avec le mode d'erreur sur 'PDO Exception' */
                $conn = new PDO("mysql:host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER'), getenv('DB_PASS')) ;
                
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;

				/* Le contexte vérifie des données d’un formulaire via l'existence de $_POST[] */
				if (isset($_POST['email'])) {

					/* Vérifie si l'utilisateur existe déjà */
									$sth = $conn->prepare($password) ;
									$sth->bindParam(':email' , $email) ;    
									$sth->execute() ;
									$resultat = $sth->fetch(PDO::FETCH_ASSOC) ;

									/* Traiement spécifique */
									if (isset($resultat['id'])) {																						
										// renvoie par email d'un mot de passe
									?>     
											<script>console.log('configuration du serveur SMTP');</script>										
									<?php
											// Configuration du serveur SMTP
											$mail->isSMTP();
											$mail->Host = $_ENV['SMTP_HOST']; // Remplacez par l'adresse de votre serveur SMTP
											$mail->SMTPAuth = true;
											$mail->Username = $_ENV['SMTP_CONTACT']; // L'email
											$mail->Password = $_ENV['SMTP_PASS']; // Le mot de passe smtp de l'application 'Mail' gmail 'myaccount.com/apppaswords'
											$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
											$mail->Port = 587;

											?>     
											<script>console.log('configuration de isSMTP');</script>											
											<?php
											
											// Destinataires
											$mail->setFrom($_ENV['SMTP_CONTACT'], 'Contact Cinephoria');
											$mail->addAddress($_ENV['SMTP_CONTACT'], $resultat['nom'] . '' . $resultat['prenom']); // Adresse du destinataire
											$mail->addReplyTo($_ENV['SMTP_CONTACT'], 'Contact Cinephoria');
											
											?>     
											<script>console.log('configuration des destinataires');</script>											
											<?php

											// Contenu de l'email
											$mail->isHTML(true);
											$mail->Subject = 'demande de mot de passe';
											$mail->Body    = 'Votre mot de passe est ' . $resultat['password'] . ' .';
											$mail->AltBody = 'Votre mot de passe est ' . $resultat['password'] . ' .';

											?>     
											<script>console.log('configuration du contenu de l\'email');</script>											
											<?php

											// Envoi de l'email
											$mail->send();
											// succès !
											echo 'L\'email a été envoyé avec succès';
																						
										// redirection
										header("Location: index.php?page=" . $confirmEmailPage) ;
										exit("Le mot de passe a bien été renvoyé") ;
										// END
									}
											else echo "Email n'a pas été trouvé";
										}
																																	
						/* Si l'email de l'utilisateur n'existe pas du tout */				
								else 
									{ 									
									// Affiche le message dans le journal de log Apache 	
										error_log($emailMember) ;
										// Un message en rouge pour signaler l'abscence dans la base
										$_SESSION['error'] = true ;													
										header("Location: index.php?page=" . $passwordPage) ;
										exit("L'E-mail est absent dans la base de données") ;
									}
								}									            
                        
            catch (PDOException $e) {	
					/* PDOException : attrape uniquement les erreurs de base de données (ici MySQL) */			
					ExceptionHandle($e, "Erreur PDO") ;
				} catch (Exception $e) {
					/* Exception : attrape Exception et ses sous-classes (ici PHP) */
					ExceptionHandle($e, "Exception PHP") ;
				} catch (Throwable $e) {
					/* Throwable : attrape tout (les erreurs fatales, les erreurs de type, d’appel de fonction inexistante, etc.) */
					ExceptionHandle($e, "Erreur Fatale") ;
				}
?>