<!-- La page UI du site show.php (texte pur HTML & PHP dynamique) : Style K&R , Indentation Ok -->
<?php
        // Ce code initialise une session unique et empêche d'être appelée plusieurs fois
        if (session_status() === PHP_SESSION_NONE) {
            session_start() ;
          }

        /* Fichiers à inclure */
        include_once ROOT_PATH . $movies_data_path ; // Le fichier de films

        // Récupère les données via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filmId = $_POST['movie_id'] ?? null ; // id du film (mémorisé)
            $nbSeats = (int)($_POST['seats'] ?? 0) ; // le nombre de sièges (mémorisé)
            $salle = $_POST['salle'] ?? null ; // le numéro de salle (masqué)
          }

        if (!isset($_SESSION['count_seats'])) {
                $_SESSION['count_seats'] = 0 ; // le nombre de places (mémorisé)
          }        

    /* Lorsqu'un film a été sélectionné, et 1 place ou plus a été demandée */

        if ($filmId && $nbSeats > 0) {

            // Initialisation
            $_SESSION['seats'] = $nbSeats ;
            $_SESSION['movie_id'] = (int)($_POST['movie_id'] ?? null) ;
            $_SESSION['horaire'] = trim($_POST['horaire'] ?? '');

            // Le prix total d'un client (le produit de places x prix)
            if (isset($_POST['seats']) && is_numeric($_POST['seats']) && $_POST['seats'] > 0) {
                    $seats = (int) $_POST['seats'] ;
                    $totalPrice = $seats * $PRICE_SEAT ;
                    $_SESSION['sum'] = $totalPrice ;
              }

            $subtitle = $films[$filmId - 1]['titre'] ;
            // Le nombre de places des clients
            $_SESSION['count_seats'] += $nbSeats ;

            // La liste des places d'un client
            if (!isset($_SESSION['reservedSeats'])) {
                $_SESSION['reservedSeats'] = [] ;
              }

            /* La liste de toutes les places réservées */
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Récupère les places sélectionnés
                $selectedSeats = $_POST['selected_seats'] ?? '' ;
                $selectedSeatsArray = array_filter(explode(',', $selectedSeats)) ;

                // Ajoute à la liste des sièges déjà réservés
                $_SESSION['reservedSeats'] = array_unique(array_merge($_SESSION['reservedSeats'], $selectedSeatsArray)) ;

              }

            // Copie pratique
            $reservedSeats = $_SESSION['reservedSeats'] ;

?>
<!DOCTYPE html> 
<html lang="fr">
        <head>              
            <?php
                // On y inclu les metas essentielles d'indexation
                include_once ROOT_PATH . $meta_path ;
            ?>
                <!-- Notre titre de la page est situé à la racine du projet (fichier .env) -->
                <title><?= $_ENV["APP_NAME"] ; ?></title>			
        </head>
        <body> 	
                <?php		    	  		
                    // Le header et le menu-admin sont à inclure sur chaque page
                    include_once ROOT_PATH . $header_path ;                   		  			
                
                // Inclu le menu admin si le visiteur est admin ou employé
                if (!$roleCustomer) {		  			
                    include_once ROOT_PATH . $menu_admin_path ;}
                ?>
            4
            <main> 
                <!-- Conteneur centré -->  
                <div class="center">	
                        <div class="title-reserve"><?= $titleContact ; ?></div>
                        <div style="margin-bottom:50px;"><?= $subtitle ; ?></div>
                        
                    <?php
                    /* Positionner les sièges pour réserver */   

                        // Initialisation des données
                        $nb_rangée = 10 ; // nombre de rangées
                        $pas = 2 ; // écart de croissance

                        // initialisation des rangées de sièges
                        $capacity = (int)($_POST['capacity'] ?? 0) ; 
                        $range = [] ;
                        $seatNumber = 1 ;
                                                                        
                        // Calculons $pos en tenant compte de $pas
                        $total_pas = array_sum(range(0, $nb_rangée - 1)) * $pas ;
                        // Point de départ $pos
                        $pos = ($capacity - $total_pas) / $nb_rangée ;
                        
                        // Calculons le nombre de sièges par rangée dans la salle
                        for ($i = 0; $i < $nb_rangée; $i++) {
                            $range[] = (int)round($pos + $i * $pas) ;
                        }

                    ?>

                    <div>  

                    <?php
                    /* Afficher à l’écran la grille de sièges */
                        foreach ($range as $count) {
                            echo '<div style="margin-bottom:30px;">' ; // chaque rangée a un espace en bas                                
                            // afficher chaque siège d’une rangée
                            for ($i = 0; $i < $count; $i++) {
                                    $isReserved = in_array($seatNumber, $reservedSeats) ;
                                    $seatClass = "seat " . ($isReserved ? "reserved" : "available") ;
                                    $seatStyle = $isReserved 
                                        ? "background:black; color:white; cursor:not-allowed;" 
                                        : "background:#CAF7B8; cursor:pointer;";
                                    echo '<span class="' . $seatClass . '" data-seat="' . $seatNumber . '" style="border:1px solid black;border-radius:15px;padding:15px;margin-left:5px;margin-right:5px;' . $seatStyle . '">'
                                        . $seatNumber . '</span>';
                                    $seatNumber++ ;
                                }
                            echo '</div>' ; // fin d'une rangée
                        } // fin de toutes les rangées
                    ?>
                    </div>
                    <!-- formulaire de validation -->             
                    <form method="POST" action="index.php?page=payment">
                        <!-- champ caché liste JavaScript -->
                        <input type="hidden" name="selected_seats" id="selectedSeatsInput" value="">
                        <!-- bouton réserver -->
                        <button type="submit" id="reserveButton-<?= $filmId ?>" disabled
                                style="padding:10px 18px;border-radius:8px;border:none;color:white;background-color:grey;font-weight:700;">
                                Réserver
                        </button>
                    </form>                    
                </div>
            </main>
                
            <!-- Partie php du pied de page en bas -->
            <!-- footer contient des recommendations d'accessibilité -->
            <!-- et une aide pour les lecteurs d’écran et les moteurs de recherche -->
            <footer class="under">
                <?php include_once ROOT_PATH . $bottom_path ; ?>
            </footer> 
       <?php } ?>
        
<!-- Partie Javascript -->
<script>
    // Attendre que toute la page soit chargée
    document.addEventListener('DOMContentLoaded', () => { 
        
        /* Initialisation */

            // Tous les sièges disponibles (classe .available)
            const seats = document.querySelectorAll('.seat.available') ;
            // Nombre de sièges maximum d'un client
            const nbSeatsMax = <?= (int)$nbSeats ?> ;        
            // Les numéros des sièges réservés seront dans ce tableau
            let selectedSeats = [] ;
            // Bouton de réservation dont le style pourra changer
            const reserveButton = document.getElementById("reserveButton-<?= $filmId ?>") ;
            // L'input caché compteur
            const selectedSeatsInput = document.getElementById("selectedSeatsInput") ;


        /* Programmation des évenements JavaScript dans le navigateur */

            // Au clic de n'importe quel siège
            seats.forEach(seat => {                
                seat.addEventListener('click', () => {
                    // dataset représente tous les attributs data-* de l’élément (rangés dans un tableau)
                    const seatNumber = seat.dataset.seat ; // Assignation de data-seat par dataset.seat

                    // Le siège est déjà séléctionné ?
                    if (seat.classList.contains('selected')) {
                        // Supprime la classe qui existe puis le siège redevient vert (et lors de l'évenement 'click')
                        seat.classList.remove('selected') ; 
                        seat.style.background = '#CAF7B8' ;
                        seat.style.color = 'black' ;
                        // Garder tous les éléments qui sont différents de seatNumber
                        selectedSeats = selectedSeats.filter(n => n != seatNumber) ;
                    } 
                    else {
                        // Limite atteinte ?
                        if (selectedSeats.length >= nbSeatsMax) {
                            alert("Vous ne pouvez sélectionner que " + nbSeatsMax + " sièges.") ;
                            return;
                        }
                        // Séléctionner le siège
                        seat.classList.add('selected') ;
                        seat.style.background = 'black' ;
                        seat.style.color = 'white' ;
                        selectedSeats.push(seatNumber) ; // Ajoute un élément à la fin du tableau
                    }

                    // Liste des sièges séléctionnés dans un champ caché                    
                    selectedSeatsInput.value = selectedSeats.join(',') ; // Un tableau est converti en chaîne de caractères, délimités par virgules

                    // Nombre de places souhaité exact ?
                    if (selectedSeats.length === nbSeatsMax) {
                        // Réactive, colorie en noir et curseur sur le bouton
                        reserveButton.disabled = false ;
                        reserveButton.style.backgroundColor = "black" ;
                        reserveButton.style.cursor = "pointer" ;
                    } else {
                        // Désactive, colorie en gris clair et curseur interdit sur le bouton
                        reserveButton.disabled = true ;
                        reserveButton.style.backgroundColor = "grey" ;
                        reserveButton.style.cursor = "not-allowed" ;
                    }
                });
            });
        });
</script>
</body>
</html>