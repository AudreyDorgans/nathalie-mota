<?php
//////////////////////////////
// support du thème
//////////////////////////////
function nathalie_mota_supports() {
    add_theme_support( 'title-tag' );
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    register_nav_menu('main-menu', 'En-tête du menu de navigation');
    register_nav_menu('footer-menu', 'Menu du footer');
}
add_action('after_setup_theme', 'nathalie_mota_supports');


//////////////////////////////
//style
//////////////////////////////
function nathalie_mota_register_style() {
    wp_register_style('nathalie-mota-style', get_template_directory_uri() . '/style/style.css');
    wp_enqueue_style('nathalie-mota-style');
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_register_style' );


//////////////////////////////
// scripts JS
//////////////////////////////
function nathalie_mota_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri()  . '/js/scripts.js', array(), 1, true );
    wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/cf5cb3cba1.js');
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_scripts' );


//////////////////////////////
// Appel menus.php
//////////////////////////////
require_once get_template_directory() . '/menus.php';


////////////////////////////////////////////////////////////
// Hook Ajout bouton modale header et Ajout span footer vie privée //
////////////////////////////////////////////////////////////
function add_elements_menus($items, $args) {

    if( $args->theme_location == 'main-menu' ){

        $items .= '<li class="menu-item myBtnContact">Contact</li>';

    }elseif( $args->theme_location == 'footer-menu' ){

        $items .= '<li class="menu-item"> Tous droits réservés </li>';
    }

    return $items;
}
add_filter('wp_nav_menu_items', 'add_elements_menus', 10, 2);


////////////////////////////////////////////////////////////
//Récupération des informations liées aux photos
////////////////////////////////////////////////////////////
function recuperer_infos_photo($post_id) {
    $id_photo = $post_id;

    $categories = get_the_terms($id_photo, 'categorie');
    foreach ($categories as $categorie) {
        $nom_categories = $categorie->name;
        $slug_categories = $categorie->slug;
    }

    $formats = get_the_terms($id_photo, 'format');
    foreach ($formats as $format) {
        $formats = $format->name;
    }

    $image = get_the_post_thumbnail_url($id_photo); // Obtenez l'URL de l'image mise en avant
    $permalien = get_permalink($id_photo);
    $reference = get_field('reference', $id_photo);

    $next_posts = get_next_posts_link(); 
    $prev_posts = get_previous_posts_link();

    $prev_post = get_previous_post();
    $prev_thumbnail = get_the_post_thumbnail($prev_post, array(80,70)); 

    $next_post = get_next_post();
    $next_thumbnail = get_the_post_thumbnail($next_post, array(80,70)); 

    return array(
        'id_photo' => $id_photo,
        'image_photo' => $image, // Utilisez l'URL de l'image mise en avant
        'permalien' => $permalien,
        'reference' => $reference,
        'nom_categories' => $nom_categories,
        'slug_categories' => $slug_categories,
        'formats' => $formats,
        'next_posts' => $next_posts,
        'prev_posts' => $prev_posts,
        'next_thumbnail' => $next_thumbnail,
        'prev_thumbnail' => $prev_thumbnail
    );
}


////////////////////////////////////////////////////////////
// Fonction pour charger les prochains 8 CPT
////////////////////////////////////////////////////////////

add_action( 'wp_ajax_NM_load_catalogue_photos', 'NM_load_catalogue_photos' );
add_action( 'wp_ajax_nopriv_NM_load_catalogue_photos', 'NM_load_catalogue_photos' );

function NM_load_catalogue_photos() {

    check_ajax_referer( 'NM_load_catalogue_photos', 'nonce' );

    $paged = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1;

    $arg_load_photo = array(
        'post_type' => 'photo',
        'posts_per_page' => 8, 
        'paged' => $paged,
    );

    $my_query = new WP_Query($arg_load_photo); 

    $photos_data = array(); 

    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post();
            $infos_photo = recuperer_infos_photo(get_the_id());
            $photos_data[] = $infos_photo; 
        }
    }

    if (empty($photos_data)) {
        wp_send_json_success( array('message' => 'Aucune photo trouvée') );
    }

    wp_send_json_success( $photos_data );

    wp_die();
}


 
