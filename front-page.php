<?php
/**
 * The template for displaying all pages
 * pages générales
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package nathalie-mota
 */

get_header();
?>
	<main class="main-accueil">
		
		<?php include_once('include/requetes_hero.php'); ?>
		
		<div class="banner">
			<h1 id="stroke">Photographe Event </h1>
		</div>



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
