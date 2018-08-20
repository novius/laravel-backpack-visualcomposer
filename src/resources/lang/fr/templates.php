<?php

return [
    'article' => [
        'name' => 'Texte',
        'crud' => [
            'title' => 'Titre',
            'date' => 'Texte du champ date',
            'author' => 'Auteur',
            'subtitle' => 'Sous-titre',
            'cta_label' => 'Libellé du bouton',
            'cta_url' => 'URL du bouton',
            'bg_color_container' => 'Couleur de fond du conteneur : ',
            'bg_color_fullwidth' => 'Couleur de fond pleine largeur : ',
        ],
    ],
    'left-text-right-quote' => [
        'name' => 'Texte gauche / bloc citation droite',
        'crud' => [
            'left_title' => 'Titre',
            'left_cta_label' => 'Libellé du bouton',
            'left_cta_url' => 'Lien du bouton',
            'right_wysiwyg' => 'Wysiwyg texte à droite',
            'right_author' => 'Wysiwyg light nom personne droite',
            'right_cta_label' => 'Libellé du bouton',
            'right_cta_url' => 'Lien du bouton',
            'right_color' => 'Couleur fond à droite',
        ],
    ],
    'left-image-right-text' => [
        'name' => 'Texte droite / image à gauche',
        'crud' => [
            'right_title' => 'Titre à droite',
            'right_cta_label' => 'Bouton libellé',
            'right_cta_url' => 'Bouton lien',
        ],
    ],
    'left-text-right-image' => [
        'name' => 'Image droite / texte gauche',
        'crud' => [
            'left_title' => 'Titre à gauche',
            'left_cta_label' => 'Bouton libellé',
            'left_cta_url' => 'Bouton lien',
        ],
    ],
    'image-in-container' => [
        'name' => 'Image simple (dans container)',
    ],
    'background-image-and-text' => [
        'name' => 'Image simple pleine largeur / texte',
        'crud' => [
            'image_caption' => 'Titre',
        ],
    ],
    'two-columns-image-text-cta' => [
        'name' => 'Deux colonnes image haut / texte bas',
        'crud' => [
            'title' => 'Titre',
            'cta_label' => 'Bouton libellé',
            'cta_url' => 'Bouton lien',
        ],
    ],
    'three-columns-image-text-cta' => [
        'name' => '3 colonnes image haut / texte bas',
        'crud' => [
            'title' => 'Titre',
            'cta_label' => 'Bouton libellé',
            'cta_url' => 'Bouton lien',
        ],
    ],
    'slideshow' => [
        'name' => 'Diaporama',
        'crud' => [
            'add_slide' => 'Ajouter une slide',
            'delete_slide' => 'Supprimer',
            'caption' => 'Légende',
        ],
    ],
    'image-in-base-64' => [
        'name' => 'Image incorporée en base 64',
    ],
];
