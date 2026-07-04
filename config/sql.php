<!-- La page des requêtes SQL -->
 <?php	
	// Our SQL queries are ready
	$registration = 'SELECT Id FROM `Client` WHERE Id = :id' ; // Registration (Controller)
	$registered = 'SELECT Id FROM `Client` WHERE Username = :username OR Email = :email' ; // Reservation (Controller)
	$login = 'SELECT Id,Username,Email,Password,Role_Id FROM `Client` WHERE Email = :email' ; // Login (Controller)
	$password = 'SELECT Id,Email FROM `Client` WHERE Email = :email' ; // Password (Controller)
	$cookie_output = 'SELECT * FROM `Cookies` WHERE Client_Cookies_Id = :id' ; // Cookies (Controller)
	/* INSERT */
	$cookies = 'INSERT INTO `Cookies` (`Client_Cookies_Id`,`Consent`,`Cookie_Name`,`Username`,`Device`,`Platform`,`Browser`,`BrowserVersion`,`Language`,`Timezone`, `Country`, `City`, `Isp`, `Latitude`, `Longitude`, `Ip`, `Events`, `Visits`, `Role`, `Cookie_Date`) VALUES (:Client_cookies_id, :Consent, :Cookie_name, :Username, :Device, :Platform, :Browser, :BrowserVersion, :Language, :Timezone, :Country, :City, :Isp, :Latitude, :Longitude, :Ip, :Events, :Visits, :Role, :Cookie_date)' ; // Cookie (Controller)
	$registrationController = 'INSERT INTO `Client` (Name, Surname, Username, Password, Email, Date_Registration, Role_Id) VALUES (:name, :surname, :username, :password, :email, :date_registration, :role_id)' ; // Registration (Controller)
	$Resa = 'INSERT INTO `Booking` (Client_Id, Movie_Id, Seats, Horaire, Date_Reservation) VALUES (:client_id, :movie_id, :seats, :horaire, :date_reservation)'; // 
	/* DELETE */
	$deleteCookie = 'DELETE FROM `Cookies` WHERE Id= :id'; // Cookies (Controller)
	
	// Verify below //
	$delete = 'DELETE FROM `Client` WHERE Email = :email' ; // Identity (Controller)
	$users = 'SELECT Id,Name,Surname,Username,Email,Date_Registration FROM `Client`' ; // Users (Server)
	$test = 'SELECT Id,Username,Email FROM `Client`' ; // Tests (Server)
?>