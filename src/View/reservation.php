<!-- La page UI reservation.php : style K&R , indentation Ok -->
<?php 
      if (session_status() === PHP_SESSION_NONE) {
          session_start() ;
      } 
      
      if (!isset($_SESSION['role'])) {
          $_SESSION['role'] = 'client' ;
      }

      if (!defined('ROOT_PATH')) {
          die('Accès direct interdit 🚫') ;
      }

    // priorité à $_POST[], sinon session, sinon "choisir"
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cinema'])) {
      $cinemaChoice = $_POST['cinema'] ;
      $_SESSION['cinema'] = $cinemaChoice ; // mémorisation (memento)
    } 
    else if (isset($_SESSION['cinema'])) {
      $cinemaChoice = $_SESSION['cinema'] ;
      $_SESSION['cinema'] = $cinemaChoice ;  // mémorisation
    }
    else {
      $cinemaChoice = $_SESSION['cinema'] ?? 'choisir' ;
      $_SESSION['cinema'] = $cinemaChoice ; // mémorisation
    }

    // copie pratique
    $cityChoice = $_SESSION['cinema'] ?? 'choisir' ; 


      /* On charge les données */
        include_once ROOT_PATH . $cinema_class_path ;
        include_once ROOT_PATH . $cinemas_data_path ;
        include_once ROOT_PATH . $movies_data_path ;
        include_once ROOT_PATH . $rooms_data_path ;

      /* Initialisation */  
      $titleForm = "Cinéphoria :" ;
      $initialForm = "Choisir le cinéma" ;
      
      /* Instanciation */
      $manager = new CinemaManager($cinemas) ;	
      $cinemaChoisi = $manager->getCinema($cinemaChoice) ;
?> 
<!DOCTYPE html>
<html lang="fr">
    <head>
      <!-- On y inclu les metas essentielles -->
      <?php include_once ROOT_PATH . $meta_path ; ?>
        <title><?= $_ENV["APP_NAME"] ; ?></title>
        <style>
    a.lien-reservation, a.lien-reservation:visited {
      text-decoration: none ;   /* pas de soulignement par défaut */
      color: green ;          /* couleur du lien */
    }
    a.lien-reservation:hover {
      text-decoration: underline ; /* soulignement au survol */
    }
    .rating {
      direction: rtl ; /* ordre inversé pour simplifier le survol */
      display: inline-flex ;
    }
    .rating input {
      display: none ;
    }
    .rating label {
      font-size: 2rem ;
      color: #ccc ;
      cursor: pointer ;
    }
    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
      color: gold ;
    }
    </style>
    </head>
    <body> 	      		
      <?php 
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;
          }
      ?>
      <?php
					if (isset($_SESSION['role'])) {

						// Vérifie si le popup a déjà été affiché dans cette session
						if (!isset($_SESSION['popup_reservation'])) {
							
								$message = 'Vous pouvez maintenant réserver des séances' ;

							// Marque le popup comme déjà affiché
							$_SESSION['popup_reservation'] = true ;
							?>
              <!-- Affcihe le popup sur l'écran -->
							<dialog id="popup"><?= $message ; ?></dialog>
              <!-- Partie Javascript -->
							<script>
								document.addEventListener("DOMContentLoaded", () => {
									const popup = document.getElementById("popup") ;
									if (popup) {
										popup.showModal() ;
										setTimeout(() => popup.close(), 3000) ;
									}
								}) ;
							</script>
							<?php
						}
					}
					?>
    <!-- Conteneur principal -->
        <div style="display:flex;width:100%;">
    <!-- Contenu central -->
                <div style="flex:1; margin-left:10%;padding: 3% 2%;">
    <!-- Notre Contenu -->
                  <div class="cine-min" style="line-height:40px; display:flex; align-items:center; gap:10px;">
                  <b><?= $titleForm ; ?></b>
    <!-- D'abord la liste des cinémas -->
                    <form method="POST" id="cinemaForm">
                      <select name="cinema" onchange="document.getElementById('cinemaForm').submit();">
                        <option value="choisir" <?= ($cinemaChoice === "choisir") ? "selected" : "" ?>><?= $initialForm ; ?></option>                            
                        <!-- Boucles imbriquées "foreach" : vue HTML -->
                          <?php foreach($cinemas as $countryName => $listCinemas): ?>
                            <optgroup label="<?= htmlspecialchars($countryName) ?>">
                              <?php foreach($listCinemas as $city => $cinema): ?>
                                <option value="<?= htmlspecialchars($city) ?>" <?= ($cinemaChoice === $city) ? "selected" : "" ?>>
                                  <?= htmlspecialchars($cinema['Ville']) ; ?>
                                </option>
                              <?php endforeach ; ?>
                            </optgroup>
                          <?php endforeach ; ?>
                      </select>
                    </form>
                  </div>
                </div>							
        </div>
    <!-- Ensuite tous les films qui sont projettés dans la ville choisie -->            
      <?php
            // Vérifie si une ville est bien choisie
        if ($cityChoice !== 'choisir') {
            // Titre personnalisé avec le nom de la ville
            $title = "<h2 style='margin:20px 0;margin-left:10%'>🎬 Films projetés à " . htmlspecialchars($cityChoice) . "</h2>" ;
            echo $title ;

            // Vérifie si l'utilisateur n'est pas connecté            
            if (!isset($_SESSION['id'])) {
                // Message vert avec lien comme suggestion à se connecter                 
                echo "<p style='margin-left:30%;'>Vous n'êtes pas connecté - <span style='font-weight:bold'><a class='lien-reservation' href='index.php?page=login'>Connectez-vous pour réserver</a></span></p>" ;
            }

            // Vérifie le contenu global de films (movies.php)
            if (isset($films)) {  

            /* La ville choisie affiche les film(s) projeté(s) */ 
              foreach ($films as $film) {       
                // Ainsi que le numéro de/des salle(s)
                $numRoom = $film['cinema'][$cityChoice] ?? null ;
                // on saute ces itérations
                if (!isset($numRoom)) continue ; 
                      else if (isset($numRoom))
                        {        
                          // Nom du pays du cinéma choisi
                          $country = $cinemaChoisi->getPays() ;
                          // Nombre de places dans une salle
                          $roomSeats = (int) $rooms[$country][$cityChoice]['salles'][$numRoom] ;
                          // chaque film a un unique id
                          $get = $film['id'] ?? null ; ?>       
      
                        <!-- La carte typique d'un film en HTML & PHP -->
                          <div class="film-card" id="film-card" style="margin-bottom:30px; margin-left:10%;padding:10px; border:1px solid #ccc; border-radius:8px;">
                                <div style="flex:1;flex:direction:column;">
                                      <h3 id=<?= $get ?>><?= htmlspecialchars($film['titre']) ; ?></h3> <!-- L'ancre configuré partant de details vers reservation -->
                                      
                                      <?php if (!empty($film['pochette'])): ?>
                                          <img src="<?= htmlspecialchars($film['pochette']) ; ?>" 
                                              alt="<?= htmlspecialchars($film['titre']) ; ?>" 
                                              style="width:150px; height:200px; border-radius:5px;">
                                      <?php endif ; ?>

                                          <p><?= ($film['version'] !== '') ? '<b>En ' . htmlspecialchars($film['version']) . '</b>' : '' ?>
                                              <?= ($film['qualité'] !== '') ? '<b>(Qualité ' . htmlspecialchars($film['qualité']) . ')</b>' : '' ?></p>
                        
                                          <b>Réalisateur :</b> <?= htmlspecialchars($film['réalisateur']) ; ?><br>
                                          <b>Durée :</b> <?= htmlspecialchars($film['duree']) ; ?><br>
                                          <p>Numéro de salle : <?= $film['cinema'][$cityChoice] ; ?><br>                               
                                          <?php $cles = array_keys($salles[$country][$cityChoice]['normes']) ; 
                                            // Vérifier si l'utilisateur a déjà voté pour ce film
                                              if (isset($_SESSION['id'])){
                                                if (isset($_SESSION['votes'][$get])) {
                                                  $vote = $_SESSION['votes'] ;
                                                  echo "<p>Vous avez déjà voté : <b>{$vote} / 5 ⭐</b></p>" ;
                                              } else {
                                                  // Pas encore voté → afficher
                                          ?>
                                          <div class="rating">
                                                <input type="radio" id="star5" name="note" value="5"><label for="star5">★</label>
                                                <input type="radio" id="star4" name="note" value="4"><label for="star4">★</label>
                                                <input type="radio" id="star3" name="note" value="3"><label for="star3">★</label>
                                                <input type="radio" id="star2" name="note" value="2"><label for="star2">★</label>
                                                <input type="radio" id="star1" name="note" value="1"><label for="star1">★</label>
                                              </div>
                                          <?php }}
                                            if (in_array($film['cinema'][$cityChoice],$cles)) 
                                            { 
                                              echo '<img style="margin-top:10px;margin-left:5px" src="./img/icons/fauteuil roulant.png" width="30px" height="30px" />' ; 
                                              } 
                                              else 
                                              { 
                                                echo '' ;
                                                } ?><br/>
                                            <?php 
                                            if ($film['label'] === 'oui'){ 
                                                echo '<span style="color:red">Label coup de coeur</span>' ;
                                            }
                                            else {
                                              echo '' ;
                                            }
                                              ?>
                                            </p>                                                                    
                                </div>                              
                                <div style="flex:2;flex-direction:column;margin-top:50px;margin-left:10px;"> 
                                      <p><b>Genre :</b> <?= htmlspecialchars($film['genre']); ?><br> 
                                      <p style="margin-top:30px;"><b>Description :</b> <?= nl2br(htmlspecialchars($film['description'])); ?></p> <!-- nl2br : Passage à la ligne sur la description autorisé -->                            														
                                      <?= ($film['interdit'] !== '') ? '<b>Interdit : </b>' . htmlspecialchars($film['interdit']) : '' ?></p>	
                        
                                          <b>Horaires :</b>
                                                <div class="horaire-grid" style="display:flex; gap:10px; flex-wrap:wrap;margin-top:10px">
                                                  
                                                    <?php 
                                                          $horaire = explode(",", $film['schedules']);
                                                          foreach ($horaire as $h) {
                                                    ?>        
                                                        <span class="horaire">
                                                            <a style="text-decoration:none;color:white;" href="index.php?page=reservation#<?= $get ?>"><?= htmlspecialchars($h); ?></a>
                                                        </span>
                                                  <?php } ?>
                                                </div>
                                                <div style="margin-top:25px">
                                                
                                                <!-- composant compteur + bouton spin (notre pivot) -->
                                                <form id="reserveForm-<?= $get ?>" action="<?= isset($_SESSION['id']) ? 'index.php?page=seance' : 'index.php?page=login' ?>" method="POST" style="max-width:480px;margin:0 auto;">
                                                  <!-- données utiles côté serveur -->
                                                  <input type="hidden" name="movie_id" value="<?= $get ?>">   
                                                  <div class="seat-control" role="group" aria-label="Sélection de places" style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
                                                    <!-- compteur (gauche) -->
                                                    <div class="counter" style="display:flex;align-items:center;gap:8px;">
                                                      <label for="seats" style="font-weight:600;margin-right:4px;">Places</label>

                                                      <!-- bouton moins -->
                                                      <button type="button" class="spin-btn" id="decrease-<?= $get ?>" aria-label="Diminuer le nombre de places"
                                                              style="width:38px;height:38px;border-radius:6px;border:1px solid #ccc;background:#fff;cursor:pointer;">−</button>

                                                      <!-- input number (spinner) -->
                                                      <input
                                                        id="seats-<?= $get ?>"
                                                        name="seats"
                                                        type="number"
                                                        value="0"
                                                        min="0"
                                                        max="<?= $roomSeats ?>"
                                                        step="1"
                                                        inputmode="numeric"
                                                        aria-live="polite"
                                                        aria-label="Nombre de places"
                                                        style="width:64px;height:38px;text-align:center;border:1px solid #ccc;border-radius:6px;font-size:1rem;"
                                                      >

                                                      <!-- bouton plus -->
                                                      <button type="button" class="spin-btn" id="increase-<?= $get ?>" aria-label="Augmenter le nombre de places"
                                                              style="width:38px;height:38px;border-radius:6px;border:1px solid #ccc;background:#fff;cursor:pointer;">＋</button>

                                                      <!-- message d'information (accessible) -->
                                                      <div id="seatInfo-<?= $get ?>" aria-live="polite" style="margin-left:8px;font-size:0.9rem;color:#333;"></div>                                         
                                                    </div>

                                                    <!-- champs caché où l'horaire du client est transmis par notre formulaire (géré en JS) -->
                                                    <input type="hidden" name="horaire" id="selectedHoraire-<?= $get ?>" />
                                                    <input type="hidden" name="capacity" value="<?= $roomSeats ?>" />            
                                                    <!-- bouton réserver (validation) -->                                                                                      
                                                    <button type="submit" id="reserveButton-<?= $get ?>" style="padding:10px 18px;border-radius:8px;border:none;color:white;">
                                                      Valider
                                                    </button>                                                    
                                                  </div>
                                                  
                                                </form>
                                </div>
                          </div>  
                        <!-- Fin de la carte d'un film -->                                 
    <!-- Partie Javascript -->                                                       
    <script>                  
          (function () {
                let price_seat = 14; // prix unitaire
                  // valeurs serveur du film
                  const availableSeats = <?= $roomSeats ?>;
                  const seatsInput = document.getElementById('seats-<?= $get ?>');
                  const increaseBtn = document.getElementById('increase-<?= $get ?>');
                  const decreaseBtn = document.getElementById('decrease-<?= $get ?>');
                  const reserveButton = document.getElementById('reserveButton-<?= $get ?>');
                  const seatInfo = document.getElementById('seatInfo-<?= $get ?>');
                  const formEl = document.getElementById('reserveForm-<?= $get ?>');
                

                document.addEventListener("DOMContentLoaded", function () {
                  const input = document.getElementById("seats-<?= $get ?>");
                  const reserveButton = document.getElementById("reserveButton-<?= $get ?>");              
                });

          
          function updateUI() { 
    let val = Number(seatsInput.value) || 0;
    let horaireSelected = document.getElementById("selectedHoraire-<?= $get ?>").value.trim() !== "";
    let selected = (val > 0 && horaireSelected);

    // Vérifie aussi la session côté PHP (injectée dans JS)
    const isLoggedIn = <?= isset($_SESSION['id']) ? 'true' : 'false' ?>;

    reserveButton.disabled = !(selected);

    if (reserveButton.disabled) {
        reserveButton.style.backgroundColor = "lightgrey";
        reserveButton.style.cursor = "not-allowed";
    } else {
        reserveButton.style.backgroundColor = "black";
        reserveButton.style.cursor = "pointer";
    }

    if (availableSeats === 0) {
        seatInfo.textContent = "Plus de places disponibles";
    } else {
        if (val > 0) {
            const totalPrice = val * price_seat;
            seatInfo.innerHTML = `${val} place${val > 1 ? 's' : ''} - <span style="color:green;font-weight:600;">${totalPrice} €</span>`;
        } else {
            seatInfo.textContent = '';
        }
    }
}
                document.addEventListener("DOMContentLoaded", function () {
                  document.querySelectorAll(".film-card").forEach(function () {
                    const horaires = document.querySelectorAll(".horaire");
                    horaires.forEach(function (el) {
                        el.addEventListener("click", function () {
                            let isSelected = this.style.background === "black";
                                horaires.forEach(s => s.style.background = ""); 
                                      if (!isSelected) {
                                        this.style.background = "black";
                                        document.getElementById("selectedHoraire-<?= $get ?>").value = this.textContent;                                      
                                        } 
                                      else {
                                        this.style.background = "";
                                        document.getElementById("selectedHoraire-<?= $get ?>").value = "";
                                        }
                                    
                                seatsInput.value = 0; // Réinitialisation du nombre de places
                                updateUI(); // Mettre à jour le bouton d’UI
                              });
                          })
                        
                  
                        
                        })});
              
                increaseBtn.addEventListener('click', function () {
                    let v = Number(seatsInput.value) || 0;
                    const max = Number(seatsInput.max);
                      if (v < max) seatsInput.value = v + 1;
                          seatsInput.dispatchEvent(new Event('change'));
                      });

                decreaseBtn.addEventListener('click', function () {
                    let v = Number(seatsInput.value) || 0;
                    const min = Number(seatsInput.min || 0);
                      if (v > min) seatsInput.value = v - 1;
                          seatsInput.dispatchEvent(new Event('change'));
                      });

                seatsInput.addEventListener('input', function () {
                    let v = seatsInput.value.replace(/[^\d\-]/g, '');
                      if (v === '') v = '0';
                          seatsInput.value = String(Math.max(Number(seatsInput.min || 0), Math.min(Number(seatsInput.max || availableSeats), Math.floor(Number(v)))));
                      });

                seatsInput.addEventListener('change', updateUI);
                          updateUI();

                formEl.addEventListener('submit', function (e) {
                    const v = Number(seatsInput.value) || 0;
                      if (v <= 0) {
                          e.preventDefault();
                          alert('Sélectionnez au moins 1 place.');
                          return;
                      }
                      if (v > availableSeats) {
                          e.preventDefault();
                          alert('Le nombre demandé dépasse les places disponibles.');
                          return;
                      }
                      // définit l'action vers l'URL souhaitée
                      formEl.action = "<?= isset($_SESSION['id']) ? 'index.php?page=seance' : 'index.php?page=login' ?>";

                      // maintenant, soumettre le formulaire
                      formEl.submit(); // envoi POST
                      
                      });
                    })();
</script>
              </div>  <!-- A sa place ? -->               
<!-- Fin du conteneur principal -->              
              <?php
            }
          }}}
      else {
          echo "<div style='margin-left:20px;margin-bottom:50px;color:red'>Aucun résultat en ce moment</div>";
      } 
      ?>
      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
		<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>
        
      
      <script>console.log("Cinéphoria : page de réservation");</script>
    </body>
  </html>