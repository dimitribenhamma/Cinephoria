<!-- La page FormField.php (Class) : style K&R , indentation Ok -->
 <style>
input {
  border: 2px solid black ;
  padding: 5px ;
  border-radius: 6px ;
  transition: border 0.2s ease ;
}
input:focus {
  outline: none ;
  box-shadow: none ;  
}
</style>
<?php
/* Utilisation de classe en POO */
/* Un champ typique d'un formulaire */
class FormField {
    /* Variables de classe */
    private string $name ;
    private string $type ;
    private string $pattern ;
    private string $title ; 
    private int $minlength ;
    private int $maxlength ;
    private string $label ;
    private string $style ;
    private string $labelStyle ;
    private string $value ;
    private string $placeholder ;
    private string $autocomplete ;    
    private bool $required ;

      /* Constructeur d'objet */
      public function __construct(
        string $name,
        string $type, 
        string $pattern, 
        string $title, 
        int $minlength, 
        int $maxlength, 
        string $label,
        string $labelStyle,
        string $style,         
        string $value, 
        string $placeholder, 
        string $autocomplete, 
        bool $required = true
      ) {
          $this->name = $name ;
          $this->type = $type ;
          $this->pattern = $pattern ;
          $this->title = $title ;
          $this->minlength = $minlength ;
          $this->maxlength = $maxlength ;
          $this->label = $label ;          
          $this->labelStyle = $labelStyle ;
          $this->style = $style ;
          $this->value = $value ;
          $this->placeholder = $placeholder ;
          $this->autocomplete = $autocomplete ;
          $this->required = $required ;
      }

      /* La methode qui renvoie le champ du formulaire */
      public function render(): string {
          // Utile si les droits serveur sont mals configurés
          $name = htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8');
          $label = htmlspecialchars($this->label, ENT_QUOTES, 'UTF-8');
          $labelStyle = htmlspecialchars($this->labelStyle, ENT_QUOTES, 'UTF-8');
          $type = htmlspecialchars($this->type, ENT_QUOTES, 'UTF-8');
          $title = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
          $minlength = htmlspecialchars($this->minlength, ENT_QUOTES, 'UTF-8');
          $maxlength = htmlspecialchars($this->maxlength, ENT_QUOTES, 'UTF-8');
          $autocomplete = htmlspecialchars($this->autocomplete, ENT_QUOTES, 'UTF-8');
          $valueAttr  = $this->value !== '' ? 'value="' . htmlspecialchars($this->value, ENT_QUOTES, 'UTF-8') . '"' : '' ; // Sécurité XSS
          $patternAttr = $this->pattern !== '' ? 'pattern="' . htmlspecialchars($this->pattern  , ENT_QUOTES, 'UTF-8') . '"' : '' ;
          $placeholder = $this->placeholder ? 'placeholder="' . htmlspecialchars($this->placeholder, ENT_QUOTES, 'UTF-8') . '"' : '' ;
          $style = htmlspecialchars($this->style, ENT_QUOTES, 'UTF-8');

          
          // Prépare le champ de retour du formulaire (on utilisera la syntaxe heredoc ici)
          return <<<HTML
                <label 
                  for="{$name}" 
                  style="{$labelStyle}">
                  {$label} : 
                </label>
          <div>
              <input 
                  name="{$name}" 
                  type="{$type}"                                    
                  id="{$name}"
                  title="{$title}" 
                  minlength="{$minlength}" 
                  maxlength="{$maxlength}" 
                  autocomplete="{$autocomplete}"
                  {$patternAttr}
                  {$valueAttr}
                  {$placeholder}
                  style="{$style}" />
              <span id="msg_{$name}"></span>
          </div>      
          HTML;
      }
}
?>
