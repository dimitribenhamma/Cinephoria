<?php	
	// Nos requêtes SQL sont prêtes
	$registration = 'SELECT id FROM `client` WHERE id = :id' ; // Inscription (Controller)
	$registered = 'SELECT id FROM `client` WHERE user = :user OR email = :email' ; // Réservations (Controller)
	$login = 'SELECT id,user,email,password,role_id FROM `client` WHERE email = :email' ; // Login (Controller)
	$delete = 'DELETE FROM `client` WHERE email = :email' ; // Suppression de compte (Controller)
	$password = 'SELECT id,email FROM `client` WHERE email = :email' ; // Mot de passe oublié (Controller)
	$users = 'SELECT id,nom,prenom,user,email,date_inscription FROM `client`' ; // Utilisateurs (Controller)
	$cookies = 'INSERT INTO `cookies` (`user`, `navigateur`, `langue`, `pays`, `ville`, `isp`, `latitude`, `longitude`, `ip`, `visites`) VALUES (:user, :navigateur, :langue, :pays, :ville, :isp, :latitude, :longitude, :ip, :visites)' ; // Cookie (Controller)
	$test = 'SELECT id,user,email FROM `client`' ; // Tests (Serveur)
?>