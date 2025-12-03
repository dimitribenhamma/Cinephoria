<!-- bottom.php -->
  <?php	

	$title_column = ["Cinéphoria", "Informations", "Retrouvez-nous"];

	$social_item = ["Facebook", "Instagram", "Tmdb"];
	$social_item_link = ["#", "#", "./index.php?page=$tmdbPage"];
	$social_item_img = ["img/social/facebook.png", "img/social/instagram.png", "img/social/tmdb.png"];

	$info_item = ["Contact", "Mentions Légales", "Conditions générales"];
	$info_item_link = ["./contact.php", "#", "#"];	

	if (!defined('ROOT_PATH')) {
		die('Accès direct interdit 🚫');
	}


	// On charge les données
	include_once ROOT_PATH . $cinema_class_path;	
	include_once ROOT_PATH . $cinemas_data_path;
	
	
    
		// Ville choisie : priorité à POST, sinon session, sinon "choisir"
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cinema'])) {
		$choix = $_POST['cinema'];
		$_SESSION['cinema'] = $choix; // mémorisation en session
	} else if (isset($_SESSION['cinema'])){
		$choix = $_SESSION['cinema'];}
	else {
		$choix = $_SESSION['cinema'] ?? 'choisir';
		$_SESSION['cinema'] = $choix;
	}
	

	$manager = new CinemaManager($cinemas);
	$cinemaChoisi = $manager->getCinema($choix);


/* Utilisation de classes */
	class SocialManager {
		
		private string $name;
		private string $url;
		private string $icon;

		public function __construct(string $name,string $url,string $icon){
			$this->name = $name;
			$this->url = $url;
			$this->icon = $icon;
		}

		public function render(): string {
        $html  = '<div style="float:left;margin-left:35%;">';
        $html .= '<img src="' . htmlspecialchars($this->icon) . '" width="20px" height="20px" /> ';
        if ($this->url !== "#") {
            $html .= '<a href="' . htmlspecialchars($this->url) . '" style="text-decoration:none;color:black">' . htmlspecialchars($this->name) . '</a>';
        } else {
            $html .= htmlspecialchars($this->name);
        }
        $html .= '</div><br/>';
        return $html;
    }
}



	class InfoLink {
		private string $label;
		private string $link;

		public function __construct(string $label, string $link) {
			$this->label = $label;
			$this->link = $link;
		}

		public function render(): string {
			return '<a href="' . htmlspecialchars($this->link) . '" style="text-decoration:none;color:black">'
				. '<span style="float:left;margin-left:30%;">' . htmlspecialchars($this->label) . '</span>'
				. '</a><br/>';
		}
	}
?>

<!-- La page de bas du site -->
	<div class="grid-under">	
							<div class="cine-min" style="line-height:40px;text-align:center;float:left">		
								<b><?= $title_column[0] ?></b>
									<form method="POST" id="cinemaForm">										
										<select name="cinema" onchange="document.getElementById('cinemaForm').submit();"> <!-- automatiquement soumis -->
											<option value="choisir" <?= ($choix === "choisir") ? "selected" : "" ?>>Choisir le cinéma</option>											
											<?php foreach($cinemas as $nomPays => $listeCinemas): ?>
												<optgroup label="<?= htmlspecialchars($nomPays) ?>">
													<?php foreach($listeCinemas as $ville => $cinema): ?>
														<option value="<?= htmlspecialchars($ville) ?>" <?= ($choix === $ville) ? "selected" : "" ?>>
															<?= htmlspecialchars($cinema['Ville']) ?>
														</option>
													<?php endforeach; ?>
												</optgroup>
											<?php endforeach; ?>
										</select>
									</form>		
								<?php
									if ($cinemaChoisi): ?>
										<?= $cinemaChoisi->getInfos(); ?>
								<?php endif; 
							?>
							</div>
	

	<div style="line-height:40px;text-align:center;margin-left:-20px;float:left">
		<b style="float:left;margin-left:30%;"><?= $title_column[1] ?></b><br/>
		<?php foreach ($info_item as $i =>$name): ?>
		<?php { $info = new InfoLink(
				htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
				htmlspecialchars($info_item_link[$i], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        	);  
		?>
		<?=	$info->render(); ?>
		<?php } ?>
 		<?php endforeach; ?>
	</div>

	<div style="line-height:40px;"><span style="float:left;margin-left:35%;">
		<b><?= $title_column[2] ?></b></span><br/>
		<?php foreach ($social_item as $i =>$name): ?>
		<?php { $social = new SocialManager(
				htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
				htmlspecialchars($social_item_link[$i], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
				htmlspecialchars($social_item_img[$i], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        	);  
		?>
		<?=	$social->render(); ?>
		<?php } ?>
 		<?php endforeach; ?>
	</div>
</div>