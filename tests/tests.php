<?php
/**
 * TESTS Diagnostic serveur smoke test / health check (mieux POSTMAN en entreprise)
 *
 */
    $paths_path = "/config/paths.php" ;
    include_once ROOT_PATH . $paths_path ;

	// Charge avant tout les infos sensibles du .env correctement (en front controller)
	include_once ROOT_PATH . '/vendor/autoload.php';
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/..') ;
	$dotenv->load() ; 

    $sql= "/config/sql.php" ;
    include_once ROOT_PATH . $sql ;

    echo "<h1>Tests unitaires</h1>";
        // Connexion au serveur
        echo "<h2>Connexion au serveur</h2>";

        echo "<h3><u>1. Test Session</u></h3>";
        // Test 1: Session
        if (session_status() !== PHP_SESSION_NONE) {    
            echo "<p style='color: green;'>✅ La session est active!</p>";
            echo "<p>Session ID: " . session_id() . "</p>";
        } 
        else {
            echo "<p style='color: red;'>❌ Session inactive!</p>";
        }

        // Test 2: Tests du fichier d'environnement (.env)
        echo "<h3><u>2. Test du .env</u></h3>";
        if (file_exists(ROOT_PATH . '/.env')) {
            echo "✅ Il existe un .env <br>";  
            echo "Environnement: " . (($_ENV['APP_ENV'] !== null) ? $_ENV['APP_ENV'] : 'non défini') . "<br>";
            echo "Base de données: " . (($_ENV['DB_NAME'] !== null) ? $_ENV['DB_NAME'] : 'non défini') . "<br>";
            echo "DB_HOST: " . (($_ENV['DB_HOST'] !== null) ? $_ENV['DB_HOST'] : 'non défini') . "<br>";
            echo "DB_NAME: " . (($_ENV['DB_NAME'] !== null) ? $_ENV['DB_NAME'] : 'non défini') . "<br>";
            echo "DB_USER: " . (($_ENV['DB_USER'] !== null) ? $_ENV['DB_USER'] : 'non défini') . "<br>";
            echo "DB_PASS: " . (($_ENV['DB_PASS'] !== null) ? $_ENV['DB_PASS'] : 'non défini') . "<br>";
            echo "DB_PORT: " . (($_ENV['DB_PORT'] !== null) ? $_ENV['DB_PORT'] : 'non défini') . "<br>";
        } 
        else {
            echo "❌ Le .env n'existe pas !<br>";
        }
        echo "<br>";
        echo "<hr>";


        // Configuration de PHP
        echo "<h2>PHP</h2>";
        // Test 1: Configuration de PHP
        echo "<h3><u>1. Configuration de PHP</u></h3>";
        echo "PDO: " . (extension_loaded('pdo') ? '✅ Installé' : '❌ MANQUANT') . "<br>";
        echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? '✅ Installé' : '❌ MANQUANT') . "<br>";
        echo "MySQLi: " . (extension_loaded('mysqli') ? '✅ Installé' : '❌ MANQUANT') . "<br>";

        echo "<hr>";

        // Connexion à la base
        echo "<h2>Base de données</h2>";
        try {

            $conn = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']) ;
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
            echo "<h3><u>1. Connexion</u></h3>";
            if($conn){  
            // Test 1: Base accessible                              
            echo "<p style='color: green;'>✅ Connexion réussie!</p>";                    
            $stmt = $conn->prepare("SHOW TABLES");
            $stmt->execute();
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            // Test 2: Vérification des tables
            echo "<h3><u>2. Tables</u></h3>";
                if (count($tables) > 0) {
                        echo "<p style='color: green;'>✅ Des Tables existent dans la base!</p>";
                        echo "<h3>TABLES dans la base:</h3>";
                        echo "<ul>";
                    foreach ($tables as $table) {
                        echo "<li>$table</li>";
                    }
                        echo "</ul>";
                    } 
                    else {
                        echo "⚠️ La Base est vide (il manque les tables !)<br>";
                    }
        
            $stmt = $conn->query($test);
            $users = $stmt->fetchAll();            
                    foreach ($tables as $table) {                          
                        echo "<h3>TABLE " . $table . ":</h3>";
                        
            $stmt = $conn->query("SELECT * FROM `$table` ORDER BY id ASC");
            $recs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($recs)) {
                echo "<ul>";
                echo "<li><em>Table vide</em></li>";
                echo "</ul>";
            } 
            else {
                    foreach ($recs as $rec) {
                        if (!empty($rec)) {
                            if ($table === 'client'){
                                echo "<ul>";
                                echo "<li><strong>{$rec['id']}</strong> | {$rec['user']} - email : ({$rec['email']})</li>";
                                echo "</ul>";
                            }
                            if ($table === 'cookies'){
                                echo "<ul>";
                                echo "<li><strong>{$rec['id']}</strong> ({$rec['ip']}) - user : {$rec['user']}</li>";
                                echo "</ul>";
                            }
                            if ($table === 'reservation'){
                                echo "<ul>";
                                echo "<li><strong>{$rec['id']}</strong> ({$rec['movie_id']}) - date : {$rec['date_reservation']}</li>";
                                echo "</ul>";
                            }
                            if ($table === 'roles'){
                                echo "<ul>";
                                echo "<li><strong>{$rec['id']}</strong> | rôle : {$rec['nom']}</li>";
                                echo "</ul>";
                            }

                    }
                    }   }
                    } 

            // Test 3: Admin
            echo "<h3><u>3. Admin</u></h3>";
            $stmt = $conn->prepare("SELECT id, user, email, role_id FROM client WHERE role_id = ?");
            $stmt->execute(['3']);
            $user = $stmt->fetch();
            
                if ($user) {
                    echo "<p style='color: green;'>✅ Le rôle Admin existe dans la base!</p>";
                    echo "<pre>";
                    echo "ID: " . $user['id'] . "\n";
                    echo "Username: " . $user['user'] . "\n";
                    echo "Email: " . $user['email'] . "\n";
                    echo "Role: " . $user['role_id'] . "\n";
                    echo "</pre>";                          
                }
                else {
                    echo "<p style='color: red;'>❌ Le Rôle Admin n'existe pas dans la base!</p>";
                    echo "<hr>";
                }
            echo "<hr>";
            }
        }

        // On récupère les exceptions levées
        catch (PDOException $e) {
            echo "<p style='color: red;'>❌ Erreur: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
