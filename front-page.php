<?php
/**
 * Template généré pour la page d'accueil - front-page Nathalie Mota
 * pages générales
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package nathalie-mota
 */

get_header();
?>
	<main class="main-accueil">
		
		<!-- Banner Hero -->
		<?php include_once('include/requetes_hero.php'); ?>
		
		<div class="banner">
			<h1 id="stroke">Photographe Event </h1>
		</div>


		<!-- Formulaire tri photos-->
		<?php get_template_part('templates_parts/formulaire-tri-photos'); ?>


		<!-- Affichage photo -->
		<?php	
            
        $args_catalogue_photo = array(
            'post_type' => 'photo',
			'posts_per_page' => 8,                       
        );
                
		$my_query = new WP_Query($args_catalogue_photo ); 
			
		set_query_var( 'my_query', $my_query );?>

        <?php get_template_part('templates_parts/affichage-photos'); ?>
	

	</main><!-- #main -->

<?php
get_footer();
