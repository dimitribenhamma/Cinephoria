<!-- La page ip.php : Style K&R , indentation Ok -->
<script>
/* Résolution d’écran en PHP */
  var width = screen.width;
  var height = screen.height;

  fetch('IP.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'width=' + width + '&height=' + height
  });
</script>
<?php
/* Nom des fonctions utilitaires : 
	 * - getUserIP,
	 * - isHTTPS, 
	 * - getGeoInfo,
	 * - decrypt_cookie.
	 **/ 

					// La date à l'instant T en français
					function date_fr() {
						$date = new DateTime('now', new DateTimeZone('Europe/Paris'));
						$formatter = new IntlDateFormatter(
							'fr_FR',
							IntlDateFormatter::FULL,
							IntlDateFormatter::NONE,
							'Europe/Paris',
							IntlDateFormatter::GREGORIAN,
							'EEEE d MMMM y'
						);

						return mb_convert_case($formatter->format($date), MB_CASE_TITLE, 'UTF-8');
					}


					function dateBirth_fr($dateBirth) {
						if (empty($dateBirth)) {
							return null; // ou "Non spécifié" si tu veux un texte
						}

						// Supporte le format français d/m/Y
						$dateObj = DateTime::createFromFormat('d/m/Y', $dateBirth);

						// Si ça ne marche pas, essaye ISO YYYY-MM-DD
						if (!$dateObj) {
							try {
								$dateObj = new DateTime($dateBirth);
							} catch (Exception $e) {
								return null; // ou une valeur par défaut
							}
						}

						$formatter = new IntlDateFormatter(
							'fr_FR',
							IntlDateFormatter::FULL,
							IntlDateFormatter::NONE,
							'Europe/Paris',
							IntlDateFormatter::GREGORIAN,
							'EEEE d MMMM y'
						);

						return mb_convert_case($formatter->format($dateObj), MB_CASE_TITLE, 'UTF-8');
					}


					function getOS() {
							$user_agent = $_SERVER['HTTP_USER_AGENT'];

							$os_array = [
								'/windows nt 10/i'      => 'Windows 10',
								'/windows nt 6.3/i'     => 'Windows 8.1',
								'/windows nt 6.2/i'     => 'Windows 8',
								'/windows nt 6.1/i'     => 'Windows 7',
								'/windows nt 6.0/i'     => 'Windows Vista',
								'/windows nt 5.1/i'     => 'Windows XP',
								'/macintosh|mac os x/i' => 'macOS',
								'/android/i'            => 'Android',
								'/iphone/i'             => 'iOS (iPhone)',
								'/ipad/i'               => 'iOS (iPad)',
								'/linux/i'              => 'Linux',
							];

							foreach ($os_array as $regex => $value) {
								if (preg_match($regex, $user_agent)) {
									return $value;
								}
							}
							return 'OS inconnu';
					}

					function getDeviceType() {
							$userAgent = $_SERVER['HTTP_USER_AGENT'];

							if (preg_match('/tablet|ipad/i', $userAgent)) {
								return 'tablette';
							} elseif (preg_match('/mobile|android|iphone/i', $userAgent)) {
								return 'mobile';
							} else {
								return 'desktop';
							}
						}


					// Obtenir l'IP réele (pas bypassable) attribuée par le FAI (Fournisseur d'Accès à Internet)
                  	function getUserIP() {
								if (!empty($_SERVER['HTTP_CLIENT_IP'])) { // IP avec header Client-IP
									return "IP avec header Client-IP : " . $_SERVER['HTTP_CLIENT_IP'] ;
								} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { // IP multiples (header)
									return "IP avec header 'X-Forwarded-For' : " . $_SERVER['HTTP_X_FORWARDED_FOR'] ;
								} else {
									return $_SERVER['REMOTE_ADDR'] ; // IP réele
								}
							}


					// Obtenir le booléen du protocole installé sur l'OS de la machine : si HTTPS ça renvoie true, sinon false
					function isHTTPS() {
						return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($port_https) && ($_SERVER['SERVER_PORT'] === $port_https))) ;
					}

					// Infos de base des cookies de session
					$ip       = getUserIP() ;
					$protocol = isHTTPS() ? 'HTTPS' : 'HTTP' ; // en prod isHTTPS($ip)

					// Obtenir les données de géolocalisation d'IP
					function getGeoInfo(string $ip): array { // getGeoInfo($ip) (en prod)
					$server_name = $_SERVER['SERVER_NAME'] ?? 'localhost' ;
					$remote_ip = $ip ?: ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1') ;
					if ($server_name === 'localhost' || $remote_ip === '127.0.0.1' || $remote_ip === '::1') {
						// Valeurs par défaut pour dev local
						return [
								'status'  => 'success',
								'country' => 'France',
								'city'    => 'Paris',
								'lat'     => 43.6045,
								'lon'     => 1.444,
								'isp'     => 'Localhost'
								];
					  } 
					else {
					// URL d'API gratuite
						$geo_url = "http://ip-api.com/json/";
						$url = $geo_url; // URL complète : $url = $geo_url . $ip (en prod)
						$response = file_get_contents($url); // le JSON renvoyé par l’API
						return json_decode($response, true); // JSON en tableau associatif PHP
					  }					
					}		

					// Infos de base des cookies de session
						$geo = getGeoInfo($ip); // getGeoInfo($ip) (en prod)					
						$country = (isset($_COOKIE[$_ENV['COOKIE_NAME']])) ? ($geo['country'] ?? 'API#ERROR') : null ;
						$city = (isset($_COOKIE[$_ENV['COOKIE_NAME']])) ? ($geo['city'] ?? 'API#ERROR') : null ;
						$isp = (isset($_COOKIE[$_ENV['COOKIE_NAME']])) ? ($geo['isp'] ?? 'API#ERROR') : null ;
						$lat = (isset($_COOKIE[$_ENV['COOKIE_NAME']])) ? ($geo['lat'] ?? 'API#ERROR') : null ;
						$lon = (isset($_COOKIE[$_ENV['COOKIE_NAME']])) ? ($geo['lon'] ?? 'API#ERROR') : null ;

					function getResolution() {
						if (isset($_POST['width']) && isset($_POST['height'])) {
							$width = $_POST['width'];
							$height = $_POST['height'];
							return "'width=' + width + ' , height=' + height" ;
						}	
					}

					function getBrowserInfo() {
						$ua = $_SERVER['HTTP_USER_AGENT'];

						$browsers = [
							'Edge'   => 'Edg',
							'Chrome' => 'Chrome',
							'Firefox'=> 'Firefox',
							'Safari' => 'Safari',
							'Opera'  => 'OPR'
						];

						foreach ($browsers as $name => $token) {
							if (preg_match('/' . $token . '\/([0-9\.]+)/', $ua, $matches)) {
								return [
									'browser' => $name,
									'version' => $matches[1]
								];
							}
						}

						return [
							'browser' => 'Inconnu',
							'version' => 'Inconnu'
						];
					}

					function visitedPages() {

						$currentPage = $_SERVER['REQUEST_URI'];
						$visitedPages = [];

						if (isset($_COOKIE['visited_pages'])) {
							$visitedPages = json_decode($_COOKIE['visited_pages'], true);
						}

						if (!in_array($currentPage, $visitedPages)) {
							$visitedPages[] = $currentPage;
						}

						/* Tracker une connexion, inscription, etc. */
						$data = json_decode(
							file_get_contents('php://input'),
							true
						);

						$allowedEvents = [
							'login_success',
							'login_failed',
							'registration_success',
							'registration_failed',
							'admin_success',
							'admin_failed',
							'logout'
						];

						$event = [] ;
						$event = $data['event'] ?? 'unknown';

						$log = [
							'event' => $event
						];

						$events = [
							'pages visitées'  => json_encode($visitedPages),
							'event' => $log
						];

						return $events ;
						
						}

					/* La fonction pour déposer un Cookie PHP via setcookie */
					function set_encrypted_cookie(array $data, int $duration) {
						// Clé secrète pour signature HMAC et AES
						$aes_secret  = hex2bin($_ENV['SECRET_KEY']) ; // 32 octets pour AES (dépôt .ENV)
						$hmac_secret = hex2bin($_ENV['HMAC_SECRET']) ; // 32 octets pour HMAC (dépôt .ENV)
						
						
						$json = json_encode($data) ; // Initialisation du tableau PHP de Cookie en chaîne JSON
						$iv = random_bytes(12) ;  // nonce 12 octets aléatoires unique (rendre le chiffrement non déterministe à chaque fois)
						// Chiffrement AES-256-GCM 
            			// le contenu du cookie est illisible côté client
						$tag = '' ; 
						$ciphertext = openssl_encrypt(
										$json,
										'aes-256-gcm',
										$aes_secret,
										OPENSSL_RAW_DATA,
										$iv,
										$tag);
						
						// Cookie = iv | tag | ciphertext
						$payload = $iv . $tag . $ciphertext ;
						// Ajouter HMAC pour double vérification
						$signature = hash_hmac('sha256', $payload, $hmac_secret, true) ;
						// Cookie final : base64(iv|tag|ciphertext|hmac)
						$cookie = base64_encode($payload . $signature) ; // Initialisation du Cookie en chaîne ASCII                        

						// Création du cookie PHP
						if (isset($_ENV['COOKIE_NAME']) && (!empty($_ENV['COOKIE_NAME']))) {
						setcookie($_ENV['COOKIE_NAME'], $cookie, [
							'expires'  => time() + $duration, // durée du cookie
							'path'     => '/', // sur tout le site
							'domain'   => "", // le domaine actuel (en prod .cinephoria.com)
							'secure' => isset($_SERVER['HTTPS']), // true en prod (via HTTPS)
							'httponly' => false, // true en prod (masque le javascript console)
							'samesite' => 'Strict' // prévention CSRF
						]); 
						}						
					}

					// Obtenir le déchiffrement de Cookie selon la valeur accepter/refuser : évidemment, on évite d’y stocker login, mot de passe, email, etc.
					function decrypt_cookie($cookie_value) {
						$aes_secret = hex2bin($_ENV['SECRET_KEY']) ;
						$hmac_secret = hex2bin($_ENV['HMAC_SECRET']) ;
						$raw = base64_decode($cookie_value ?? '') ; //  chaîne ASCII en binaire ou texte

					$iv         = substr($raw, 0, 12) ;
					$tag        = substr($raw, 12, 16) ;
					$ciphertext = substr($raw, 28, -32) ; // reste sauf le HMAC
					$hmac       = substr($raw, -32) ;     // derniers 32 octets					
					$payload    = substr($raw, 0, -32) ; // Vérifier l'HMAC avant de déchiffrer

						if (!hash_equals($hmac, hash_hmac('sha256', $payload, $hmac_secret, true))) {
							throw new Exception('Cookie falsifié ou invalide') ;
							// Exception (en console) 
								?><script>
									console.log(<?= json_encode(($textInvalidException . " : " . $e->getMessage()), JSON_UNESCAPED_UNICODE) ?>) ;
								</script><?php
							}

						$plaintext = openssl_decrypt($ciphertext, 'aes-256-gcm', $aes_secret, OPENSSL_RAW_DATA, $iv, $tag) ;

						if ($plaintext === false) {
							throw new Exception('Déchiffrement échoué') ;
							// Exception (en console) 
								?><script>
									console.log(<?= json_encode(($textDecryptException . " : " . $e->getMessage()), JSON_UNESCAPED_UNICODE) ?>) ;
								</script><?php
							}					
					
						return json_decode($plaintext, true) ; // chaîne en variable , inverse de json_encode (variable PHP en chaîne JSON)
					}

					// Obtenir la langue du navigateur sur 2 caractères
					function language_nav() {					
					$browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'fr', 0, 2) ;
					$supportedLangs = explode(',', $_ENV['SUPPORTED_LANGS'] ?? 'fr');
    				$currentLang = in_array($browserLang, $supportedLangs) ? $browserLang : 'fr' ;
					return $currentLang ;}
?>