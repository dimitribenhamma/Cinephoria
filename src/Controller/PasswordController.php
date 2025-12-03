<!-- PasswordController.php (gestion PHP + requêtes SQL) style K&R , indentation Ok -->
<?php
		// en-tête HTTP
		if (session_status() === PHP_SESSION_NONE) {
			session_start() ;
		}	
			
			// Assignation
			$catchPage = "password" ;
			$emailInvalid = "Email invalide" ;
			$emailMember = "L'e-mail est absent dans la base de données" ;

			// Normalise la donnée du formulaire de $_POST[] (supprime les espaces)
			$email = isset($_POST['email']) ? trim($_POST['email']) : null ;
			// Vérifie une adresse e-mail avec filter_var()
			$email = filter_var($email, FILTER_VALIDATE_EMAIL) ;
				if (!$email) {
					// Affiche le message dans le journal de log Apache 	
					error_log($emailInvalid) ;
					// Un message en rouge pour signaler un e-mail invalide
					$_SESSION['error'] = "Email invalide" ;
					header("Location: index.php?page=" . $passwordPage) ;
					exit("Format de l'e-mail invalide") ;
				}
            
            try {
				/* On veut se connecter au SGBD MySQL avec le mode d'erreur sur 'PDO Exception' */
                $conn = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']) ;
                
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;

				/* Le contexte vérifie des données d’un formulaire via l'existence de $_POST[] */
				if (isset($_POST['email'])) {

					/* Vérifie si l'utilisateur existe déjà */
									$sth = $conn->prepare($password) ;
									$sth->bindParam(':email' , $email) ;    
									$sth->execute() ;
									$resultat = $sth->fetch(PDO::FETCH_ASSOC) ;

									/* Traiement spécifique */
									if (isset($resultat['email'])) {	
											// succès !

											
											// renvoie par email d'un mot de passe
											// le code ?
											// END

										header("Location: index.php?page=" . $confirmEmailPage) ;
										exit("Le mot de passe a bien été renvoyé") ;
									}	
														
						/* Si l'email de l'utilisateur n'existe pas du tout */				
								else 
									{ 									
									// Affiche le message dans le journal de log Apache 	
										error_log($emailMember) ;
										// Un message en rouge pour signaler l'abscence dans la base
										$_SESSION['error'] = true ;													
										header("Location: index.php?page=" . $passwordPage) ;
										exit("L'e-mail est absent dans la base de données") ;
									}
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