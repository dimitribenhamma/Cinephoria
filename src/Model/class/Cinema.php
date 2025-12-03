<!-- Class Cinema.php -->
<?php

// Utilisation de classes
	class Cinema {

		
		private string $ville;
		private string $telephone;
		private string $adresse;
		private string $codePostal;
		private string $pays;
		private string $horaires;


		public function __construct(string $ville, string $telephone, string $adresse, string $codePostal, string $pays, string $horaires) {
			$this->ville = $ville;
			$this->telephone = $telephone;
			$this->adresse = $adresse;
			$this->codePostal = $codePostal;
			$this->pays = $pays;
			$this->horaires = $horaires;
	
		}

		public function getVille(): string { return $this->ville; }
		public function getPays(): string { return $this->pays; }
		public function getAdresse(): string { return $this->adresse; }
		public function getTelephone(): string { return $this->telephone; }
		public function getCodePostal(): string { return $this->codePostal; }	
		public function getHoraires(): string { return $this->horaires; }		

		public function getInfos(): string {
			return "Cinéma {$this->ville}<br/>" .
				"Horaires : {$this->horaires}<br/>" .				
				"{$this->adresse}<br/>" .
				"{$this->codePostal} {$this->ville} ({$this->pays})<br/>" .
				"Téléphone : {$this->telephone}"
				;
		}
}



	class CinemaManager {
		
		// On recopie : la ville => données du cinéma de cette ville
		private array $cinemas = [];

		public function __construct(array $data) {
			foreach ($data as $pays => $listeVilles) {
				foreach ($listeVilles as $ville => $cinema) {
					$this->cinemas[$ville] = new Cinema(
						$cinema['Ville'],
						$cinema['Téléphone'],
						$cinema['Adresse'],
						$cinema['Code Postal'],
						$pays,
						$cinema['Horaires']					
					);
        		}
   			 }
		}

		public function getCinemas(): array {
			return $this->cinemas;
		}

		public function getCinema(string $ville): ?Cinema {
			return $this->cinemas[$ville] ?? null;
		}
	}
    ?>