<!-- Classe ContactForm.php : style K&R , indentation Ok -->
 <?php 	
      /* On inclut les scripts de classes nécéssaires */
      include_once ROOT_PATH . $formField_path ;		
			
/* Utilisation de classe (Orienté objet) */
class ContactForm {

    /* Variables de classe */
		private string $action ;
		private array $fields = [] ;

    /* Constructeur d'objet */
		public function __construct(string $action) {
			$this->action = $action ;
		}

    /* La methode qui ajoute un champ de formulaire à la variable de tableau $fields[] */
		public function addField(FormField $field): void {
			$this->fields[] = $field ;
		}

    /* La methode qui renvoie le formulaire avec les champs ajoutés */
		public function render(): string {
			$fieldsHtml = '' ;
			$titleForm = "Formulaire de contact" ;
      $callToAction = "Envoyer" ;
			foreach ($this->fields as $field) {
				$fieldsHtml .= $field->render() ;
			}    

          // Prépare le formulaire de retour (on n'utilise pas de syntaxe heredoc ici)
          $form = '<form method="POST" action="' . $this->action . '" style="margin-left:20px;padding-top:20px;width:100%" id="formContact">
                <h2 style="font-size:36px">' . $titleForm . '</h2>
                <div class="grille">' . $fieldsHtml . '</div>
                <button type="submit" class="buttons-text" style="cursor: pointer;" value="Envoyer">' . $callToAction . '</button>
              </form>' ;

          return $form ;    
		}
	}
?>