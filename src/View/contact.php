<!-- La page UI contact.php du site : style K&R , indentation Ok -->
<!DOCTYPE html>				
<html lang="fr">
	<head>
			<!-- On y inclu les metas essentielles -->
			<?php 
				include_once ROOT_PATH . $meta_path ;
			?>

			<title><?= $_ENV["APP_NAME"] ; ?></title>

	</head>
<body> 
		<?php
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;
			  include_once ROOT_PATH . $contactForm_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}		
		?>
				
		<div>
			<!-- Code PHP pour afficher le formulaire de contact -->
			<?php
				// Notre formulaire de contact (Orienté objet)
					$form = new ContactForm("index.php?page=" . $confirmContactPage) ;

						// Labels pour chaque champ
					$labels = [
						'name'     => 'Votre nom :',
						'surname'  => 'Votre Prénom :',					
						'email'    => 'Votre Email :',
						'description'     => 'Description :'
					];
					
						// Types pour chaque champ
					$field_types = [
						'name'     => 'text',
						'surname'  => 'text',
						'email'    => 'email',
						'description'     => ''
					];

						// Titres pour chaque champ
					$field_title = [
						'name'     => 'Veuillez entrer un nom valide',
						'surname'  => 'Veuillez entrer un prénom valide',
						'email'    => 'Veuillez saisir une adresse email valide (ex: nom@domaine.com)',
						'description'     => 'Veuillez saisir un texte valide'
					];

						// Valeurs pour chaque champ
					$field_value = [
						'name'     => '',
						'surname'  => '',
						'email'    => '',
						'description'     => ''
					];

						// Le motif pour chaque champs
					$field_pattern = [
						'name'     => '',
						'surname'  => '',
						'email'    => "^(?=.{5,20}$)[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$",
						'description'     => ''
					];

						// Longueur min pour chaque type
					$field_min = [
						'text'     => 2,
						'email'    => 5
					];

						// Longueur max pour chaque type
					$field_max = [
						'text'     => 20,
						'email'    => 40
					];
					
						/* Liste des champs à gérer et méthode(s) appliquée(s) */

					foreach ($labels as $key => $label) {
							// Liste des champs à gérer
							$type  = $field_types[$key] ?? '' ;
							$pattern = $field_pattern[$key] ?? '' ;
							$title = $field_title[$key] ?? '' ;
							$min = $field_min[$type] ?? 0 ;
							$max   = $field_max[$type] ?? 255 ;
							$value = $field_value[$key] ?? '' ;
							$placeholder = $label ?? '' ;


							// Méthode appliquée
						$form->addField(new FormField(
							$key,
							$type,
							$pattern,
							$title,
							$min,
							$max,		
							$label,
							"display:flex;font-size:24px;font-weight:bold;align-items:center;text-align:center;margin:auto;",
							"margin-top:10px;width:200px;height:35px;",    
							$value,
							$placeholder,
							"on",
							true
						)) ;
					}


					// Afficher le formulaire
					echo $form->render() ;
					
			?>
		</div>

		    <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
			<!-- Partie php du bandeau noir persistant -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>

			<script>console.log("Cinéphoria : Nous Contacter") ;</script>
  </body>
</html>