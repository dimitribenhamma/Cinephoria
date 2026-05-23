<!-- Class Header.php -->

<?php 
// --- Création des Classes ---
// Séparation nette des responsabilités et réutiliser pour d’autres pages.

                        

                    /* Une Class pour nos items (éléments "liens") de menu au centre */
                    class Menu {
                        
                        private $items = [] ;

                        // Méthodes de Class

                        public function addItem($label,$link,$page){
                            $this->items[] = [
                                'label' => $label,
                                'link'  => $link,
                                'page'  => $page
                            ] ;
                        }
                                                                    
                        public function menu()
                        {                                                      
                            echo '<ul>' ;
                            foreach ($this->items as $item) { 
                                // iconv enlève les accents
                                $class = (strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $item['page'])) === $_GET['page']) ? "active" : "non-active" ;
                                echo '<li class="menu"><a class=' . $class . ' href="' . $item['link'] . '">' . $item['label'] . '</a></li>' ;
                            }
                            echo '</ul>' ;                            
                        }
                    }


                    /* Une Class pour les boutons "Connexion" et "Inscription" */
                    class Register {

                        private $items = [] ;

                        // Méthodes de Class
                        public function addItem($label,$link){
                            $this->items[] = ['label' => $label, 'link' => $link] ;     
                        }

                        
                        
                        // Afficher les boutons
                        public function register()
                        {
                            echo '<ul>' ;
                            foreach ($this->items as $item) {
                                echo '<li class="register"><a href="' . $item['link'] . '">' . $item['label'] . '</a></li>' ;
                            }
                            echo '</ul>' ;
                        }
                    }
?>