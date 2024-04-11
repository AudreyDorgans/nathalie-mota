<?php 
$args_banner = array(
    'post_type' => 'photo',
    'posts_per_page' => 1,
    'orderby' => 'rand'
);
$my_query = new WP_Query($args_banner);  
if ($my_query->have_posts()) : 
    while ($my_query->have_posts()) : $my_query->the_post();
        // Récupérer l'ID de l'image mise en avant
        $id_photo = get_post_thumbnail_id();

        // Récupérer les attributs de l'image
        $img_atts = wp_get_attachment_image_src($id_photo, 'full');

        // Vérifier si les attributs existent et récupérer l'URL de l'image
        if ($img_atts) {
            $img_url = $img_atts[0];
            
            $file_path = get_theme_file_path() . '/sass/_url-hero.scss';

            // Écrire les données PHP dans un fichier SCSS (écraser le contenu existant)
            $scss_content = '$background-image-url: "' . $img_url . '";';
            file_put_contents($file_path, $scss_content);
        }
    endwhile;
endif;
wp_reset_postdata();
?>
