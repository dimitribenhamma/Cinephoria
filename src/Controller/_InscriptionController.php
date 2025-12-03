<!-- InscriptionController.php : style K&R , indentation Ok -->
<?php 
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if (!isset($_SESSION['role'])) {
			$_SESSION['role'] = 'client';
		}	
		
		// Fichiers "include"
		include_once ROOT_PATH . $ip_path;
		include_once ROOT_PATH . $exception_handle_path;
		
		// Normalise la donnée (supprime les espaces)
		$name = isset($_POST['name']) ? trim($_POST['name']) : null;
		$surname = isset($_POST['surname']) ? trim($_POST['surname']) : null;
		$user = isset($_POST['user']) ? trim($_POST['user']) : null;
		$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
		$password = isset($_POST['password']) ? trim($_POST['password']) : null;													
		$date = isset($_POST['date']) ? trim($_POST['date']) : null;
	
		$catchPage = 'inscription';

		// Messages clairs pour la gestion des erreurs/succès
		$emailMember = "[Inscription] L'e-mail d'inscription appartient déjà à un membre ! (IP : " . getUserIP() . " ; e-mail : $email)";
		$formIncomplete = "[Inscription] Le formulaire est incomplet ! (IP : " . getUserIP()  . " ; e-mail : $email)" ;				


		try {	

			/* Attention aux erreurs de logique */

				/* On veut se connecter au SGBD MySQL avec le mode d'erreur sur 'PDO Exception' */			
				$conn = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS'],[PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);                

				/* Le contexte vérifie des données d’un formulaire via l'existence de $_POST */
					if (isset($_POST['name'],$_POST['surname'],$_POST['user'],$_POST['password'],$_POST['email'],$_POST['date']) && !empty($_POST['email']) && !empty($_POST['password'])) {
				
						/* Vérifie si l'utilisateur existe déjà */																			
								$sth = $conn->prepare("SELECT id FROM `membres` WHERE user = :user OR email = :email");
								$sth->execute([':user' => $user, ':email' => $email]);
								$resultat = $sth->fetch(PDO::FETCH_ASSOC);
								$date = date('Y-m-d', strtotime($date));
																								
							/* Si l'utilisateur n'existe pas encore */	
								if ($resultat === false) {		
									/* Le mot de passe est crypté par l'algorithme BCRYPT (60 octets) */
										$hashedPassword = password_hash($password, PASSWORD_BCRYPT);										
										
										// → Sécurité contre injections SQL : on traite comme du texte les données $_POST 
										$st = $conn->prepare("INSERT INTO `membres` (nom, prenom, user, password, email, date, role)
										VALUES (:name, :surname, :user, :password, :email, :date, :role)");
												// On veut l'enregistrer en base de données
											$st->execute([
												':name' => $name,
												':surname' => $surname,
												':user' => $user,
												':password' => $hashedPassword,
												':email' => $email,
												':date' => $date,
												':role' => 'client'
											]);
				
										// → Session : enregistre les données 
										 $_SESSION['user'] = $user;
           								 $_SESSION['role'] = 'client';
										 $_SESSION['errorRegistration'] = false;
										 unset($_SESSION['errorRegistration']);
										 
										// Succès !
										header("Location: index.php?page=$successPage");
										exit("Vous êtes redirigés vers la page suivante");										
									}

							/* Si l'Utilisateur existe déjà dans la base de données */
									else 
										{
										// → Affiche le message dans le journal de log Apache	
											error_log($emailMember);
											$_SESSION['errorRegistration'] = true;									
											header("Location: index.php?page=$errorMemberPage");
											exit("L'e-mail d'inscription appartient déjà à un membre !");
										}
								}
							else 
								{						    									
									error_log($formIncomplete);
									$_SESSION['errorRegistration'] = true;
									header("Location: index.php?page=$errorFormPage");
									exit("Le formulaire est incomplet !");
								}
				}	

				catch (PDOException $e) {	
					/* PDOException : attrape uniquement les erreurs de base de données (ici MySQL) */			
					ExceptionHandle($e, "Erreur PDO");					
				} catch (Exception $e) {
					/* Exception : attrape Exception et ses sous-classes (ici PHP) */
					ExceptionHandle($e, "Exception PHP");
				} catch (Throwable $e) {
					/* Throwable : attrape tout (les erreurs fatales, les erreurs de type, d’appel de fonction inexistante, etc.) */
					ExceptionHandle($e, "Erreur Fatale");
				}

?>