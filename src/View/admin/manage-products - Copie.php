<!-- Style K&R , indentation Ok -->
<!-- Code pour la gestion des films (ajout,modifications ...) -->

<?php
	
	  if (session_status() === PHP_SESSION_NONE) {
    	  session_start();} 	

	  include_once ROOT_PATH . $filmForm_path;

		  $current_day = (int)date('w'); // 0 (dimanche) à 6 (samedi) avant l'affichage HTML			
		  $allGenres = ['Action','Animation','Aventure','Biopic','Comédie','Documentaire','Drame','Famille','Fantastique','Historique','Horreur','Musical','Policier','Romance','Science-Fiction','Thriller','Western'];
		  $allAges = ['tout public','-10 ans', '-12 ans', '-14 ans', '-16 ans', '-18 ans'];
		  $allVersions = ['VO','VOST', 'VF','VSTFR'];

		  $title1 = "Liste des films";
		  $title2 = isset($id) ? "Modifier un film" : "Ajouter un film";
		  $option = "Choisir le Film à modifier";
		  
		  $subtitle_author = "Auteur :";
		  $subtitle_release_date = "Date de sortie :";
		  $subtitle_duration = "Durée (Heure:Minutes) :";
		  $subtitle_description = "Description :";
		  $subtitle_type = "Genre(s) :";
		  $subtitle_version = "Version :";
		  $subtitle_forbidden = "Interdit (âge légal) :";
		  $subtitle_reset = "Effacer le formulaire";
		  $subtitle_delete = "Effacer l’image";
		  $subtitle_image = "Image :";

		  $action_page = "manage-products-handler.php";


?>

<!DOCTYPE html>				
<html lang="fr"> 			  
	<head>
			<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title><?= $_ENV["APP_NAME"]; ?></title>	
			<style>
				 /* Style commun moderne */
				input[type="file"]::file-selector-button {
					background-color: orange;
					color: white;
					border: none;
					padding: 6px 12px;					
					cursor: pointer;
					font-weight: bold;
					font-size:15px;
					margin-left:5px;
				}

				input[type="file"]::file-selector-button:hover {
					background-color: darkorange;
				}
			</style>
	</head>
<body> 	
	<?php		    	  		
		include_once ROOT_PATH . $movies_data_path; // File des infos sur les films
		include_once ROOT_PATH . $header_path; // notre top logo + menu + boutons					  			
		include_once ROOT_PATH . $menu_admin_path; // notre menu administrateur
	?>	

		<?php 
		// Vérification si l'utilisateur est employé ou administrateur
        if(($_SESSION['role'] == "employe") || ($_SESSION['role'] == "admin")){	
    
		if ($current_day == 3){
    		// Afficher le formulaire uniquement le mercredi (3)
				if(isset($_SESSION['message'])){
					echo $_SESSION['message'];	
					echo $_SESSION['console'];					
				}
		//  Les films ajoutés par les employés ou l'administrateur ?>
			<div style="background-color:rgb(245,245,245);">
				<p style="margin-left:20px;font-weight:bold;font-size:20px;"><?= $title1 ?></p>
				<form style="margin-left:20px;" method="POST" id="FilmsForm">										
					<select name="films" onchange="document.getElementById('FilmsForm').submit();">
						<option value="choisir" selected><?= $option ?></option>
					<?php foreach($films as $film) // On parcourt la liste des films localisés dans un tableau 2d
						{						
						$selected = ($_POST['films'] == $film['id']) ? 'selected' : '';  // On affiche le menu déroulant avec des titres de films
  						echo "<option value=" . $film['id'] . " $selected>" . htmlspecialchars($film['titre']) . "</option>";
						} ?>
					</select>					
				</form>		

			<!-- Bouton modifier suite à une erreur de création de film -->			
			<?php // La variable $_POST['films'] est définie dans le premier formulaire et doit être transmise au second
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				
    				$id = (isset($_POST['films']) && (is_numeric($_POST['films']))) ? (int)$_POST['films']: null;}	
										
				if (isset($id)) {												
				$_SESSION['id'] = $id; } ?>

				<p style="margin-left:20px;margin-top:20px;font-weight:bold;font-size:20px;"><?= $title2 ?></p>
					<form id="monForm" style="margin-left:20px;" action="<?= $action_page ?>" method="POST" enctype="multipart/form-data">									
					<?php 
					/* champs texte */					
					$id = isset($_POST['films']) && (is_numeric($_POST['films'])) ? ($_POST['films'] - 1) : null;
					$titre = ($id !== null && isset($films[$id])) ? htmlspecialchars($films[$id]['titre']) : '';
					$auteur = ($id !== null && isset($films[$id])) ? htmlspecialchars($films[$id]['auteur']) : '';
					$movie_release_date = ($id !== null && isset($films[$id])) ? ($films[$id]['date_de_sortie']) : ''; /* Exemple : Jeudi 7 août 2025 */
					$duree = ($id !== null && isset($films[$id])) ? htmlspecialchars($films[$id]['duree']) : ''; /* Exemple : 1:23 */
					$description = ($id !== null && isset($films[$id])) ? htmlspecialchars($films[$id]['description']) : '';
					$pochette = ($id !== null && isset($films[$id])) ? ($films[$id]['pochette']) : '';
					/* radios */
					$version = ($id !== null && isset($films[$id])) ? htmlspecialchars($films[$id]['version']) : ''; /* vo ou bien vfstr */
					$forbidden = ($id !== null && isset($films[$id])) ? htmlspecialchars($films[$id]['interdit']) : ''; /* pour l'âge légal */												
					// Le(s) genre(s) du film
					$type = ($id !== null && isset($films[$id])) ? htmlspecialchars($films[$id]['genre']) : '';
		  			// Convertir en tableau
					$versionArray = array_map('trim', explode(',', $version));
					$forbiddenArray = array_map('trim', explode(',', $forbidden));
		  			$typeArray = array_map('trim', explode(',', $type));
					
					?>
					<!-- champs texte -->	
					<span style="margin-left:20px;"><label style="font-weight:bold" for="titre">Titre :</label>
					
					<!-- On prérempli les cases input si on veut modifier suite à une erreur (PHP) -->	
					<input style="width:345px;" type="text" id="titre" name="titre" autocomplete="on" value="<?= $titre ?>" required></span><br><br>

					<span style="width:200px;margin-left:20px;"><label style="font-weight:bold" for="auteur"><?= $subtitle_author ?></label>
					<input style="width:330px;" type="text" id="auteur" name="auteur" autocomplete="on" value="<?= $auteur ?>" required></span><br><br>

					<span style="width:200px;margin-left:20px;"><label style="font-weight:bold" for="movie_release_date"><?= $subtitle_release_date ?></label>
					<input style="width:285px;" type="date" id="movie_release_date" name="movie_release_date" autocomplete="on" placeholder="<?= $movie_release_date ?>" required></span><br><br>					

					<span style="width:100px;margin-left:20px;"><label style="font-weight:bold" for="duree"><?= $subtitle_duration ?></label>
					<input style="width:223px;" type="text" id="duree" name="duree" autocomplete="on" value="<?= $duree ?>" pattern="^([0-9]{1})h([0-5]?[0-9])$" placeholder="Exemple: 1h03" required></span><br><br>									

					<span style="width:100px;margin-left:20px;"><label style="font-weight:bold" for="description"><?= $subtitle_description ?></label>
					<textarea id="description" rows="6" style="width:300px;height:150px;white-space: pre-wrap;" name="description" required><?= $description ?></textarea></span><br><br>
					
					<!-- checkboxes -->
					<div style="display:flex; flex-wrap:wrap; gap:10px; margin-left:20px; max-width:100%;">
    				<span style="width:100%;font-weight:bold"><?= $subtitle_type ?></span>
					<?php foreach($allGenres as $genre): ?>
					<?php $checked = in_array($genre, $typeArray) ? 'checked' : ''; ?>
					<label id="<?= htmlspecialchars($genre) ?>" style="margin-right:10px;"></label>
						<input type="checkbox" name="genre[]" value="<?= htmlspecialchars($genre) ?>" <?= $checked ?>>
						<?= htmlspecialchars($genre) ?>
					<?php endforeach; ?>
					</div><br><br>
					
					<!-- radios -->
					<div style="display:flex; flex-wrap:wrap; gap:10px; margin-left:20px; max-width:100%;">
    				<span style="width:100%;font-weight:bold"><?= $subtitle_version; ?></span>
					<?php foreach($allVersions as $version): ?>
					<?php $checked = in_array($version, $versionArray) ? 'checked' : ''; ?>
					<label id="<?= htmlspecialchars($version) ?>" style="margin-right:10px;"></label>
						<input type="radio" name="version[]" value="<?= htmlspecialchars($version) ?>" <?= $checked ?>>
						<?= htmlspecialchars($version) ?>					
					<?php endforeach; ?>
					</div><br><br>

		<div style="display:flex; flex-direction:column; gap:5px; margin-left:20px; max-width:100%;">
			<span style="font-weight:bold"><?= $subtitle_forbidden; ?></span>
			<?php foreach($allAges as $ages): ?>
				<?php $checked = in_array($ages, $forbiddenArray) ? 'checked' : ''; ?>
				<label id="<?= htmlspecialchars($ages) ?>"></label>
					<input type="radio" name="age" value="<?= htmlspecialchars($ages) ?>" <?= $checked ?>>
					<?= htmlspecialchars($ages) ?>				
			<?php endforeach; ?>
		</div></br></br>

					
				
					<!-- Img upload -->
						<span style="margin-left:20px;font-weight:bold"><?= $subtitle_image ?></span><img style="margin-left:20px" id="preview" alt="Aucune pochette (Image)" name="img" src="<?= $pochette ?>" onerror="this.src='img/uploads/fallback.jpg'; this.onerror=null;" width="250px" height="300px"><br><br>
						<span style="width:100px;margin-left:20px;">
						<button id="monBouton" style="font-weight:bold;background-color:black;color:white;padding:5px;"><?= $subtitle_delete ?></button>	<!-- masque la preview -->	
						<input type="file" id="imageUpload" name="pochette" accept="image/*" <?= $id === null ? 'required' : '' ?>></span>
						<button id="effacer" style="font-weight:bold;background-color:black;color:white;padding:5px;margin-left:25px;"><?= $subtitle_reset ?></button><br>							
						<br><br>
					<div>		
						<input style="margin-left:20px;margin-bottom:30px;background-color:red;color:white;padding:5px" type="submit" value="<?= (isset($id)) ? "Modifier le film" : "Ajouter le film" ?>">
					</div>
				</form>		
						
    	<?php } else {echo "<div style='color:red;margin-left:50px;padding-bottom:20px;'>Le formulaire n'est accessible que le mercredi.</div>";} ?>
		</div> 
		<?php }

		include_once ROOT_PATH . $movies_path ?>

		<!-- Partie php pied de page -->
		<div class="under"><?php include_once ROOT_PATH . $bottom_path; ?></div>
								


	<script>
		/* Début Javascript */
    		
		const imgApercu = document.getElementById('preview');
		const inputFile = document.getElementById('imageUpload');
		const bouton = document.getElementById('monBouton');
	    const boutonEffacer = document.getElementById('effacer');
		const monFormulaire = document.getElementById('monForm');
    
	function afficherApercu(event) {
		const fichier = event.target.files[0]; /* première, unique image */
      if (!fichier) {
        imgApercu.style.display = 'none';
        imgApercu.src = '';
		bouton.style.display = 'none';
		return;
      }
	  else {
      const lecteur = new FileReader(); // utilisé pour lire et voir l'image en preview
      lecteur.onload = function (e) {		
        imgApercu.src = e.target.result;		
        imgApercu.style.display = 'block';
		bouton.style.display = 'inline';
      };
      lecteur.readAsDataURL(fichier);
      
	}
	};

	// Réinitialiser tout le formulaire
	boutonEffacer.addEventListener('click', function () {
		inputFile.value = "";       // Réinitialise l'input file
		imgApercu.src = "";        // Efface l'image
		imgApercu.style.width = "";  // styles personnalisés réinitialisés à 0
		imgApercu.style.height = "";
		bouton.style.display = 'none';	

		monFormulaire.querySelectorAll('input[type="text"], textarea').forEach(el => {
    	el.value = '';
  		});	
		
		monFormulaire.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(el => el.checked = false);
});

	// Pour vider le formulaire complètement, pas aux valeurs d’origine du HTML
	// en ciblant tous les champs


	// on veux prévisualiser une image et donc utiliser, sur le bouton file, l'événement change 
	inputFile.addEventListener('change', afficherApercu);

	console.log("Cinéphoria : Gérer les produits");
	</script>
	</body>
</html>