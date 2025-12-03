<?php
$rooms = array (
'France' => array(
      'Toulouse' => 
              array(                
                  'id' => 1,
                  'Pays' => 'France',
                  'cinema' => 'Toulouse',
                  'salles' => array(1 => '100', 2 => '90', 3 => '81', 4 => '81', 5 => '72'), /* codé en partie admin */
                  'places' => 420, /* codé par un calcul */ 
                  'normes' => array(1 => 'handicapé', 3 => 'handicapé') /* visible par un picto */
                ),
      'Paris' => 
              array(                  
                  'id' => 2,
                  'Pays' => 'France',
                  'cinema' => 'Paris',
                  "salles" => array(1 => '190', 2 => '170', 3 => '100', 4 => '100', 5 => '90', 6 => '81', 7 => '81', 8 => '72'),
                  'places' => 880,
                  'normes' => array(1 => 'handicapé')
                ),
        'Lille' => 
              array(
                  'id' => 1,
                  'Pays' => 'France',
                  'cinema' => 'Lille',
                  'salles' => array(1 => '100', 2 => '90', 3 => '81', 4 => '81', 5 => '72'),
                  'places' => 420,
                  'normes' => array(1 => 'handicapé')
                ),
        'Bordeaux' =>               
                array (
                  'id' => 1,
                  'Pays' => 'France',
                  'cinema' => 'Bordeaux',
                  'salles' => array(1 => '100', 2 => '90', 3 => '81', 4 => '81', 5 => '72'),
                  'places' => 420,
                  'normes' => array(1 => 'handicapé')
                ),         
        'Nantes' =>             
                array (
                  'id' => 1,
                  'Pays' => 'France',
                  'cinema' => 'Nantes',
                  'salles' => array(1 => '100', 2 => '90', 3 => '81', 4 => '81', 5 => '72'),
                  'places' => 420,
                  'normes' => array(1 => 'handicapé')
                )),
'Belgique' => array(
          'Charleroi' => 
                array (
                  'id' => 1,
                  'Pays' => 'Belgique',
                  'cinema' => 'Charleroi',
                  'salles' => array(1 => '100', 2 => '90', 3 => '81', 4 => '81', 5 => '72'),
                  'places' => 420,
                  'normes' => array(1 => 'handicapé')
                ), 
        'Liège' => 
              array(
                  'id' => 1,
                  'Pays' => 'Belgique',
                  'cinema' => 'Liège',
                  'salles' => array(1 => '100', 2 => '90', 3 => '81', 4 => '81', 5 => '72'),
                  'places' => 420,
                  'normes' => array(1 => 'handicapé')
                ),
        )
              );
?>