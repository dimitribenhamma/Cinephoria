<?php    

    $id_path = '/src/View/components/identifiants.php';
    include_once ROOT_PATH . $id_path;
    $duration = 3600; // vaudra 1 heure (* 24 * 365 : pour 1 an)
    

        // fonctions utilitaires
    	// obtenir l'IP de la machine
    include_once ROOT_PATH . $ip_path;

		// Obtenir le booléen du protocole en HTTPS de la machine (navigateur + OS)
	function isHTTPS() {
        $port = 443;
    	return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] === $port));
	}

		// Obtenir les données sur la géolocalisation de l'IP 
	function getGeoInfo($ip) {
        // Notre chemins d'api
        $geo_url = "http://ip-api.com/json/";
		$url = $geo_url . $ip;
		$response = file_get_contents($url);
		return json_decode($response, true);
}

   /* les paramètres des cookies de session */
	// Infos de base
	$browser  = $_SERVER['HTTP_USER_AGENT'];
	$date     = date("Y-m-d H:i:s");
	$ip       = getUserIP();
	$protocol = isHTTPS() ? 'HTTPS' : 'HTTP';
	$geo      = getGeoInfo($ip);
	$user     = 'client';

	$visits = isset($_COOKIE['visites']) ? $_COOKIE['visites'] + 1 : 1;


	// créé le tableau stocké dans le cookie
if ($geo && $geo['status'] === 'success') {
    $tableau = [
        'browser'  => $browser,
        'date'     => $date,
        'visits'   => $visits,
        'ip'       => $ip,
        'user'     => $user,
        'langue'   => 'fr',
        'country'  => $geo['country'],
        'city'     => $geo['city'],
        'isp'      => $geo['isp'],
        'latitude' => $geo['lat'],
        'lon'      => $geo['lon']
    ];
} else {
    $tableau = [
        'browser' => $browser,
        'date'    => $date,
        'visits'  => $visits,
        'ip'      => $ip,
        'user'    => $user,
        'langue'  => 'fr'
    ];
}
	
		
/* créé le cookie version plus lisible et portable */

// Vérifie si l'utilisateur a déjà accepté ou refusé les cookies
$cookies_accepted = isset($_COOKIE['cinephoria']);
$cookies_refused  = isset($_COOKIE['refuse']);

	// Traitement du formulaire (si bouton soumis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Clé secrète pour signature HMAC (si besoin)
    $secret_key = $_ENV['HMAC_SECRET'];
	
	// Génère un tableau à adapter
    // le format json (obligatoire)
   
    $tableau_json = json_encode($tableau);

    // On rajoute une signature HMAC ET la clé secrète dans un dépôt public (HMAC_SECRET)
	// pour que l'utilisateur ne puisse falsifier le cookie, mais est
	// décodable par nos développeurs
    $signature = hash_hmac('sha256', $tableau_json, $secret_key);
    $cookie_value = base64_encode($tableau_json) . '.' . $signature;
	// Evidemment, on évite d’y stocker login, mot de passe, email, etc.	

  
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');


    // L'utilisateur accepte : création du cookie cinephoria
    if (isset($_POST['accept_cookies'])) {
        setcookie("cinephoria", $cookie_value, [
            'expires'  => time() + $duration,
            'path'     => '/',
            'secure'   => isHTTPS(), // c'est true en prod HTTPS
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    if (isset($_POST['refuse_cookies'])) {
        setcookie("refuse", $cookie_value, [
            'expires'  => time() + $duration,
            'path'     => '/',
            'secure'   => isHTTPS(), // c'est true en prod HTTPS
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    // Recharge la page pour appliquer le cookie
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

?>

