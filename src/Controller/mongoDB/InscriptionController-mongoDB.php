<?php 
		if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	if (!isset($_SESSION['role'])) {
		$_SESSION['role'] = 'client';
	}	
		
		$ip_path = '/src/View/components/IP.php';
		$email = isset($_POST['email']) ? trim($_POST['email']) : null;
		
		include_once ROOT_PATH . $ip_path;

		

		// Définit nos variables messages clairs pour la gestion des erreurs/succès 
		$member = "Erreur Inscription $email : les données correspondent déjà à un membre ! IP : " . getUserIP() ;
		$form = "Erreur Inscription $email : erreur dans le formulaire. IP : " . getUserIP() ;

		$success_page = "confirmation-inscription";
		$error_MemberPage = "inscription";
		$error_FormPage = "inscription";

		$catch_message = "Erreur levée $email : Problème ";
		$catch_page = "inscription";
		
		try {		
				require 'vendor/autoload.php'; // Charge le driver MongoDB via Composer		
				// Connexion à MongoDB
    			$client = new MongoDB\Client("mongodb://{$_ENV['DB_USER']}:{$_ENV['DB_PASS']}@{$_ENV['DB_HOST']}/{$_ENV['DB_NAME']}");                
                // Sélection de la base de données
    			$db = $client->selectDatabase($_ENV['DB_NAME']);
				$collection = $db->membres;
				/* Attention, si le formulaire a été soumis (et si les champs existent non nuls), alors on aura un cas vrai */
						/* ne pas faire ceci : 
						if (isset($name) && isset($surname) && isset($user) 
							&& isset($password) && isset($email) && isset($date)) { */
						if (isset($_POST['name'],$_POST['surname'],$_POST['user'],$_POST['password'],$_POST['email'],$_POST['date']) && !empty($_POST['email']) && !empty($_POST['password'])) {
								// Vérifier si l'utilisateur existe déjà													
													$name = isset($_POST['name']) ? trim($_POST['name']) : null;
													$surname = isset($_POST['surname']) ? trim($_POST['surname']) : null;
													$user = isset($_POST['user']) ? trim($_POST['user']) : null;
													$password = isset($_POST['password']) ? trim($_POST['password']) : null;													
													$date = !empty($_POST['date']) ? date('Y-m-d', strtotime($_POST['date'])) : null;

								// Vérifie si le email existe déjà
        						$resultat = $collection->findOne(['email' => $email],['projection' => ['_id' => 1]]); // on récupère juste l'id MongoDB        								
							
								/* Attention, ne pas écrire sans quoi erreur de logique
									if(!isset($resultat['id'])) { */
										// Utilisateur non dans la base de donnée
								if (!$resultat) {		
										$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
										/* l'algorithme BCRYPT (hachage + salt) contient un mot de passe codé sur 60 octets */
											
										// Insertion d’un nouveau membre
										$insertResult = $collection->insertOne([
											'nom' => $name,
											'prenom' => $surname,
											'user' => $user,
											'password' => $hashedPassword,
											'email' => $email,
											'date' => $date,
											'role' => 'client'
										]);
				
										// Enregistrer les donnees de sessions
										 $_SESSION['user'] = $user;
           								 $_SESSION['role'] = 'client';
										header("Location: index.php?page=$success_page");
										exit;										
									}
										// Utilisateur déjà dans la base de donnée
									else {
									// Affiche ce message dans le journal de log Apache	
									error_log($member);									
									header("Location: index.php?page=$error_MemberPage");
									exit;}
						}
						else {						    
							$_SESSION['old_name'] = $_POST['name'] ?? '';
							$_SESSION['old_surname'] = $_POST['surname'] ?? '';
							$_SESSION['old_user'] = $_POST['user'] ?? '';
							// Ne pas stocker en clair la ligne ci-dessous :
							// $_SESSION['old_password'] = $_POST['password'] ?? '';
							$_SESSION['old_email'] = $_POST['email'] ?? '';
							$_SESSION['old_date'] = $_POST['date'] ?? '';
							error_log($form);
							header("Location: index.php?page=$error_FormPage");
							exit;
						}
			}
			
			// Bloc try/catch
			catch (Throwable $e){
				// lancera l'exception
				error_log($catch_message . $e->getMessage());
				header("Location: index.php?page=$catch_page");
			}												
?>