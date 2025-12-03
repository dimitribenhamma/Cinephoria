<!-- Classe RegistrationForm.php : style K&R , indentation Ok -->
 <?php 	
      /* On inclut les scripts de classes nécéssaires */
      include_once ROOT_PATH . $formField_path;		
			
/* Utilisation de classe (Orienté objet) */
class RegistrationForm {

    /* Variables de classe */
		private string $action;
		private array $fields = [];

    /* Constructeur d'objet */
		public function __construct(string $action) {
			$this->action = $action;
		}

    /* La methode qui ajoute un champ de formulaire à la variable de tableau $fields[] */
		public function addField(FormField $field): void {
			$this->fields[] = $field;
		}

    /* La methode qui renvoie le formulaire avec les champs ajoutés */
		public function render(): string {
			$fieldsHtml = '';
			$title = "Inscription";
			$error = "Une erreur est survenue , veuillez réessayer";
			foreach ($this->fields as $field) {
				$fieldsHtml .= $field->render();
			}
			  // Prépare le message d'erreur
        $errorHtml = '';
          if (isset($_SESSION['errorRegistration']) && $_SESSION['errorRegistration'] === true) {
             $errorHtml = '<div style="font-size:16px;padding-top:5px;padding-bottom:15px;color:red">'
                         . $error .
                          '</div>';
                        }
          // Prépare le formulaire de retour (on n'utilise pas de syntaxe heredoc ici)
          $form = '<form method="POST" action="' . $this->action . '" class="form">
                <h2 style="font-size:36px">' . $title . '</h2>
                <div class="grille">' . $fieldsHtml . '</div>
                <button type="submit" class="buttons-text" style="cursor: pointer;">' . $title . '</button>
              </form>';

          return $form;    
		}
	}
?>