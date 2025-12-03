<!-- Style K&R , details.php -->
 <?php 
	  if (session_status() === PHP_SESSION_NONE) {
    	  session_start();} 
	          if (!isset($_SESSION['role'])) {
            	$_SESSION['role'] = 'client';
       			}

	if (!defined('ROOT_PATH')) {
		die('Accès direct interdit 🚫');
	}

	// Utilisation de la config
	  global $config;
    $text = "Pas de Films en ce moment.";
    $read_more = "Lire plus";
    $read_less = "Lire moins";
    $see_session = "Voir Séance";
    $title_form = "Cinéphoria :";

    /* Les films sont enregistrés sur le serveur dans ce fichier php */
	include_once ROOT_PATH . $movies_data_path;

    // copie pratique
    $get = $_GET['id'];
    // initialisation
    $id = isset($get) ? max(0, (int)$get - 1) : 0;
    $film = $films[$id] ?? null;    
    $cinemaVilleFilm = array_keys($film['cinema']);
    $cinemaSchedules = array_map('trim', explode(',', $film['schedules']));
    $cinemaChoisi = $_POST['cinema'] ?? null;

	
?> 

<!DOCTYPE html>
<html lang="fr">
	<head>
        <style>
.bloc-text {
  cursor: pointer;
  color: blue;
  text-decoration: none;
}

        </style>   
		<!-- On y inclu les metas essentielles -->
		<?php include_once ROOT_PATH . $meta_path; ?>
			<title><?= $config["app_name"]; ?></title>
	</head>
	<body> 			
		<?php 
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}
		?>
			<!-- Conteneur principal en flex -->
			<main style="display:flex;min-height:80vh;">
				
					<!-- Bannière de gauche -->
					<div style="display:flex;flex: 0 0 10%;">
						<img src="<?= $img_cinephoria_small; ?>" class="aside" alt="Image responsive">						
					</div>

					<?php
        if (isset($films) && !empty($film)) { ?>
            <div style="display:flex; gap:20px; margin:5% 0; align-items:flex-start;justify-content: center;">

                <!-- Colonne gauche centrale : pochette -->
                <div style="flex:0 0 220px;margin-left:10%">
                    <img src="<?= htmlspecialchars($films[$id]['pochette']); ?>" 
                         alt="<?= htmlspecialchars($films[$id]['titre']); ?>" 
                         style="width:220px;height:330px;object-fit:cover;border-radius:6px;cursor:pointer"
                         class="gallery"
                         data-index="0">

                    <!-- Modale -->
                    <div class="modal" id="modal">
                        <span class="close-btn" onclick="closeModal()">&times;</span>
                        <img id="modal-img" src="" alt="Grande Image">
                    </div>
                </div>

                <!-- Colonne droite centrale : infos -->
                <div style="flex:1; text-align:left;">
                    <h2 style="margin-top:0;"><?= htmlspecialchars($films[$id]['titre']); ?></h2>
                    <span style="display:block;margin-bottom:10px;">
                        <?= isset($films[$id]['subtitle']) ? htmlspecialchars($films[$id]['subtitle']) : ''; ?>
                    </span>

                    <p id="desc" class="details-text button-fold">
                        <?= htmlspecialchars($films[$id]['description']); ?>
                    </p>

                    <span id="toggleBtn" class="bloc-text">▼ Lire plus</span>

                    <div style="display:flex; flex-direction:column; flex:1; gap:20px;  flex-wrap:wrap;">
                        
                        <!-- Conteneur global -->
                        <div style="color:black; margin-top:2%; margin-bottom:5%; display:flex; flex-direction:row; gap:40px;">

                                <!-- Bloc cinéma -->
                                <!-- Conteneur des boutons sur la même ligne -->
                               
                            <div style="display:flex; margin-top:5%; align-items:center;">
                                <span id="toggleBtnCinema" class="bloc-text">▼ Choix du cinéma</span>
                                <span id="toggleBtnSeance" class="bloc-text" style="color:black; cursor:not-allowed;margin-left:80px;">▼ Voir les séances</span>
                            </div>
                        </div>
                    <!-- Conteneur déroulant formulaire et horaires -->
                    <div style="display:flex; flex-direction:row;align-items: center;gap:20px; margin-top:10px; flex-wrap:wrap;">
                              
                              <!-- Bloc déroulant cinéma -->
                              
                                  <div class="cine-min" id="descCinema" style="display:none;line-height:40px; align-items:center; gap:10px;">
                                     <form method="POST" id="cinemaForm" style="display:flex; align-items:center; gap:8px;">
                                          <label for="cinema"><b><?= $title_form ?></b></label><select id="cinema" name="cinema" onchange="document.getElementById('cinemaForm').submit();">
                                              <option value="choisir" selected>Choisir le cinéma</option>
                                              <?php foreach($cinemaVilleFilm as $ville): ?>
                                                  <option value="<?= htmlspecialchars($ville) ?>" <?= ($cinemaChoisi === $ville) ? "selected" : "" ?>>
                                                      <?= htmlspecialchars($ville) ?>
                                                  </option>
                                              <?php endforeach; ?>
                                          </select>
                                      </form>
                                  </div>
                              

                              <!-- Bloc déroulant séances -->
                              <div id="descSeance">
                                  <?php if ($cinemaChoisi && $cinemaChoisi !== "choisir"): ?>
                                      <div class="horaire-grid" style="display:flex; gap:10px; flex-wrap:wrap;margin-left:30px">
                                          <?php foreach($cinemaSchedules as $schedules): ?>
                                              <span class="horaire">     
                                                <!-- L'ancre configuré partant de details vers reservation -->                                           
                                                  <a style="text-decoration:none;color:white;" href="index.php?page=reservation#<?= $get ?>"><?= htmlspecialchars($schedules); ?></a>
                                              </span>
                                          <?php endforeach; ?>
                                      </div>
                                  <?php endif; ?>
                              </div>
</div>
                          </div>
                      </div>              
                </div>
            </div>
        <?php } else {
            echo '<p>' . $text . '</p>';
        } ?>

					<!-- Bannière de droite --> 
					<div style="display:flex;flex: 0 0 10%;">
						<img src="<?= $img_cinephoria_small; ?>" style="height:100%" class="aside" alt="Image responsive">
					</div>	            
			</main>               
				
            <!-- Partie php du pied de page en bas -->
            <footer class="under">
                    <?php include_once ROOT_PATH . $bottom_path ;?>
			</footer>

    <div>
		<?php include_once ROOT_PATH . $footer_path; ?>
	</div>
			
				    
<!-- Partie Javascript -->
 <script>
/* Boutons lire plus etc. */
const desc = document.getElementById("desc");
const descSeance = document.getElementById("descSeance");
const descCinema = document.getElementById("descCinema");
const toggleBtn = document.getElementById("toggleBtn");
const toggleBtnSeance = document.getElementById("toggleBtnSeance");
const toggleBtnCinema = document.getElementById("toggleBtnCinema");
let expanded = false;
let seanceOpen = false;
let cinemaOpen = false;

toggleBtn.addEventListener("click", () => {
  expanded = !expanded;

  if (expanded) {
    desc.style.webkitLineClamp = "unset";   // montrer tout
    desc.style.maxHeight = "none";          // pas de limite
    toggleBtn.textContent = "▲ <?= addslashes($read_less) ?>";
  } else {
    desc.style.webkitLineClamp = "2";       // couper à 2 lignes
    desc.style.maxHeight = "3em";           // correspond à 2 lignes
    toggleBtn.textContent = "▼ <?= addslashes($read_more) ?>";
  }
});

// bloc cinéma
descCinema.style.display = "none"; // init fermé
toggleBtnSeance.style.cursor = "not-allowed"; // init non cliquable
toggleBtnCinema.addEventListener("click", () => {
  cinemaOpen = !cinemaOpen;
  descCinema.style.display = cinemaOpen ? "flex" : "none";
  toggleBtnCinema.textContent = cinemaOpen ? "▲ Choix du cinéma" : "▼ Choix du cinéma";

  // Activer/désactiver le bouton séances selon le cinéma
  toggleBtnSeance.style.cursor = cinemaOpen ? "pointer" : "not-allowed";
  toggleBtnSeance.style.color = cinemaOpen ? "black" : "gray";

  // si on ferme le cinéma, on force la fermeture des séances
  if (!cinemaOpen) {
    seanceOpen = false;
    descSeance.style.display = "none";
    toggleBtnSeance.textContent = "▼ <?= addslashes($see_session) ?>";
  }
});

// bloc séance : dépend du cinéma
toggleBtnSeance.addEventListener("click", () => {
  if (!cinemaOpen) {
    alert("Veuillez d'abord choisir un cinéma avant de voir les séances.");
    return; // stop ici
  }

  seanceOpen = !seanceOpen;
  if (seanceOpen) {
    descSeance.style.display = "flex"; // ouvre le bloc
    toggleBtnSeance.textContent = "▲ <?= addslashes($see_session) ?>";
  } else {
    descSeance.style.display = "none"; // ferme le bloc
    toggleBtnSeance.textContent = "▼ <?= addslashes($see_session) ?>";
  }
});

/* Boîte modale */
let currentIndex = 0;

const modal = document.getElementById('modal');
const modalImg = document.getElementById('modal-img');
const galleryImages = document.querySelectorAll('.gallery');

// tableau d'URLs des images
const images = Array.from(galleryImages).map(img => img.src);

galleryImages.forEach((img, index) => {
  img.addEventListener('click', () => {
    currentIndex = index;
    showImage(currentIndex);
  });
});

function showImage(index) {
  modalImg.src = images[index];
  modal.style.display = 'flex';
}

function closeModal() {
  modal.style.display = 'none';
}

// clic en dehors de l'image pour fermer
modal.addEventListener('click', (e) => {
  if (e.target === modal) {
    closeModal();
  }
});

// raccourcis clavier
document.addEventListener('keydown', (e) => {
  if (e.key === "Escape") closeModal();
});
</script>

      <!-- Partie php du pied de page en bas -->
      <footer class="under">
        <?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
			<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>
		
		<script>console.log("Cinéphoria : toutes les nouveautés");</script>
	</body>
</html>




    