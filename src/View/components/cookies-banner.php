    <!-- La page cookies-banner.php : Style K&R , indentation Ok -->
    <?php    
        /* 
        * Pour déposer un Cookie encrypté : 
        ** - Vérifications du choix de l'utilisateur, 
        ****** 1. s'il accepte :
        ** - initialisation du tableau des données géolocalisées,
        ****** 2. s'il refuse :
        ** - initialisation du tableau des données non-géolocalisées,
        ****** Enfin :
        ** - création du cookie encrypté,
        ** - dépôt du cookie encrypté en BDD serveur, sur la machine cliente en JS.
        *
        */
        
            // Ce code initialise une session unique et empêche d'être appelée plusieurs fois
            if (session_status() === PHP_SESSION_NONE) {
                session_start() ;
            }

            /* Donnée de départ */
            $paths = "paths" ;
            $paths_path = "/config/$paths.php" ;
            include_once ROOT_PATH . $paths_path ;
            include_once ROOT_PATH . "/src/View/components/IP.php" ;
            $currentLang = language_nav() ;
            include_once ROOT_PATH . "/lang/$currentLang.php" ;




            /* Fichiers à inclure */
            include_once ROOT_PATH . $exceptionHandle_path; // Obtenir logs Apache + console

    try {                    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST est une méthode PHP (côté serveur)
        
            if (isset($_POST['accept_cookies'])) {
                // Un nom de Cookie accepté
                $valueCookie = true ;
                $_SESSION['COOKIE'] = true ;      
                }
            elseif (isset($_POST['refuse_cookies'])) {
                // Un autre nom de Cookie refusé
                $valueCookie = false ;
                $_SESSION['COOKIE'] = false ;
                }            
            
            else {
                $valueCookie = null ;                
            }                  
                                              
        /* Collecter, sécuriser le bon Cookie puis l'enregistrer en BDD et enfin le déposer sur la machine cliente (et côté console) */            
            $tableau = [] ;

                if ($valueCookie === false) {

                        /* Le tableau optimal d'initialisation pour un Cookie PHP */
                            
                            // Appel à la fonction pré-initialisée "geo" (de géolocalisation)
                             $tableau = [
                                $labelClientCookiesId   => $_SESSION['id'] ?? null,
                                $labelConsent           => 'false', // Comment le relier en base de données ????
                                $labelCookieName        => null,
                                $labelUserName          => $textUser, // "visiteur" par défaut
                                $labelDevice            => null,
                                $labelPlatform          => null,
                                $labelBrowser           => null,
                                $labelBrowserVersion    => null,    
                                $labelLanguage          => $langue, // Accessibilité
                                $labelTimezone          => $timezone, // Fuseau horaire
                                $labelCountry           => null,
                                $labelCity              => null,
                                $labelIsp               => null,
                                $labelLatitude          => null,
                                $labelLongitude         => null,
                                $labelIp                => null,
                                $labelEvents            => null,
                                $labelVisits            => null,
                                $labelRole              => null,
                                $labelCookieDate        => $current_date . ' ' . date("H:i:s") // Dernière visite
                            ]; 
                            
                        // Cookie "cinephoria" serveur (créé, encrypté, sécurisé) selon accepter/refuser : évidemment, on évite d’y stocker login, mot de passe, email, etc.)
                            set_encrypted_cookie($tableau, $duration_cookie) ;
                            

                        /* Obtenir les données de Cookie dans une bdd */
                            include_once ROOT_PATH . $cookieController_path ;
                            
                    }

                elseif ($valueCookie === true) {

                            $tableau = [
                                $labelClientCookiesId   => $_SESSION['id'] ?? null,
                                $labelConsent           => 'true',
                                $labelCookieName        => $_ENV['COOKIE_NAME'],
                                $labelUserName          => $textUser, // "visiteur" par défaut
                                $labelDevice            => $device, // Type d'appareil
                                $labelPlatform          => $platform, // Plateforme
                                $labelBrowser           => $browserInfo['browser'], // Sécurité : "fr" , "de" ou "nl" (côté serveur)
                                $labelBrowserVersion    => $browserInfo['version'], // Version navigateur                             
                                $labelLanguage          => $langue, // Accessibilité
                                $labelTimezone          => $timezone, // Fuseau horaire                                                                
                                $labelCountry           => $country, // Contenu localisé
                                $labelCity              => $city, // Analytics
                                $labelIsp               => $isp, // Sécurité (bot, proxy, VPN)
                                $labelLatitude          => $lat, // Cartographie
                                $labelLongitude         => $lon, // Cartographie                                                                
                                $labelIp                => $ip, // IP (identité sur Internet)
                                $labelEvents            => visitedPages(), // Pages visitées ET données de conversions
                                $labelVisits            => $visits, // Fréquence
                                $labelRole              => null,
                                $labelCookieDate        => $current_date . ' ' . date("H:i:s") // Dernière visite
                            ] ;     
                            
                    // Cookie "cinephoria" serveur (créé, encrypté, sécurisé) selon accepter/refuser : évidemment, on évite d’y stocker login, mot de passe, email, etc.)
                        set_encrypted_cookie($tableau, $duration_cookie) ;

                    /* Obtenir les données de Cookie dans une bdd */
                        include_once ROOT_PATH . $cookieController_path ; 
                        
                    }                               
                }    
        
        // Ici on utilisera un booléen pour tester la présence de Cookie (accès direct bloquant)
        if (!isset($_SESSION['COOKIE'])) {

                        // Aucune action de Cookie et la page continue normalement    

                                /* Bannière de consentement Cookies (RGPD) */
                                ?>
                                        <div id="cookies-banner" class="cookies">
                                            <span class="cookies-text"><?= $textBanner ?></span>
                                                <form method="POST" action="" class="form-cookies">
                                                    <button type="submit" id="accept" name="accept_cookies" class="cookies-style"><?= ucfirst($accept) ?></button>
                                                    <button type="submit" id="refuse" name="refuse_cookies" class="cookies-style"><?= ucfirst($refuse) ?></button>
                                                </form>
                                        </div>
                                <?php
                                }
           

        }
  
        
        catch (Exception $e) {
                    // Journal de log Apache
                    error_log($textCookieException . " : " . $e->getMessage()) ;
                    if (isset($_COOKIE[$_ENV['COOKIE_NAME']])) {
                            setcookie($_ENV['COOKIE_NAME'], '', time() - $duration_cookie, '/');
                        }
                    // Exception (en console) 
                    ?><script>
                            console.log(<?= json_encode(($textCookieException . " : " . $e->getMessage()), JSON_UNESCAPED_UNICODE) ?>) ;
                        </script><?php
            }        
        
    ?>