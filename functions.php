<?php
//////////////////////////////
// Chargement support du thème
//////////////////////////////
add_action('after_setup_theme', 'nathalie_mota_supports');
function nathalie_mota_supports() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' ); 
    add_theme_support('menus');
    register_nav_menu('main-menu', 'En-tête du menu de navigation');
    register_nav_menu('footer-menu', 'Menu du footer');
}


//////////////////////////////
// Chargement style
//////////////////////////////
add_action( 'wp_enqueue_scripts', 'nathalie_mota_register_style' );
function nathalie_mota_register_style() {
    wp_register_style('nathalie-mota-style', get_template_directory_uri() . '/style/style.css');
    wp_enqueue_style('nathalie-mota-style');
}


//////////////////////////////
// Chargement scripts JS
//////////////////////////////
add_action( 'wp_enqueue_scripts', 'nathalie_mota_scripts' );
function nathalie_mota_scripts() {
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri()  . '/js/scripts.js', array(), 1, true );
}


//////////////////////////////
// Appel menus.php
//////////////////////////////
require_once get_template_directory() . '/menus.php';






////////////////////////////////////////////////////////////
// Hook Ajout bouton modale header et Ajout span footer vie privée //
////////////////////////////////////////////////////////////
add_filter('wp_nav_menu_items', 'add_elements_menus', 10, 2);
function add_elements_menus($items, $args) {

    if( $args->theme_location == 'main-menu' ){

        $items .= '<li class="menu-item" id="myBtn">Contact</li>';

    }elseif( $args->theme_location == 'footer-menu' ){

        $items .= '<li class="menu-item"> Tous droits réservés </li>';
    }

    return $items;
}



////////////////////////////////////////////////////////////
// Enregistre le custom type
////////////////////////////////////////////////////////////
add_action( 'init', 'NM_register_custom_post_type' );
function NM_register_custom_post_type() {
    register_post_type( 'Photos', array(
        'label'    => 'Photos',
        'supports' => array( 'title', 'editor', 'thumbnail' ),
    ) );
}

