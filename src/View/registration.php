<!-- La Page d'UI registration.php : style K&R , indentation Ok -->
<?php 
		// Le code empêche une nouvelle session d’être appelée plusieurs fois
	  	if (session_status() === PHP_SESSION_NONE) {
    	    session_start();
		}
		// le visiteur est client par défaut
		if (!isset($_SESSION['role'])) {
            $_SESSION['role'] = 'client';
       	}
?>
<!-- DOCTYPE déclare du HTML → navigateur lit le HTML → DOM est créé → affichage navigateur correct -->
<!DOCTYPE html>
<!-- Le HTML DOM (Document Object Model) construit l'arbre d’objets avec chaque élément HTML manipulable par JavaScript -->
<html lang="fr">
	<!-- Head contient les dépendances d’une page HTML, pas le contenu affiché -->
  <head>
	<!-- On y inclu les metas essentielles d'indexation -->
	<?php include_once ROOT_PATH . $meta_path; ?>
	<!-- Notre fichier .env est situé à la racine du projet -->
    <title><?= $_ENV["APP_NAME"]; ?></title>
	<link href="<?= $css_path ?>" rel="stylesheet">
	<script src="js/form.js"></script> <!-- Fichier externe Javascript -->
  </head>
  <body>  			
	<?php			  
		// Le header et le menu-admin sont à inclure sur chaque page
			include_once ROOT_PATH . $header_path ;                   		  			
			include_once ROOT_PATH . $registrationForm_path ;

		// Inclu le menu admin si le visiteur est admin ou employé
        if (!$roleCustomer) {		  			
            include_once ROOT_PATH . $menu_admin_path ;
		}
	?>
<!-- Le bloc main contient des recommendations d'accessibilité et aide aide les lecteurs d’écran et les moteurs de recherche à comprendre où commence le contenu principal -->
<main>
	<!-- Méthode Oriéntée Objet --> 
	<?php

/* On créée les données de type/champ gérées par notre formulaire */

	// Labels pour chaque champ
	$labels = [
		'name'     => 'Nom',
		'surname'  => 'Prénom',
		'user'     => "Nom d'utilisateur",
		'password' => 'Mot de passe',
		'email'    => 'Email',
		'date'     => 'Date de naissance'
	];

	// Types pour chaque champ
	$field_types = [
		'name'     => 'text',
		'surname'  => 'text',
		'user'     => 'text',
		'password' => 'password',
		'email'    => 'email',
		'date'     => 'date'
	];

	// Motifs pour chaque champ (’ est l'apostrophe typographique)
	$field_pattern = [
		'name'     => "^[A-ZÀ-Öa-zà-öø-ÿ](?:[a-zà-öø-ÿ]|['’\-](?=[a-zà-öø-ÿ])| (?=[A-ZÀ-Ö])){1,19}$", // Lettre Majuscule et lettres minuscules (accents autorisés) ET/OU espaces , tirets , apostrophes non-consécutifs , le tout pouvant être répété (au total entre 2 et 20 caractères)
		'surname'  => "^[A-ZÀ-Öa-zà-öø-ÿ](?:[a-zà-öø-ÿ]|['’\-](?=[a-zà-öø-ÿ])| (?=[A-ZÀ-Ö])){1,19}$", // Motif idem
		'user'     => "^[A-ZÀ-Öa-zà-öø-ÿ](?:[a-zà-öø-ÿ]|['’\-](?=[a-zà-öø-ÿ])| (?=[A-ZÀ-Ö])){1,19}$", // Motif idem
		'password' => "^[A-Za-z\d]{5,20}$", // Motif de lettres et chiffres
		'email'    => "^(?=.{5,20}$)[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$",
		'date'     => ''
	];
	// Titres pour chaque champ
	$field_title = [
		'name'     => 'Entre 2 et 20 caractères',
		'surname'  => 'Entre 2 et 20 caractères',
		'user'     => 'Entre 2 et 20 caractères',
		'password' => '5 à 20 caractères, avec uniquement lettres et chiffres',
		'email'    => 'Veuillez saisir une adresse email valide (ex: nom@domaine.com)',
		'date'     => 'Veuillez saisir une date valide'
	];

	// Longueur min pour chaque type
	$field_min = [
		'text'     => 2,
		'password' => 5,
		'email'    => 5,
		'date'     => 8
	];

	// Longueur max pour chaque type
	$field_max = [
		'text'     => 20,
		'password' => 20,
		'email'    => 254,
		'date'     => 10
	];

		// Notre formulaire d'inscription (Orienté objet)
		$form = new RegistrationForm("index.php?page=" . $registrationController) ;

			// Liste des champs à gérer et méthode(s) appliquée(s)
			foreach ($labels as $key => $label) {
				// Liste des champs à gérer
				$type  = $field_types[$key] ?? 'text' ;
				$pattern = $field_pattern[$key] ;
				$title = $field_title[$key] ;
				$min = $field_min[$type] ;
				$max   = $field_max[$type] ?? 20 ;
				$value = $values[$key] ?? '' ;
				$placeholder = $label ;

				// méthode appliquée
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
</main>	
      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
		<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>

	<script>console.log("Cinéphoria : inscription");</script>	
  </body>
</html