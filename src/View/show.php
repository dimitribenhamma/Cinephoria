<!-- La page UI du site show.php (texte pur HTML & PHP dynamique) : Style K&R , Indentation Ok -->
<?php

        // Ce code initialise une session unique et empêche d'être appelée plusieurs fois
        if (session_status() === PHP_SESSION_NONE) {
            session_start() ;
          }
    
        /* Fichiers à inclure */
        include_once ROOT_PATH . $moviesData_path ; // Le fichier de films
        include_once ROOT_PATH . $roomsData_path;
        include_once ROOT_PATH . "/src/View/components/IP.php" ;
        // include_once ROOT_PATH . "/src/View/components/IP.php" ;

        if (!isset($_SESSION['count_seats'])) {
                $_SESSION['count_seats'] = 0 ; // le nombre de places (mémorisé)
          }     

        if (!isset($_SESSION['reservedSeats'])) {
                $_SESSION['reservedSeats'] = [] ;
          }    


        // Récupère les données via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieId = filter_input(INPUT_POST, 'movie_id', FILTER_VALIDATE_INT) ?? null ;  // id du film (mémorisé)
                if ($movieId === false) {
                    error_log("Le format de ID du film n'est pas respecté : " . getUserIP());
                    http_response_code(403);
                    header("Location: index.php?page=$reservationsName");
                    exit("ID film invalide");
                }            

            $schedule = trim(filter_input(INPUT_POST, 'horaire', FILTER_UNSAFE_RAW) ?? '');
                if ($schedule === '') {
                    error_log("Horaire vide : " . getUserIP());
                    header("Location: index.php?page=$reservationsName");
                    exit("Horaire invalide");
                }            
            
            $numRoom = filter_input(INPUT_POST, 'numRoom', FILTER_VALIDATE_INT); // le numéro de salle (masqué)
                if ($numRoom === false) {
                    error_log("Numéro de salle invalide : " . getUserIP());
                    header("Location: index.php?page=$reservationsName");
                    exit("Salle invalide");
                }
            
            $countryChoice = trim(filter_input(INPUT_POST, 'country', FILTER_UNSAFE_RAW) ?? '');   
                if ($countryChoice === false) {
                    error_log("Pays invalide : " . getUserIP());
                    header("Location: index.php?page=$reservationsName");
                    exit("Pays invalide");
                }

            $cityChoice = trim(filter_input(INPUT_POST, 'city', FILTER_UNSAFE_RAW) ?? '');
                if ($cityChoice === false) {
                    error_log("Ville invalide : " . getUserIP());
                    header("Location: index.php?page=$reservationsName");
                    exit("Ville invalide");
                }

            // Copie pratique
            $capacity = (int) $rooms[$countryChoice][$cityChoice]['salles'][$numRoom];
            $remainingSeats = $capacity - $_SESSION['count_seats'];

            $nbSeats = filter_input(INPUT_POST, 'seats', FILTER_VALIDATE_INT);
                if (($nbSeats < 1) || ($nbSeats > $remainingSeats)) {
                    error_log("Le format du nombre de sièges n'est pas respecté : " . getUserIP());
                    header("Location: index.php?page=$reservationsName");
                    exit("Le format du nombre de sièges n'est pas respecté");
                }

            $dateFilm = trim(filter_input(INPUT_POST, 'Date_Film', FILTER_UNSAFE_RAW) ?? '');

            $dt = DateTime::createFromFormat('Y-m-d', $dateFilm);
                if (!$dt) {
                    error_log("Date obligatoire : " . getUserIP());
                    header("Location: index.php?page=$reservationsName");
                    exit("Date obligatoire");
                } 
                if ($dt->format('Y-m-d') !== $dateFilm) {
                    error_log("Date invalide : " . getUserIP());
                    header("Location: index.php?page=$reservationsName");
                    exit("Date invalide");
                }

            $today = new DateTime('today');
                if ($dt < $today) {
                    error_log("Date limite passée : " . getUserIP());
                    header("Location: index.php?page=$reservationsName");
                    exit("Impossible de réserver une date passée");
                }
            

           /* foreach ($films as $film) {
                if ($movieId === $film['id']) {
                    $dateLimite = DateTime::createFromFormat('Y-m-d', $film['date_limite']);                    
                        if (!$dateLimite) {
                            error_log("Film introuvable : " . getUserIP());
                            header("Location: index.php?page=$reservationsName");
                            exit("Film introuvable");
                        }
                        if ($dateLimite->getTimestamp() < $dt->getTimestamp()) {
                                error_log("Date limite dépassée : " . getUserIP());
                                header("Location: index.php?page=$reservationsName");
                                exit("Date invalide");
                        }
                        break;
                }
            } */
           
                $_SESSION['movie_id'] = $movieId;
                $_SESSION['seats'] = $nbSeats;
                $_SESSION['horaire'] = $schedule;
                $_SESSION['room'] = $numRoom;
                $_SESSION['country'] = $countryChoice;
                $_SESSION['city'] = $cityChoice;
                $_SESSION['date'] = $dt->format('Y-m-d');
            

            if (!isset($_SESSION['id'])) {
                header("Location: index.php?page=login");
                exit;
            }
        }
        
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (
        !isset($_SESSION['movie_id'], $_SESSION['seats'], $_SESSION['horaire'],
                $_SESSION['room'], $_SESSION['country'], $_SESSION['city'])
    ) {
        header("Location: index.php?page=reservations");
        exit("Données invalides");
    }

        $movieId = (int) $_SESSION['movie_id'];
        $nbSeats = (int) $_SESSION['seats'];
        $schedule = $_SESSION['horaire'];
        $numRoom = (int) $_SESSION['room'];
        $countryChoice = $_SESSION['country'];
        $cityChoice = $_SESSION['city'];
        $dateFilm = $_SESSION['date'];

        $capacity = (int) $rooms[$countryChoice][$cityChoice]['salles'][$numRoom];
        $remainingSeats = $capacity - $_SESSION['count_seats'];
    }               

    /* Lorsqu'1 place ou plus a été demandée */            
        if (($nbSeats > 0) && ($nbSeats <= $remainingSeats)) {
            // Initialisation
            $totalPrice = $nbSeats * $PRICE_SEAT ;
            $_SESSION['sum'] = $totalPrice ;
            $_SESSION['seats'] = $nbSeats ;
            // Le nombre de places des clients
            $_SESSION['count_seats'] += $nbSeats ;
        }
        else {
            error_log("Le format du nombre de sièges n'est pas respecté : " . getUserIP());
            http_response_code(403);
            header("Location: index.php?page=$reservationsName");
            exit("Le format du nombre de siège n'est pas respecté");
        }

    /* Lorsqu'un film valide a été sélectionné */

        if (($movieId > 0) && ($movieId < count($films)) && (is_int($movieId))) {
            // Initialisation
            $_SESSION['movie_id'] = $movieId ;
        }
        else {
            error_log("Le format de l'ID du film n'est pas respecté : " . getUserIP());
            http_response_code(403);
            header("Location: index.php?page=$reservationsName");
            exit("Le format de l'ID du film n'est pas respecté");
        }
            
    /* Lorsqu'une salle valide a été sélectionné */

        if (array_key_exists($numRoom, $rooms[$countryChoice][$cityChoice]['salles'])) {

            // Initialisation
            $_SESSION['salle'] = $numRoom;
        }
        else {
            error_log("Salle non autorisée : " . getUserIP());
            header("Location: index.php?page=$reservationsName");
            exit("Salle invalide");
        }
        
    /* Lorsqu'une salle valide a été sélectionné */
            $schedules = array_map('trim', explode(',', $films[$movieId - 1]['schedules']));
        if (in_array($schedule, $schedules, true)) {

            // Initialisation
            $_SESSION['horaire'] = $schedule;
        }
        else {
            error_log("Horaire non autorisé : " . getUserIP());
            header("Location: index.php?page=$reservationsName");
            exit("Horaire invalide");
        }
        
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
        <body data-nbseats="<?= (int)$nbSeats ?>" data-movieid="<?= (int)$movieId ?>">	
                <?php		    	  		
                    // Le header et le menu-admin sont à inclure sur chaque page
                    include_once ROOT_PATH . $header_path ;                   		  			
                
                // Inclu le menu admin si le visiteur est admin ou employé
                if (!$roleCustomer) {		  			
                    include_once ROOT_PATH . $menuAdmin_path ;
                    }
                ?>
            
            <main> 
                <!-- Conteneur centré -->  
                <div class="center">	
                        <div class="title-reserve"><?= $titleContact ; ?></div>                        
                        
                    <?php
                        
                        
                    /* Positionner les sièges pour réserver */   

                        // Initialisation des données
                        $nb_rangée = 10 ; // nombre de rangées
                        $pas = 2 ; // écart de croissance

                        // initialisation des rangées de sièges

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
                    $reservedSeats = $_SESSION['reservedSeats'];
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
                        $_SESSION['seats'] = $nbSeats;
                    ?>
                    </div>
                    <!-- formulaire de validation -->             
                    <form method="POST" action="index.php?page=cart">
                        <!-- champ caché liste JavaScript -->
                        <input type="hidden" name="selected_seats" id="selectedSeatsInput">
                        <input type="hidden" name="capacity" value="<?= $capacity ?>">
                        <!-- bouton réserver -->
                        <button type="submit" id="reserveButton-<?= $movieId ?>" disabled
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
        
        <!-- Partie Javascript -->
        <script src="/js/show.js"></script>
    </body>
</html>