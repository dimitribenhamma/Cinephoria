<!-- La page d'UI du site manage-products.php (ajout,modifications ...) : Style K&R , indentation Ok -->
<?php
// admin@gmail.com
	  if (session_status() === PHP_SESSION_NONE) {
    	  session_start() ;} 	

	  /* Fichier à inclure */  
	  include_once ROOT_PATH . $filmForm_path ;

?>
<!DOCTYPE html>
<html lang="fr"> 			  
	<head>
		<?php
		/* On y inclus les fichiers meta essentiels */
			include_once ROOT_PATH . $meta_path ;
		?>
			<title><?= $_ENV["APP_NAME"]; ?></title>	
			<style>
				/* Style commun moderne */
				input[type="file"]::file-selector-button {
					background-color: orange ;
					color: white ;
					border: none ;
					padding: 6px 12px ;					
					cursor: pointer ;
					font-weight: bold ;
					font-size:15px ;
					margin-left:5px ;
				  }

				input[type="file"]::file-selector-button:hover {
					background-color: darkorange ;
				  }
			</style>
	</head>
<body> 	
	<?php	
		/* Fichiers à inclure */

			// Obtenir les infos sur des films
			include_once ROOT_PATH . $moviesData_path ;
			// Le header et le menu admin sur chaque page
			include_once ROOT_PATH . $header_path ;
			include_once ROOT_PATH . $menuAdmin_path ;

		
		// Vérifier si l'utilisateur est employé ou administrateur
        if(($_SESSION['role'] == "employe") || ($_SESSION['role'] == "admin")) {	

			// Si on est mercredi, afficher le formulaire uniquement le mercredi (3)
			if ($current_day !== 3) {

					if (isset($_SESSION['ErrorForm'])) {
						echo $_SESSION['ErrorForm'] ;	
						echo $_SESSION['console'] ;					
					  }
	?>
			<!-- Les films ajoutés par les employés ou l'administrateur -->

				<div style="background-color:rgb(245,245,245);">
					<p style="margin-left:20px;font-weight:bold;font-size:20px;"><?= $titleManageProducts ; ?></p>
					<form style="margin-left:20px;" method="POST" id="FilmsForm">										
						<select name="films" onchange="document.getElementById('FilmsForm').submit();">
							<option value="choisir" selected><?= $option ?></option>
							<?php
								// On parcourt la liste des films du DataFile 
								foreach($films as $film) 
								{	
									// Garder le film courant séléctionné				
									$selected = ($_POST['films'] == $film['id']) ? 'selected' : '' ; 
									// Répertorier des titres de films dans un menu déroulant
									echo "<option value=" . $film['id'] . " $selected>" . htmlspecialchars($film['titre']) . "</option>" ;
								} ?>
						</select>					
					</form>		

				<?php

				/* Le titre du film courant doit être transmis au second formulaire */

					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					
						$id = (isset($_POST['films']) && (is_numeric($_POST['films']))) ? (int)$_POST['films']: null ;}	
											
					if (isset($id)) {												
						$_SESSION['id'] = $id ; }
				
				?>

				<p style="margin-left:20px;margin-top:20px;font-weight:bold;font-size:20px;"><?= $titleManageList ; ?></p>

				<?php
						$form = new FilmForm("$actionPage.php") ;

						// Texte (trim nettoye)
						$id = isset($_POST['films']) && (is_numeric($_POST['films'])) ? ($_POST['films'] - 1) : null ;
						$title = ($id !== null && isset($films[$id])) ? htmlspecialchars(trim($films[$id]['titre'])) : '' ;
						$author = ($id !== null && isset($films[$id])) ? htmlspecialchars(trim($films[$id]['auteur'])) : '' ;
						$releaseDate = ($id !== null && isset($films[$id])) ? ($films[$id]['date_de_sortie']) : '' ; /* Exemple : Jeudi 7 août 2025 */
						$duration = ($id !== null && isset($films[$id])) ? htmlspecialchars(trim($films[$id]['duree'])) : '' ; /* Exemple : 1:23 */
						$description = ($id !== null && isset($films[$id])) ? htmlspecialchars(trim($films[$id]['description'])) : '' ;
						$image = ($id !== null && isset($films[$id])) ? ($films[$id]['pochette']) : '' ;
						// Radios
						$version = ($id !== null && isset($films[$id])) ? htmlspecialchars(trim($films[$id]['version'])) : '' ; /* vo ou bien vfstr */
						$forbidden = ($id !== null && isset($films[$id])) ? htmlspecialchars(trim($films[$id]['interdit'])) : '' ; /* pour l'âge légal */												
						// Le(s) genre(s) du film
						$type = ($id !== null && isset($films[$id])) ? htmlspecialchars(trim($films[$id]['genre'])) : '' ;
						// Convertir en tableau
						$versionArray = array_map('trim', explode(',', $version)) ;
						$forbiddenArray = array_map('trim', explode(',', $forbidden)) ;
						$typeArray = array_map('trim', explode(',', $type)) ;
										
						// Les champs de saisie
						$form->addField(new FormField('titre', 'text', "^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s',.!?\-]+$", $title ?? '', 1, 25, $labelTitle, '', 'width:345px;height:35px;', 'margin-left:20px;','','','on')) ;
						echo '<br><br>';
						$form->addField(new FormField('auteur', 'text', "^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s',.!?\-]+$", $author ?? '', 1, 25, $labelAuthor, '', 'width:330px;height:35px;',"width:200px;margin-left:20px;",'','','on')) ;
						echo '<br><br>';
						$form->addField(new FormField('movie_release_date', 'date', "^\d{4}-\d{2}-\d{2}$", $releaseDate ?? '', 1, 25, $labelReleaseDate, '', 'width:285px;height:35px;',"width:200px;margin-left:20px;",'','','on')) ;
						echo '<br><br>';
						$form->addField(new FormField('duree', 'text', "^([0-9]{1})h([0-5]?[0-9])$", $duration ?? '', 1, 4, $labelDuration, $placeholderDuration, 'width:223px;height:35px;',"width:100px;margin-left:20px;",'','','on')) ;
						
						// Affichage final du formulaire
						echo $form->render() ;
						?>

						
						
							
							
			<?php 
				} 
			else {
				echo "<div style='color:red;margin-left:50px;padding-bottom:20px;'>$wednesday</div>" ;
			} 
			?>
		</div> 
			<?php 
			}
				include_once ROOT_PATH . $movies_path ; 
		?>

		<!-- Partie php pied de page -->
		<div class="under">
			<?php 
				include_once ROOT_PATH . $bottom_path ; 
			?>
		</div>

	<script>
		/* Début Javascript */
    		
		const imgApercu = document.getElementById('preview') ;
		const inputFile = document.getElementById('imageUpload') ;
		const bouton = document.getElementById('monBouton') ;
	    const boutonEffacer = document.getElementById('effacer') ;
		const monFormulaire = document.getElementById('monForm') ;
    
	function afficherApercu(event) {
		const fichier = event.target.files[0] ; /* Première, et unique image */
      if (!fichier) {
        imgApercu.style.display = 'none' ;
        imgApercu.src = '' ;
		bouton.style.display = 'none' ;
		return ;
      }
	  else {
      const lecteur = new FileReader() ; // Pour lire l'image en preview
      lecteur.onload = function (e) {		
        imgApercu.src = e.target.result ;		
        imgApercu.style.display = 'block' ;
		bouton.style.display = 'inline' ;
      } ;
      lecteur.readAsDataURL(fichier) ;      
	}
	};

	// Réinitialiser tout le formulaire
	boutonEffacer.addEventListener('click', function () {
		inputFile.value = "" ;         // Réinitialise l'input file
		imgApercu.src = "" ;           // Effacer l'image
		imgApercu.style.width = "" ;   // Styles personnalisés à 0
		imgApercu.style.height = "";
		bouton.style.display = 'none' ;	

		monFormulaire.querySelectorAll('input[type="text"], textarea').forEach(el => {
    	el.value = '' ;
  		});	
		
		monFormulaire.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(el => el.checked = false) ;
});


	// Pour prévisualiser l'image (file) à partir d'un évenement
	inputFile.addEventListener('change', afficherApercu) ;

	console.log("Cinéphoria : Gérer les produits") ;
	</script>
	</body>
</html>