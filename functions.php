<?php
// Chargement style
function nathalie_mota_register_style() {
    wp_register_style('nathalie-mota-style', get_template_directory_uri() . '/style/style.css');
    wp_enqueue_style('nathalie-mota-style');
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_register_style' );



// Chargement scripts JS
function nathalie_mota_scripts() {
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri()  . '/js/scripts.js', array(), 1, true );
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_scripts' );


// Appel menus.php
require_once get_template_directory() . '/menus.php';

// Chargement support du thème
function nathalie_mota_supports() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    register_nav_menu('main-menu', 'En-tête du menu de navigation');
    register_nav_menu('footer-menu', 'Menu du footer');
}
add_action('after_setup_theme', 'nathalie_mota_supports');


// Hook Ajout bouton modale //

function add_button_header($items, $args) {
          if( $args->theme_location == 'main-menu' ){
          $items .= '<li class="menu-item" id="myBtn">Contact</li>';
          }
        return $items;
}
add_filter('wp_nav_menu_items', 'add_button_header', 10, 2);


// Hook Ajout span footer vie privée//

function add_span_footer($items, $args) {
    if( $args->theme_location == 'footer-menu' ){
        $items .= '<li class="menu-item"> Tous droits réservés </li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_span_footer', 10, 2);






