<!-- La page UI reservation.php : style K&R , indentation Ok -->
<?php 
      // Ce code initialise une session unique et empêche d'être appelée plusieurs fois
      if (session_status() === PHP_SESSION_NONE) {
          session_start() ;
        } 
      
      if (!isset($_SESSION['role'])) {
          $_SESSION['role'] = $customer ;
        }

      if (!isset($_SESSION['cinema'])) {
          $_SESSION['cinema'] = "Choisir" ;
        }

      // priorité à POST, sinon session, sinon "choisir"
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cinema'])) {
          $_SESSION['cinema'] = $_POST['cinema'] ; // mémorisation
        }

        $_SESSION['page_confirm'] = "reservations" ;

        $cinemaChoice = $_SESSION['cinema'] ;
        $cityChoice   = $cinemaChoice ;
       


        /* Fichiers à inclure */
        include_once ROOT_PATH . "/config/app.php" ;
        include_once ROOT_PATH . "/config/paths.php" ;
        include_once ROOT_PATH . "/src/View/components/IP.php" ;
        include_once ROOT_PATH . $cinemasData_path ;             
        include_once ROOT_PATH . $moviesData_path ;
        include_once ROOT_PATH . $roomsData_path ;
         include_once ROOT_PATH . $cinemaClass_path ;  
        $currentLang = language_nav() ;
        include_once ROOT_PATH . "/lang/$currentLang.php" ;


        $priceSeat = 14 ;

        /* Instanciation */
        $manager = new CinemaManager($cinemas) ;	    
        $cinemaChoisi = $manager->getCinema($cinemaChoice);

        if (!$cinemaChoisi) {
            $_SESSION['country'] = '';
            $_SESSION['city'] = $cityChoice;
        } else {
            $_SESSION['country'] = $cinemaChoisi->getPays();
            $_SESSION['city'] = $cityChoice;
        }
?> 
<!DOCTYPE html>
<html lang="fr">
    <head>
      <!-- On y inclu les metas essentielles -->
      <?php include_once ROOT_PATH . $meta_path ; ?>
        <title><?= $_ENV["APP_NAME"] ; ?></title>
        <style>
    body {
      font-weight:normal;text-align:center;
    }          
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
		  	
          if ($roleCustomer) {		  			
              include_once ROOT_PATH . $menuAdmin_path ;
          }
      ?>
      
      <!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
      <main style="display:flex;flex:1;width:100%;margin-bottom:80px;flex-direction:column;">
      <?php
					if (isset($_SESSION['role'])) {

						// Vérifie si le popup a déjà été affiché dans cette session
						if (!isset($_SESSION['popup_reservation'])) {															

							// Marque le popup comme déjà affiché
							$_SESSION['popup_reservation'] = true ;
							?>
              <!-- Affiche le popup sur l'écran -->
							<dialog id="popup"><?= $messageReservation ; ?></dialog>
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
        <div style="display:flex;width:100%;margin-top:80px">
    <!-- Contenu central -->
                <div style="flex:1; margin-left:10%;padding: 0% 2%;">
    <!-- Notre Contenu -->
                  <div class="cine-min" style="line-height:40px; display:flex; align-items:center; gap:10px;margin-top:50px">
                  <b><?= $_ENV['APP_NAME'] . " :" ; ?></b>
    <!-- D'abord la liste des cinémas -->
                    <form method="POST" id="cinemaForm">
                      <select name="cinema" onchange="document.getElementById('cinemaForm').submit();">
                        <option value="Choisir" <?= ($cinemaChoice === "Choisir") ? "selected" : "" ?>><?= $initialForm ; ?></option>                            
                        <!-- Boucles imbriquées "foreach" : vue HTML -->
                          <?php foreach($cinemas as $countryName => $listCinemas): ?>
                            <optgroup label="<?= $countryName ?>">
                              <?php foreach($listCinemas as $city => $cinema): ?>
                                <option value="<?= $city ?>" <?= ($cinemaChoice === $city) ? "selected" : "" ?>>
                                  <?= $cinema['Ville'] ; ?>
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
        if ($cityChoice !== $labelChoose) {

        $today = date('Y-m-d');
        $now = new DateTime();

            // Titre personnalisé avec le nom de la ville
            $projected = "<h2 style='text-align:left;margin-left:10%'>🎬" . " " . $projectedAt . " " . $cityChoice . "</h2>" ;
            echo $projected ;

            // Vérifie si l'utilisateur n'est pas connecté            
            if (!isset($_SESSION['id'])) {
                // Message vert avec lien comme suggestion à se connecter                 
                echo "<p style='text-align:left;margin-left:10%;margin-bottom:4%'>Vous n'êtes pas connecté - <span style='font-weight:bold'><a class='lien-reservation' href='index.php?page=login'>$pleaseLogin</a></span></p>" ;
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
                          // chaque film a un unique id
                          $get = $film['id'] ?? null ;     
                          // Nom du pays du cinéma choisi
                          $country = $cinemaChoisi->getPays() ;
                          
                          // Nombre de places dans une salle
                          $roomSeats = (int) $rooms[$country][$cityChoice]['salles'][$numRoom] ;
  
                           ?>       
      
                        <!-- La carte typique d'un film en HTML & PHP -->
                          <div class="film-card" id="film-card" style="margin-bottom:30px; margin-left:10%;padding:10px; border:1px solid #ccc; border-radius:8px;">
                                <div style="flex:1;flex:direction:column;">
                                      <h3 id=<?= $get ?>><?= $film['titre'] ; ?></h3> <!-- L'ancre configuré partant de details vers reservation -->
                                      
                                      <?php if (!empty($film['pochette'])): ?>
                                          <img src="<?= $film['pochette'] ; ?>" 
                                              alt="<?= $film['titre'] ; ?>" 
                                              style="width:150px; height:200px; border-radius:5px;"
                                              class="gallery">
                                      <!-- Modale -->
                                      <div id="modal" style="display:none; position:fixed; width:100%; height:100%; 
                                                              background: rgba(0,0,0,0.8); justify-content:center; align-items:center;">
                                          <img id="modal-img" src="" style="max-width:90%; max-height:90%;">
                                      </div>        
                                      <?php endif ; ?>

                                          <p style="font-weight:normal;text-align:center;font-size:18px"><?= ($film['version'] !== '') ? '<b>En ' . $film['version'] . '</b>' : '' ?>
                                              <?= ($film['qualité'] !== '') ? '<b>(Qualité ' . $film['qualité'] . ')</b>' : '' ?></p>
                        
                                          <br>
                                          <b><?= $duration . " :" ; ?></b> <?= $film['duree'] ; ?><br>
                                          <p><b><?= $numberRoom . " : " ; ?></b><?= $film['cinema'][$cityChoice] ; ?><br>
                                          <p><?= ($film['interdit'] !== '') ? '<b>Interdit : </b>' . $film['interdit'] : '' ?></p>
                                                                       
                                          <?php $normes = $rooms[$country][$cityChoice]['normes'] ?? [];
                                                $cles = array_keys($normes);
                                            // Vérifier si l'utilisateur a déjà voté pour ce film
                                              if (isset($_SESSION['id'])){
                                                if (isset($_SESSION['votes'][$get])) {
                                                  $vote = $_SESSION['votes'][$get] ;
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
                                                echo "<span style='color:red'>$labelHeart</span>" ;
                                            }
                                            else {
                                              echo '' ;
                                            }
                                              ?>
                                            </p>                                                                    
                                </div>                              
                                <div style="flex:2;flex-direction:column;margin-top:50px;margin-left:10px;"> 
                                      <p><b><?= 'Genre : ' . " :" ; ?></b> <?= $film['genre']; ?><br> 
                                      <p style="margin-top:30px;font-size:16px;font-weight:normal;text-align:left"><b>Description :</b> <?= nl2br($film['description']); ?></br></br> <!-- nl2br : Passage à la ligne sur la description autorisé -->                            														
                                      <b><?= $realisator . " :" ; ?></b> <?= $film['réalisateur'] ; ?></p>                                      
                        
                                          <b><?= $hours . " :" ; ?></b>
                                                <div class="horaire-grid" style="display:flex; gap:10px; flex-wrap:wrap;margin-top:10px;justify-content:center">
                                                  
                                                    <?php 
                                                          $horaire = explode(",", $film['schedules']);
                                                          foreach ($horaire as $h) {                                                            
                                                    ?>
                                                        <span class="horaire">
                                                            <a style="text-decoration:none;color:white;" href="index.php?page=<?= $reservationsName ; ?>#<?= $get ?>"><?= $h; ?></a>
                                                        </span>
                                                  <?php } ?>
                                                </div>
                                                <div style="margin-top:25px">
                                                
                                                <!-- composant compteur + bouton spin (notre pivot) -->
                                                <form id="reserveForm-<?= $get ?>" action='"index.php?page=<?= isset($_SESSION["id"]) ? $actionPageReserve : $actionPageLogin ?>' method="POST" style="max-width:480px;margin:0 auto;">
                                                  <!-- données utiles côté serveur -->
                                                  <input type="hidden" name="movie_id" value="<?= $get ?>">
                                                  <input type="hidden" name="numRoom" value="<?= $numRoom ?>">
                                                  <input type="hidden" name="country" value="<?= $country ?>">
                                                  <input type="hidden" name="city" value="<?= $cityChoice ?>">
                                                  <div class="seat-control" role="group" aria-label="Sélection de places" style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
                                                    <!-- compteur (gauche) -->
                                                     <label for="Date_Film-<?= $get ?>">Date du film</label>

                                                    <input
                                                        type="date"
                                                        id="Date_Film-<?= $get ?>"
                                                        name="Date_Film"
                                                        min="<?= date('Y-m-d'); ?>"
                                                        required
                                                    />
                                                    <div class="counter" style="display:flex;align-items:center;gap:8px;">
                                                      <label for="seats" style="font-weight:600;margin-right:4px;">Places</label>

                                                      <!-- bouton moins -->
                                                      <button type="button" class="spin-btn" id="decrease-<?= $get ?>" aria-label=<?= $reduce ?>
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
                                                      <button type="button" class="spin-btn" id="increase-<?= $get ?>" aria-label=-<?= $increase ?>
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
                  // Valeurs serveur du film
                  const availableSeats = <?= $roomSeats ?>;
                  const seatsInput = document.getElementById('seats-<?= $get ?>');
                  const increaseBtn = document.getElementById('increase-<?= $get ?>');
                  const decreaseBtn = document.getElementById('decrease-<?= $get ?>');
                  const reserveButton = document.getElementById('reserveButton-<?= $get ?>');
                  const seatInfo = document.getElementById('seatInfo-<?= $get ?>');
                  const formEl = document.getElementById('reserveForm-<?= $get ?>');              
          
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
                                horaires.forEach(h => h.classList.remove("selected")); 
                                      if (!isSelected) {
                                        this.classList.add("selected");
                                        document.getElementById("selectedHoraire-<?= $get ?>").value = this.textContent;                                      
                                        } 
                                      else {
                                        document.getElementById("selectedHoraire-<?= $get ?>").value = "";
                                        this.classList.remove("selected");
                                        }
                                    
                                seatsInput.value = 0; // Réinitialisation du nombre de places
                                updateUI(); // Mettre à jour le bouton d’UI
                              });
                          })                                                                  
                        });
              
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
                let v = seatsInput.value.replace(/[^\d]/g, '');

                if (v === '') v = '0';

                const min = Number(seatsInput.min || 0);
                const max = Number(seatsInput.max || 0);

                v = Number(v);

                seatsInput.value = String(
                    Math.max(min, Math.min(max, v))
                );
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
                          alert($alertShow);
                          return;
                      }
                      // définit l'action vers l'URL souhaitée
                      formEl.action = "index.php?page=<?= isset($_SESSION['id']) ? 'show' : 'login' ?>";

                      });
                    });

                    // Modal image
                    const modal = document.getElementById('modal');
                    const modalImg = document.getElementById('modal-img');
                    document.querySelectorAll('.gallery').forEach(img => {
                        img.addEventListener('click', () => {
                            modalImg.src = img.src;
                            modal.style.display = 'flex';
                        });
                    });
                    modal?.addEventListener('click', e => { if(e.target===modal) modal.style.display='none'; });
                    document.addEventListener('keydown', e => { if(e.key==='Escape') modal.style.display='none'; });

                    updateUI();
                })();
                

                </script>
              </div>             
<!-- Fin du conteneur principal -->              
              <?php
            }
          }}}
      else {
          echo "<div style='margin-left:20px;margin-bottom:50px;color:red'>$anyResults</div>";
      } 
      ?></main>
      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         	  	<?php include_once ROOT_PATH . $bottom_path ; ?>
			    </footer>
              
      <script>console.log(<?= $reservations ; ?>);</script>
    </body>
  </html>