<!-- Classe RegistrationForm.php : style K&R , indentation Ok -->
 <?php 	
      /* On inclut les scripts de classes nécéssaires */
      include_once ROOT_PATH . $formField_path;
      include_once ROOT_PATH . $meta_path ;
			
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
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'fr', 0, 2) ?? null ;
        /* On créée les données de type/champ gérées par notre formulaire */

        $msgTitle = ($lang === 'fr') ? "Inscription" : (($lang === 'de') ? "" : "")  ;
        $msgButton = ($lang === 'fr') ? "Inscription" : (($lang === 'de') ? "" : "") ;
        $msgError = ($lang === 'fr') ? "Une erreur est survenue , veuillez réessayer" : (($lang === 'de') ? "" : "") ;
                    
        $labels = [                     
                    'name' => [
                                    'name'     => 'name',
                                    'surname'  => 'surname',
                                    'user'     => 'user',
                                    'email'    => 'email',
                                    'password' => 'password'
                                          ],
                    'label' => [
                                    'name'     => ($lang === 'fr') ? "Nom" : (($lang === 'de') ? "" : "") ,
                                    'surname'  => ($lang === 'fr') ? "Prénom" : (($lang === 'de') ? "" : "") ,
                                    'user'     => ($lang === 'fr') ? "Nom d'utilisateur" : (($lang === 'de') ? "" : "") ,
                                    'email'    => ($lang === 'fr') ? "E-Mail" : (($lang === 'de') ? "" : "") ,
                                    'password' => ($lang === 'fr') ? "Mot de passe" : (($lang === 'de') ? "" : "") 
                                          ],
                    'type' => [
                                    'name'     => 'text',
                                    'surname'  => 'text',
                                    'user'     => 'text',
                                    'email'    => 'email',
                                    'password' => 'password'
                                          ],                      
                    'pattern' => [
                                    'name'     => "^[A-ZÀ-Öa-zà-öø-ÿ](?:[a-zà-öø-ÿ]|['’\-](?=[a-zà-öø-ÿ])| (?=[A-ZÀ-Ö])){1,19}$", // Lettre Majuscule et lettres minuscules (accents autorisés) ET/OU espaces , tirets , apostrophes non-consécutifs , le tout pouvant être répété (au total entre 2 et 20 caractères)
                                    'surname'  => "^[A-ZÀ-Öa-zà-öø-ÿ](?:[a-zà-öø-ÿ]|['’\-](?=[a-zà-öø-ÿ])| (?=[A-ZÀ-Ö])){1,19}$", // Motif idem
                                    'user'     => "^[A-ZÀ-Öa-zà-öø-ÿ](?:[a-zà-öø-ÿ]|['’\-](?=[a-zà-öø-ÿ])| (?=[A-ZÀ-Ö])){1,19}$", // Motif idem
                                    'email'    => "^(?=.{5,254}$)[A-Za-z0-9._%+\\-]+@[A-Za-z0-9.\\-]+\.[A-Za-z]{2,}$",
                                    'password' => "^[A-Za-z\d]{5,20}$" // Motif de lettres et chiffres
                                          ],
                      'title' => [
                                    'name'     => "Lettre Majuscule et lettres minuscules ('/- autorisés) entre 2 et 20",  // Motif idem
                                    'surname'  => "Lettre Majuscule et lettres minuscules ('/- autorisés) entre 2 et 20", // Motif idem
                                    'user'     => "Lettre Majuscule et lettres minuscules ('/- autorisés) entre 2 et 20", // Motif idem
                                    'email'    => "example@domain.com (entre 5 et 254)",
                                    'password' => "Lettre Majuscule et lettres minuscules avec chiffres (entre 8 et 20)"
                                          ],
                        'min' => [
                                    'name'     => 2,
                                    'surname'  => 2,
                                    'user'     => 2,
                                    'email'    => 5,
                                    'password' => 8
                                          ],
                        'max' => [
                                    'name'     => 20,
                                    'surname'  => 20,
                                    'user'     => 20,
                                    'email'    => 254,
                                    'password' => 20
                                          ],
                'placeholder' => [
                                    'name'     => ($lang === 'fr') ? "Votre nom" : (($lang === 'de') ? "" : "") ,
                                    'surname'  => ($lang === 'fr') ? "Votre prénom" : (($lang === 'de') ? "" : "") ,
                                    'user'     => ($lang === 'fr') ? "Votre nom d'utilisateur" : (($lang === 'de') ? "" : "") ,
                                    'email'    => ($lang === 'fr') ? "Votre email" : (($lang === 'de') ? "" : "") ,
                                    'password' => ($lang === 'fr') ? "Votre mot de passe" : (($lang === 'de') ? "" : "")
                                          ]
            ] ;
        
        $fieldsHtml = '';
              
        foreach ($labels['name'] as $key => $label) {
                // Méthode appliquée
                $this->addField(new FormField(
                  $labels['name'][$key],
                  $labels['type'][$key],
                  $labels['pattern'][$key],
                  $labels['title'][$key],
                  $labels['min'][$key],
                  $labels['max'][$key],		
                  $labels['label'][$key],
                  "font-size:24px;font-weight:bold;text-align:right;padding-right:20%;",
                  "margin-top:10px;width:200px;height:35px;",    
                  "",
                  $labels['placeholder'][$key],
                  "on",
                  true
                )) ;            
            }  

          foreach ($this->fields as $field) {
                  $fieldsHtml .= $field->render();
              } 

          // Prépare le message d'erreur
          $errorHtml = '';
            if (isset($_SESSION['errorRegistration']) && $_SESSION['errorRegistration'] === true) {
              $errorHtml = '<div style="font-size:16px;padding-top:5px;padding-bottom:15px;color:red">'
                          . $msgError .
                            '</div>';
              unset($_SESSION['errorRegistration']);
                }

            // Prépare le formulaire de retour (on n'utilise pas de syntaxe heredoc ici)
            $form = '<form method="POST" action="' . htmlspecialchars($this->action, ENT_QUOTES, 'UTF-8') . '" class="form">
                  <h1 style="font-size:36px">' . $msgTitle . '</h1>
                  <div class="grid-registration">' . $fieldsHtml . $errorHtml . '</div>
                  <button type="submit" class="buttons-text" style="margin:20px 0;cursor: pointer;">' . $msgButton . '</button>
                </form>';

            return $form;    
      }
    }
?>