<!-- Page d'UI login.php (texte pur HTML & PHP dynamique) style K&R , indentation Ok -->
<!DOCTYPE html> 
<html lang="fr">
  <head>
        <?php 
            /* On y inclu les metas essentielles d'indexation */
            include_once ROOT_PATH . $meta_path; 
        ?>            
        <!-- Notre fichier .env est situé à la racine du projet -->
        <title><?= $_ENV["APP_NAME"]; ?></title>    
        <script src="js/form.js"></script> <!-- Fichier externe Javascript -->
  </head>
  <body>		
			<?php	
                    
		  	  /* Les scripts de classes LoginForm et FormField nécéssaires */
              include_once ROOT_PATH . $formLogin_path;
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
              
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}	
			?>

<main>
            <!-- On y applique nos classes -->
            <?php
                // Assignation de motifs (patterns) qui décrit le modèle d'une chaîne de caractères pour une donnée vraiment renseignée
                $emailPattern = "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" ;
                $passwordPattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,20}$" ;

                    // Créée le formulaire
                    $form = new LoginForm('index.php?page=' . $actionLoginPage);
                    $form->addField(new FormField('email', 'email', $emailPattern, "Veuillez saisir une adresse email valide (ex: nom@domaine.com)", 8, 20, "Email", "font-size:20px;font-weight:bold;", "margin-top:10px;width:200px;height:35px;", '',"Email", "on"));
                    $form->addField(new FormField('password', 'password', $passwordPattern, "8 à 20 caractères, avec au moins une majuscule, une minuscule et un chiffre", 8, 20, 'Mot de passe', "font-size:20px;font-weight:bold;", "margin-top:10px;width:200px;height:35px;", '','Mot de passe', "off"));

                    // Affiche le formulaire
                    echo $form->render();
                ?>                    
</main>

      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
		<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>

	<script>console.log("Cinéphoria : connexion");</script>    
</body>
</html>