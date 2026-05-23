<!-- La page UI details.php du site : Style K&R , indentation ok -->
    <?php 
      // Ce code initialise une session unique et empêche d'être appelée plusieurs fois
        if (session_status() === PHP_SESSION_NONE) {
            session_start() ;
          } 

      // Sécurité contre accès direct aux fichiers internes
        if (!defined('ROOT_PATH')) {
            die('Accès direct interdit 🚫') ;
          }

      // Utilisateur non-identifié définit par défaut
        if (!isset($_SESSION['role'])) {
            $_SESSION['role'] = 'client' ;
          }

      /* Initialisation de nos variables dynamiques */
        $text = "Pas de Films actuellement." ;
        $read_more = "Lire plus" ;
        $read_less = "Lire moins" ;
        $see_session = "Voir Séance" ;
        $title_form = "Cinéphoria :" ;

      // Les films sont enregistrés sur le serveur dans ce fichier php
        include_once ROOT_PATH . $moviesData_path ;
        include_once ROOT_PATH . $cinemaForm_path ;
        

      // Copies pratiques
        $get = isset($_GET['id']) ? (int) $_GET['id'] : 1 ; // Le film (en réalité son id) via l’URL
        $id = max(0, $get - 1) ; // Index de tableau
        $film = $films[$id] ?? null ; // Source des id pour un film
        $cinemaCityFilm = array_map('trim', array_keys($film['cinema'])) ; // Tableau
        $cinemaSchedules = array_map('trim', explode(',', $film['schedules'])) ; // Tableau
        $cinemaChoisi = isset($_POST['cinema']) ? trim(strip_tags($_POST['cinema'])) : null ; // Vérifie si le champ cinema a été envoyé
    ?> 

<!DOCTYPE html>
<html lang="fr">
<head>
  <style>
    .bloc-text {
        cursor: pointer ;
        color: blue ;
        text-decoration: none ;
      }
  </style>  

		<!-- On y inclu les metas essentielles -->
		      <?php 
              include_once ROOT_PATH . $meta_path ; 
          ?>
			<title><?= $config["app_name"] ; ?></title>
</head>
<body> 			
		      <?php 
              // Le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menuAdmin_path ;}
		      ?>

    <!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
    <main style="display:flex; min-height:80vh; gap:10px;">

      <!-- Bannière gauche -->
      <div class="banner-left">
          <img src="<?= $img_cinephoria_small ; ?>" class="aside" alt="Image responsive">
      </div>

      <!-- Contenu central -->
      <div class="content-details">
        <?php if (isset($films) && !empty($film)) { ?>
          <!-- Pochette + infos + cinéma + horaires -->
          <div class="details">
                <div class="en-tete-details">
                    <img class="pochette-details gallery" src="<?= htmlspecialchars(trim($films[$id]['pochette'])) ; ?>" 
                        alt="<?= htmlspecialchars(trim($films[$id]['titre'])) ; ?>" 
                      />

                    <!-- Modale -->
                    <div id="modal" style="display:none; position:fixed; width:100%; height:100%; 
                                            background: rgba(0,0,0,0.8); justify-content:center; align-items:center;">
                        <img id="modal-img" src="" style="max-width:90%; max-height:90%;">
                    </div>
  
                </div>

                <div style="flex:1; text-align:left;font-size:18px;">
                  <h2><?= htmlspecialchars(trim($films[$id]['titre'])) ; ?></h2>
                  <?= isset($films[$id]['subtitle'])
                        ? "<p class='subtitle' style='display:block;padding-bottom:10px'>"
                          . htmlspecialchars(trim($films[$id]['subtitle']), ENT_QUOTES, 'UTF-8')
                          . "</p>"
                        : ""; ?>

                  
    
        <!-- Bloc description -->
        <div class="desc-block">
            <p id="desc" class="details-text button-fold" aria-live="polite">
              <?= htmlspecialchars(trim($films[$id]['description'])) ; ?>
            </p>
      <!-- Bloc lire plus -->      
      <div class="details-top">
            <div id="toggleDescriptionBtn" class="bloc-text">▼ Lire plus</div>
            <div style="margin-top:2%" id="toggleCinemaBtn" class="bloc-text">▼ Cinémas projetés</div>
      </div>    

        <!-- Bloc droit : cinémas -->
        <div class="cinema-block" id="descCinema" style="display:none">
      <ul class="projected">
      <?php foreach ($film['cinema'] as $cinema => $data) { ?>
        <li><?= htmlspecialchars($cinema) ?></li>
      <?php } ?>
    </ul>
</div>

        </div>
      </div>
    </div>
        <?php } else { ?>
          <p><?= $text ?></p>
        <?php } ?>
      </div>

        <!-- Bannière droite -->
        <div class="banner-right">
          <img src="<?= $img_cinephoria_small ; ?>" style="height:100%" class="aside" alt="Image responsive">
        </div>

  </main>
              
				
    <!-- Partie php du pied de page en bas -->
      <footer class="under">
          <?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
				    
<!-- Partie Javascript -->
<script>
    /* Boutons lire plus etc. */
    const desc = document.getElementById("desc") ;
    const descShow = document.getElementById("descShow") ;
    const descCinema = document.getElementById("descCinema") ;
    const toggleDescriptionBtn = document.getElementById("toggleDescriptionBtn") ;
    const toggleBtnShow = document.getElementById("toggleBtnShow") ;
    const toggleBtnCinema = document.getElementById("toggleBtnCinema") ;

    // Variables nommées
    let expanded = false ;
    let ShowOpen = false ;
    let cinemaOpen = false ;

    // Evenements Javascript
    toggleDescriptionBtn.addEventListener("click", () => {
      expanded = !expanded ;

      if (expanded) {
        desc.style.webkitLineClamp = "unset" ;   // montrer tout
        desc.style.maxHeight = "none" ;          // pas de limite
        toggleDescriptionBtn.textContent = "▲ <?= addslashes($read_less) ?>" ;
      } else {
        desc.style.webkitLineClamp = "2" ;       // couper à 2 lignes
        desc.style.maxHeight = "3em" ;           // correspond à 2 lignes
        toggleDescriptionBtn.textContent = "▼ <?= addslashes($read_more) ?>" ;
      }
    });

      // bloc cinéma
      toggleCinemaBtn.addEventListener("click", () => {
        cinemaOpen = !cinemaOpen;
        descCinema.style.display = cinemaOpen ? "block" : "none";
        toggleCinemaBtn.textContent = cinemaOpen ? "▲ Cinémas projetés" : "▼ Cinémas projetés";
      });


    /* Boîte modale */
    let currentIndex = 0;

    const modal = document.getElementById('modal') ; // La modale
    const modalImg = document.getElementById('modal-img') ; // L’image interne
    const galleryImages = document.querySelectorAll('.gallery') ; // Toutes les images cliquables

    // Tableau d'URLs des images
    const images = Array.from(galleryImages).map(img => img.src) ;

    // Clic sur la pochette
    galleryImages.forEach((img, index) => {
      img.addEventListener('click', () => {
        currentIndex = index ;
        showImage(currentIndex) ;
      });
    });

    // Affichage de la modale
    function showImage(index) {
      modalImg.src = images[index] ;
      modal.style.display = 'flex' ;
    }

    // Fermeture de la modale
    function closeModal() {
      modal.style.display = 'none' ;
    }

    // Clic en dehors de l'image pour fermer
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        closeModal() ;
      }
    });

    // Raccourcis clavier "Échap"
    document.addEventListener('keydown', (e) => {
      if (e.key === "Escape") closeModal() ;
    });
</script>
		
		<script>console.log("Cinéphoria : toutes les nouveautés") ;</script>
	</body>
</html>




    