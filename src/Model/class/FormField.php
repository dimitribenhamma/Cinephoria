<!-- Class FormField.php : style K&R , indentation Ok -->
 <style>
input {
  border: 2px solid black;
  padding: 5px;
  border-radius: 6px;
  transition: border 0.2s ease;
}
input:focus {
  outline: none;
  box-shadow: none;  
}
</style>
<!-- Utilisation de classe en POO -->

<?php
/* Un champ typique d'un formulaire */
class FormField {
    /* Variables de classe */
    private string $name;
    private string $type;
    private string $pattern;
    private string $title; 
    private int $minlength;
    private int $maxlength;
    private string $label;
    private string $style;
    private string $labelStyle;
    private string $value;
    private string $placeholder;
    private string $autocomplete;    
    private bool $required;

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
          $this->name = $name;
          $this->type = $type;
          $this->pattern = $pattern;
          $this->title = $title;
          $this->minlength = $minlength;
          $this->maxlength = $maxlength;
          $this->label = $label;          
          $this->labelStyle = $labelStyle;
          $this->style = $style;
          $this->value = $value;
          $this->placeholder = $placeholder;
          $this->autocomplete = $autocomplete;
          $this->required = $required;
      }

      /* La methode qui renvoie le champ du formulaire */
      public function render(): string {
          $required = $this->required ? 'required' : '';
          $placeholder = $this->placeholder ? "placeholder=\"{$this->placeholder}\"" : '';
          $valueAttr  = $this->value !== '' ? 'value="' . htmlspecialchars($this->value, ENT_QUOTES, 'UTF-8') . '"' : '';
          // Prépare le champ de retour du formulaire (on utilisera la syntaxe heredoc ici)
          return <<<HTML
          <label 
                  for="{$this->name}" 
                  style="{$this->labelStyle}">
                  <!-- "display:flex;font-size:24px;font-weight:bold;align-items:center;text-align:center;margin:auto;" -->
                  {$this->label}
          </label>
          <div style="display:inline-flex;align-items:center;gap:8px;">
              <input 
                  type="{$this->type}" 
                  name="{$this->name}" 
                  pattern="{$this->pattern}" 
                  id="{$this->name}"
                  title="{$this->title}" 
                  minlength="{$this->minlength}" 
                  maxlength="{$this->maxlength}" 
                  autocomplete="{$this->autocomplete}" 
                  $valueAttr 
                  $placeholder 
                  $required 
                  style="{$this->style}"                  
                  onblur="confirmer(this)" 
                  oninput="verifier(this)" />
                  <!-- "margin-top:10px;width:200px;height:35px;" -->
              <span id="msg_{$this->name}"></span>
          </div>      
          HTML;
      }
}
?>
