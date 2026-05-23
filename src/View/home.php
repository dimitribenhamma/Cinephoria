<!-- La page d'accueil home.php : Style K&R , indentation Ok -->
<?php
				// Ce code initialise une session unique et empêche d'être appelée plusieurs fois
			if (session_status() === PHP_SESSION_NONE) {
				session_start() ;
			  }

			  
	if (!defined('ROOT_PATH')) { echo 'Accès direct interdit 🚫';  die('Accès direct interdit 🚫');}

			/* variables */			
			$paths_path = '/config/paths.php' ;
					
			/* Fichiers à inclure */			
			include_once ROOT_PATH . $paths_path ;
			include_once ROOT_PATH . $app_path ;	



		include_once ROOT_PATH . $meta_path;
	
?>
<!DOCTYPE html>
<html lang="fr">
	<head>		
			<title><?= getenv("APP_NAME") ; ?></title>
	</head>
	<body> 	
<!-- Partie Javascript -->		
		<script>
		window.addEventListener('load', () => {
		    const splash = document.getElementById('splash');
		    const cookieBanner = document.getElementById('cookie-banner');

		    // Vérifie si le splash a déjà été vu
		    if (sessionStorage.getItem("splashSeen")) {
		        splash.style.display = 'none'; // le cacher immédiatement

		    } else {
		        // Première visite → afficher le splash pendant 4000ms
		        setTimeout(() => {
		            splash.style.display = 'none';		            
		            // On enregistre que le splash a été vu
		            sessionStorage.setItem("splashSeen", "true");
		        }, 4000); // durée du splash
		    }
		});

</script>	
			<div id="splash">
				<img src="<?= $wireframe_film ?>" alt="Wireframe" />
		 	</div> 

		<header>
				<div class="home-page">
					<span><?= $homeTitle ?></span>
				</div>
		
		<section class="hero-cover">
				<img class="cover" src="<?= $cover_path ?>" alt="image par défaut" />
				<img class="cover-mobile" src="<?= $cover_mobile_path ?>" alt="image mobile first" />
				<a href="index.php?page=films">
					<button class="btn-enter-cover"><?= $actionHomeEnter ?></button>
				</a>							   				
		</section>

		</header>
					<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>
	
	<script>console.log("bienvenue sur le site des cinémas Cinéphoria !");</script>		
	</body>
</html>