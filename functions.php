<?php
// Chargement style
function nathalie_mota_register_style() {
    wp_register_style('nathalie-mota-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('nathalie-mota-style');
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_register_style' );


// Chargement support du thème
function nathalie_mota_supports() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    register_nav_menu('main-menu', 'En-tête du menu de navigation');
}
add_action('after_setup_theme', 'nathalie_mota_supports');


// Chargement scripts JS

function nathalie_mota_scripts() {
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri()  . '/js/scripts.js', array(), 1, true );
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_scripts' );




