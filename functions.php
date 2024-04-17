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

    if (!isset($post_id) || !is_numeric($post_id)) {
        return false; 
    }

    $id_photo = intval($post_id);

    if ($id_photo > 0) {
        
        $categories = get_the_terms($id_photo, 'categorie');
        $nom_categories = $slug_categories = '';
        
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $categorie) {
                $nom_categories = sanitize_text_field($categorie->name);
                $slug_categories = sanitize_text_field($categorie->slug);
            }
        }

        $formats = get_the_terms($id_photo, 'format');
        $format_name = '';
        if (!empty($formats) && !is_wp_error($formats)) {
            foreach ($formats as $format) {
                $format_name = sanitize_text_field($format->name);
            }
        }

        $image = esc_url(get_the_post_thumbnail_url($id_photo));

        $permalien = esc_url(get_permalink($id_photo));

        $reference = esc_html(get_field('reference', $id_photo));

        $next_posts = esc_url(get_next_posts_link()); 
        $prev_posts = esc_url(get_previous_posts_link());

        $prev_post = get_previous_post();
        $prev_thumbnail = esc_url(get_the_post_thumbnail_url($prev_post, array(80, 70))); 

        $next_post = get_next_post();
        $next_thumbnail = esc_url(get_the_post_thumbnail_url($next_post, array(80, 70))); 

        return array(
            'id_photo' => $id_photo,
            'image_photo' => $image, 
            'permalien' => $permalien,
            'reference' => $reference,
            'nom_categories' => $nom_categories,
            'slug_categories' => $slug_categories,
            'formats' => $format_name,
            'next_posts' => $next_posts,
            'prev_posts' => $prev_posts,
            'next_thumbnail' => $next_thumbnail,
            'prev_thumbnail' => $prev_thumbnail
        ); 
    }

    return false;
}


////////////////////////////////////////////////////////////
// Fonction pour charger les prochains 8 CPT avec filtres de taxonomie
////////////////////////////////////////////////////////////

add_action( 'wp_ajax_NM_load_catalogue_photos', 'NM_load_catalogue_photos' );
add_action( 'wp_ajax_nopriv_NM_load_catalogue_photos', 'NM_load_catalogue_photos' );

function NM_load_catalogue_photos() {

    check_ajax_referer( 'NM_load_catalogue_photos', 'nonce' );

    if (isset($_REQUEST['paged'])) {
        $paged = intval($_REQUEST['paged']);
    } else {
        $paged = 1;
    }

    if (isset($_REQUEST['categorie'])) {
        $categorie = sanitize_text_field($_REQUEST['categorie']);
    } else {
        $categorie = '';
    }

    if (isset($_REQUEST['format'])) {
        $format = sanitize_text_field($_REQUEST['format']);
    } else {
        $format = '';
    }

    $args_load_photo = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'tax_query' => array(),
    );

    if (!empty($categorie)) {
        $args_load_photo['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug', 
            'terms'    => $categorie,
        );
    }

    if (!empty($format)) {
        $args_load_photo['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug', 
            'terms'    => $format,
        );
    }

    $my_query = new WP_Query($args_load_photo); 

    $photos_data = array(); 

    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post();
            $infos_photo = recuperer_infos_photo(get_the_id());
            if ($infos_photo) {
                $photos_data[] = $infos_photo; 
            }
        }
    }

    if (empty($photos_data)) {
        wp_send_json_success( array('message' => 'Aucune photo trouvée') );
    }

    wp_send_json_success( $photos_data );

    wp_die();
}




////////////////////////////////////////////////////////////
// Fonction pour les tris d'affichage
////////////////////////////////////////////////////////////
add_action( 'wp_ajax_filtres_photos', 'filtres_photos' );
add_action( 'wp_ajax_nopriv_filtres_photos', 'filtres_photos' );

function filtres_photos() {

    if (isset($_POST['formData'])) {
        $data = $_POST['formData'];
    } else {
        wp_send_json_error( array('message' => 'Données manquantes') );
    }
    
    $categorie = $format = $ordre = '';

    parse_str($data, $parsedData);

    if (isset($parsedData['categorie'])) {
        $categorie = sanitize_text_field($parsedData['categorie']);
    }

    if (isset($parsedData['format'])) {
        $format = sanitize_text_field($parsedData['format']);
    }

    if (isset($parsedData['ordre'])) {
        $ordre = $parsedData['ordre'];
    }

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
    );

    if (!empty($categorie)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug', 
            'terms'    => $categorie,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug', 
            'terms'    => $format,
        );
    }

    if (!empty($ordre)) {
        $args['order'] = $ordre;
    } else {
        $args['order'] = 'DESC';
    }
   
    $my_query_filtres = new WP_Query($args);

    $filtered_photos = array();

    if ($my_query_filtres->have_posts()) {
        while ($my_query_filtres->have_posts()) {
            $my_query_filtres->the_post();
            $photo_data = recuperer_infos_photo(get_the_ID()); 
            $filtered_photos[] = $photo_data;
        }
        wp_reset_postdata();
    }

    wp_send_json_success($filtered_photos);

    wp_die();
}

