<?php

    if (!defined('ROOT_PATH')) {
		die('Accès direct interdit 🚫');
	}

	class Footer {
			
			    private string $phone = "+33 6 31 85 79 07";
				private string $name = "Dimitri BENHAMMA";
				private string $year = "2025";
				private string $promo = "ARGYROS";
				private string $flag = "img/flags/france.png";
				private string $logo = "img/logo studi.png";


		public function addItem(string $label): void {
			echo $label;
		}

		// Getters
		public function getPhone(): string {
			return $this->phone;
		}

		public function getName(): string {
			return $this->name;
		}

		public function getYear(): string {
			return $this->year;
		}

		public function getPromo(): string {
			return $this->promo;
		}

		public function getFlag(): string {
			return $this->flag;
		}

		public function getLogo(): string {
			return $this->logo;
		}
}

		// Créé les items POO
		$footer = new Footer();
		
?>
<div class="footer">
	<div class="cine-min">
		<?php $footer->addItem($footer->getPhone()); ?> &nbsp; &nbsp;
		<img src="<?php $footer->addItem($footer->getFlag()); ?>" width="30px" height="20px" />
	</div>
	<div class="cine-min">
		<?php $footer->addItem($footer->getName()); ?>
	</div>
	<div class="cine-min">
		<span class="footer-year">
			<?php $footer->addItem($footer->getYear()); ?>
			<span class="footer-promo">
				<?php $footer->addItem($footer->getPromo()); ?>
			</span>
		</span>
		<img src="<?php $footer->addItem($footer->getLogo()); ?>" class="footer-logo" width="140px" height="40px" />
	</div>

	<div class="cine-max">
		<?php $footer->addItem($footer->getPhone()); ?>
	</div>
	<div class="cine-max">
		&nbsp; &nbsp;
	</div>
	<div class="cine-max">
		<?php $footer->addItem($footer->getName()); ?>
	</div>

</div>