<!-- password-controller.php -->
<?php // URL écrite en PHP
			session_start();
			
			$confirm_email_page = "confirmation-email";
			$password_page = "password";

            // on essaie de se connecter
            try{
                require 'vendor/autoload.php'; // Charge le driver MongoDB via Composer		
				// Connexion à MongoDB
    			$client = new MongoDB\Client("mongodb://{$_ENV['DB_USER']}:{$_ENV['DB_PASS']}@{$_ENV['DB_HOST']}/{$_ENV['DB_NAME']}");                
                // Sélection de la base de données
    			$db = $client->selectDatabase($_ENV['DB_NAME']);
				$collection = $db->membres;
				if(isset($_POST['email'])){
									$email = trim($_POST['email'] ?? '');
									$resultat = $collection->findOne(['email' => $email], ['projection' => ['_id' => 0, 'email' => 1]]);
									// cherche l'unicité d'un tel enregistrement 
									if(!empty($resultat['email'])){ // cas avec succès		
								   // écriture sur la console du navigateur 																																								
								   // traitement spécifique	avec renvoie par email d'un mot de passe ...
								   // Ici le code ?
								   // fin du traiement spécifique							
									header("Location: index.php?page=" . $confirm_email_page);
								exit;}								
								else { // retour sur la page : un message en rouge pour signaler l'abscence dans la base	
									$_SESSION['error'] = true;													
								header("Location: index.php?page=" . $password_page);
								exit;
									}
								}
				} 
							            
            
            /* On capture les exceptions si une exception est lancée et on affiche
             *les informations relatives à celle-ci */
            catch(Exception $e){
              echo "Erreur : " . $e->getMessage();
            }
        ?>