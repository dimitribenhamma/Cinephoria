<!-- Page d'UI show.php (texte pur HTML & PHP dynamique) style K&R , indentation Ok -->
<?php
        // Le code empêche une nouvelle session d’être appelée plusieurs fois
        if (session_status() === PHP_SESSION_NONE) {
            session_start() ;
        }

        // Le fichier des films projetés
        include_once ROOT_PATH . $movies_data_path ;

        // Récupère les données de $_POST[]
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filmId = $_POST['movie_id'] ?? null; // id unique
            $nbSeats = (int)($_POST['seats'] ?? 0) ; // nombre de places salle
            $salle = $_POST['salle'] ?? null ; // numéro de salle (masqué)
        }

        // Initialisation
        if (!isset($_SESSION['count_seats'])) {
                $_SESSION['count_seats'] = 0 ;
        }


    /* Poursuites de code : si un film a été sélectionné et au moins 1 place a été demandée */

        if ($filmId && $nbSeats > 0) {

            /* Initialisation */

            // Le nombre de siège(s) d'un client
            $_SESSION['seats'] = $nbSeats ;
            $title = "Réservation de " . $_SESSION['seats'] . " place" . (($_SESSION['seats'] > 1) ? 's' : '') ;    
            $subtitle = $films[$filmId - 1]['titre'] ;
            // Le nombre de sièges des clients
            $_SESSION['count_seats'] += $nbSeats ;  

            // La liste des sièges d'un client
            if (!isset($_SESSION['reservedSeats'])) {
                $_SESSION['reservedSeats'] = [] ;
            }

            /* La liste de tous les sièges réservés */
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Récupère les sièges sélectionnés
                $selectedSeats = $_POST['selected_seats'] ?? '' ;
                $selectedSeatsArray = array_filter(explode(',', $selectedSeats)) ;

                // Ajoute aux sièges déjà réservés
                $_SESSION['reservedSeats'] = array_unique(array_merge($_SESSION['reservedSeats'], $selectedSeatsArray)) ;
                }

                // Liste de tous les sièges réservés
                $reservedSeats = $_SESSION['reservedSeats'] ;
?>
<!-- DOCTYPE déclare du HTML → navigateur lit le HTML → DOM est créé → affichage navigateur correct -->
<!DOCTYPE html> 
<!-- Le HTML DOM (Document Object Model) construit l'arbre d’objets avec chaque élément HTML manipulable par JavaScript -->
<html lang="fr">
    <!-- Head contient les dépendances d’une page HTML, pas le contenu affiché -->
        <head>  
            <!-- On y inclu les metas essentielles d'indexation -->
            <?php 
                include_once ROOT_PATH . $meta_path ;
            ?>
            <!-- Notre fichier .env est situé à la racine du projet -->
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
            <!-- Le bloc main contient des recommendations d'accessibilité et aide aide les lecteurs d’écran et les moteurs de recherche à comprendre où commence le contenu principal -->
            <main>   
                <div class="center">	
                        <div class="title-reserve"><?= $title ; ?></div>
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
            <!-- Partie php du bandeau noir en bas -->				
                <?php include_once ROOT_PATH . $footer_path ; 
        } ?>
        
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