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
    wp_enqueue_script( 'nice-select', get_stylesheet_directory_uri()  . '/js/jquery.nice-select.js', array(), 1, true );
    wp_enqueue_script( 'fastclick', get_stylesheet_directory_uri()  . '/js/fastclick.js', array(), 1, true );
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri()  . '/js/scripts.js', array(), 1, true );
    wp_enqueue_script( 'modale', get_stylesheet_directory_uri()  . '/js/modale.js', array(), 1, true );
    wp_enqueue_script( 'lightbox', get_stylesheet_directory_uri()  . '/js/lightbox.js', array(), 1, true );
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
        
        $image = esc_url(get_the_post_thumbnail_url($id_photo));

        $permalien = esc_url(get_permalink($id_photo));

        $reference = esc_html(get_field('reference', $id_photo));

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

        // Récupérer les ID des posts précédent et suivant
        $prev_post = get_previous_post();
        $prev_post_id = $prev_post ? $prev_post->ID : '';

        $next_post = get_next_post();
        $next_post_id = $next_post ? $next_post->ID : '';
       
        // Récupérer les miniatures des posts précédent et suivant
        $prev_thumbnail = $prev_post_id ? esc_url(get_the_post_thumbnail_url($prev_post_id, array(80, 80))) : '';
        $next_thumbnail = $next_post_id ? esc_url(get_the_post_thumbnail_url($next_post_id, array(80, 80))) : '';

        // Créez un tableau avec toutes les informations de la photo, y compris les ID des posts précédent et suivant ainsi que leurs miniatures
        $infos_photo = array(
            'id_photo' => $id_photo,
            'image_photo' => $image, 
            'permalien' => $permalien,
            'reference' => $reference,
            'nom_categories' => $nom_categories,
            'slug_categories' => $slug_categories,
            'formats' => $format_name,
            'prev_post_id' => $prev_post_id,
            'next_post_id' => $next_post_id,
            'prev_thumbnail' => $prev_thumbnail,
            'next_thumbnail' => $next_thumbnail,
        ); 

        // Retournez le tableau complet des informations de la photo
        return $infos_photo;
    }

    return false;
}



////////////////////////////////////////////////////////////
// Fonction pour charger les prochains 8 CPT avec filtres de taxonomie
////////////////////////////////////////////////////////////

add_action( 'wp_ajax_NM_load_catalogue_photos', 'NM_load_catalogue_photos' );
add_action( 'wp_ajax_nopriv_NM_load_catalogue_photos', 'NM_load_catalogue_photos' );

function NM_load_catalogue_photos() {
    // Vérifier le nonce pour des raisons de sécurité
    check_ajax_referer( 'NM_load_catalogue_photos', 'nonce' );

    // Récupérer les valeurs de paged, categorie, format et ordre depuis la requête AJAX
    $paged = isset( $_REQUEST['paged'] ) ? intval( $_REQUEST['paged'] ) : 1;
    $categorie = isset( $_REQUEST['categorie'] ) ? sanitize_text_field( $_REQUEST['categorie'] ) : '';
    $format = isset( $_REQUEST['format'] ) ? sanitize_text_field( $_REQUEST['format'] ) : '';
    $order = isset($_REQUEST['ordre']) ? strtoupper($_REQUEST['ordre']) : '';

    error_log('Order value: ' . $order);

    
    // Construire les arguments de la requête pour récupérer les photos
    $args_load_photo = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'tax_query' => array(),
        'order' => $order,
    );

    // Ajouter la taxonomie categorie aux arguments de la requête si elle est spécifiée
    if ( ! empty( $categorie ) ) {
        $args_load_photo['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug', 
            'terms'    => $categorie,
        );
    }

    // Ajouter la taxonomie format aux arguments de la requête si elle est spécifiée
    if ( ! empty( $format ) ) {
        $args_load_photo['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug', 
            'terms'    => $format,
        );
    }

    // Exécuter la requête pour récupérer les photos
    $my_query = new WP_Query( $args_load_photo ); 

    // Initialiser un tableau pour stocker les données des photos
    $photos_data = array(); 

    // Parcourir les résultats de la requête pour récupérer les données des photos
    if ( $my_query->have_posts() ) {
        while ( $my_query->have_posts() ) {
            $my_query->the_post();
            $infos_photo = recuperer_infos_photo( get_the_id() );
            if ( $infos_photo ) {
                $infos_photo['nonce'] = wp_create_nonce( 'NM_load_lightbox_photo' ); // Ajouter le nonce à chaque photo
                $photos_data[] = $infos_photo; 
            }
        }
    }

    // Envoyer une réponse JSON contenant les données des photos
    if ( empty( $photos_data ) ) {
        wp_send_json_success( array( 'message' => 'Aucune photo trouvée' ) );
    } else {
        wp_send_json_success( $photos_data );
    }
    
    wp_die(); // Arrêter l'exécution du script WordPress
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
    
    $nonce = $categorie = $format = $ordre = '';

    parse_str($data, $parsedData);

    if (!isset($parsedData['nonce']) || !wp_verify_nonce($parsedData['nonce'], 'NC_filtres_photos')) {
        wp_send_json_error('Erreur de vérification du jeton de sécurité.');
        wp_die();
    }

    if (isset($parsedData['categorie'])) {
        $categorie = sanitize_text_field($parsedData['categorie']);
    }

    if (isset($parsedData['format'])) {
        $format = sanitize_text_field($parsedData['format']);
    }

   if (isset($parsedData['ordre'])) {
        $ordre = strtoupper($parsedData['ordre']); // Convertir en majuscules pour assurer la correspondance
        if ($ordre !== 'ASC' && $ordre !== 'DESC') {
            $ordre = 'DESC'; // Défaut si la valeur n'est ni 'ASC' ni 'DESC'
        }
    } else {
        $ordre = 'DESC'; // Défaut si aucune valeur n'est fournie
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
            $photo_data['nonce'] = wp_create_nonce('NM_load_lightbox_photo');
            $filtered_photos[] = $photo_data;

        }
        wp_reset_postdata();
    }

    wp_send_json_success($filtered_photos);
    error_log($filtered_photos);

    wp_die();
}


////////////////////////////////////////////////////////////
// Lightbox
////////////////////////////////////////////////////////////
add_action('wp_ajax_NM_load_lightbox_photo', 'NM_load_lightbox_photo');
add_action('wp_ajax_nopriv_NM_load_lightbox_photo', 'NM_load_lightbox_photo');

function NM_load_lightbox_photo() {

    check_ajax_referer('NM_load_lightbox_photo', 'nonce');

    $post_id_lightbox = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($post_id_lightbox  > 0) {
        
        $infos_photo = recuperer_infos_photo($post_id_lightbox);

        if ($infos_photo) {
            global $wpdb;
            $current_post_date = get_post_field('post_date', $post_id_lightbox);
            
            $prev_post_id = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT p.ID 
                    FROM {$wpdb->posts} p 
                    WHERE p.post_type = 'photo' AND p.post_status = 'publish' AND p.post_date < %s
                    ORDER BY p.post_date DESC 
                    LIMIT 1",
                    $current_post_date
                )
            );

            $next_post_id = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT p.ID 
                    FROM {$wpdb->posts} p 
                    WHERE p.post_type = 'photo' AND p.post_status = 'publish' AND p.post_date > %s
                    ORDER BY p.post_date ASC 
                    LIMIT 1",
                    $current_post_date
                )
            );

            $infos_photo['prev_post_id'] = $prev_post_id;
            $infos_photo['next_post_id'] = $next_post_id;

            $nonce = wp_create_nonce('NM_load_lightbox_photo');
            $infos_photo['nonce'] = $nonce;

            
            wp_send_json_success($infos_photo);

        } else {
            wp_send_json_error('Failed to retrieve photo information.');
        }
    } else {
        wp_send_json_error('Invalid photo ID.');
    }
    wp_die();
}




