<!-- La page d'UI du site bottom.php : Style K&R , indentation ok -->
  <?php	
      // En-tête HTTP
        if (session_status() === PHP_SESSION_NONE) {
            session_start() ;
          }

		// Sécurité contre accès direct aux fichiers internes
		if (!defined('ROOT_PATH')) {
			die('Accès direct interdit 🚫') ;
		}


	// On charge les données
	include_once ROOT_PATH . $cinemaClass_path ;	
	include_once ROOT_PATH . $cinemasData_path ;
	include_once ROOT_PATH . $cinemaSelector_path ; // Notre dropdown de tous les cinémas par leur ville
	
	
    
		// Ville Choisie : priorité à POST, sinon session, sinon "Choisir"
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cinema'])) {
		$choice = $_POST['cinema'] ;
		$_SESSION['cinema'] = $choice ; // Mémorisation en session
	} elseif (isset($_SESSION['cinema'])){
		$choice = $_SESSION['cinema'] ; // Mémorisation en session
		}
	else {
		$choice = $_SESSION['cinema'] ?? 'Choisir' ;
		$_SESSION['cinema'] = $choice ; // Mémorisation en session
	}
	
	// Initialisation méthode et objet
	$manager = new CinemaManager($cinemas) ;
	$cinemaChoice = $manager->getCinema($choice) ;


/* Utilisation de classes */
	class SocialManager {
		// Encapsulé correctement
		private string $name ;
		private string $url ;
		private string $icon ;

		public function __construct(string $name,string $url,string $icon){
			$this->name = $name ;
			$this->url = $url ;
			$this->icon = $icon ;
		}

		public function render(): string {
        $html  = '<div class="bottom-social" style="float:left;margin-left:35%;">' ;
        $html .= '<img src="' . htmlspecialchars($this->icon) . '" width="20px" height="20px" /> ' ;
        if ($this->url !== "#") {
            $html .= '<a href="' . htmlspecialchars($this->url) . '" class="bottom-social">' . htmlspecialchars($this->name) . '</a>' ;
        } else {
            $html .= '<span class="bottom-social">' . htmlspecialchars($this->name) . '</span>';
        }
        $html .= '</div><br/>' ;
        return $html ; 
    }
}



	class InfoLink {
		// Encapsulé correctement
		private string $label;
		private string $link;

		public function __construct(string $label, string $link) {
			$this->label = $label;
			$this->link = $link;
		}

		public function render(): string {
			return '<a href="' . htmlspecialchars($this->link) . '" class="info-link">'
        . '<span class="bottom-info" style="float:left;margin-left:30%;">' . htmlspecialchars($this->label) . '</span>'
        . '</a><br/>';
		}
	}
?>

<!-- La page de bas du site -->
	<div class="grid-under">	
								<?php
									$selector = new CinemaSelector($cinemas, $choice) ;
								?>
							<div class="cine-min" style="line-height:40px;text-align:center;float:left;">
								<b style="color:green"><?= $_ENV['APP_NAME'] ?></b>
								<?= $selector->renderSelect() ?>
								
								<?php if ($cinemaChoiceInfo = $selector->getChosenCinemaInfo()): ?>
									<div class="cinema-info">
										<?= $_ENV['APP_NAME'] . ' ' . htmlspecialchars($cinemaChoiceInfo['Ville']) ?><br>
										<?=  htmlspecialchars($cinemaChoiceInfo['Adresse']) ?><br>
										<?= htmlspecialchars($cinemaChoiceInfo['Code Postal']) . ' ' . htmlspecialchars($cinemaChoiceInfo['Ville']) ?><br>
										<?= htmlspecialchars($cinemaChoiceInfo['Téléphone']) ?><br>
										<?= htmlspecialchars($cinemaChoiceInfo['Pays']) ?>
									</div>
								<?php endif ; ?>
							</div>
	
	<div style="line-height:40px;text-align:center;float:left">
		<span style="float:left;margin-left:30%;color:green"><b><?= $title_column[1] ?></b></span><br/>
		<?php foreach ($info_item as $i =>$name): ?>
		<?php { $info = new InfoLink(
				htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
				htmlspecialchars($info_item_link[$i], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        	) ;  
		?>
		<?=	$info->render() ; ?>
		<?php } ?>
 		<?php endforeach ; ?>
	</div>

	<div style="line-height:40px;"><span style="float:left;margin-left:35%;color:green">
		<b><?= $title_column[2] ?></b></span><br/>
		<?php foreach ($social_item as $i =>$name): ?>
		<?php { $social = new SocialManager(
				htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
				htmlspecialchars($social_item_link[$i], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
				htmlspecialchars($social_item_img[$i], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        	) ;  
		?>
		<?=	$social->render() ; ?>
		<?php } ?>
 		<?php endforeach ; ?>
	</div>
</div>