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
		
		<!-- Banner Hero -->
		<?php include_once('include/requetes_hero.php'); ?>
		
		<div class="banner">
			<h1 id="stroke">Photographe Event </h1>
		</div>

		<!-- formulaire tri photos-->
		<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" class="form-catalogue" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">		 	
			<input 
            	type="hidden" 
            	name="nonce" 
            	value="<?php echo wp_create_nonce( 'NC_filtres_photos' ); ?>"
        		> 
			 <?php
    			$taxonomies = get_object_taxonomies('photo', 'objects');
    			foreach ($taxonomies as $taxonomy) {
        			      $terms = get_terms($taxonomy->name, array('hide_empty' => false));
        echo '<div>';
        echo '<label class="taxonomy-label">' . $taxonomy->label;
        echo '<select name="' . $taxonomy->name . '">';
        echo '<option value="" id="option-defaut"></option>'; 
        foreach ($terms as $term) {
            echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
        }
        echo '</select>';
        echo '</label>';
        echo '</div>';
    			}
    		?>
			 <div>
        		<label for="ordre"> Trier par :</label>
        			<select name="ordre" id="ordre">
						<option value="" id="option-defaut"></option>
           				<option value="asc">Du plus ancien au plus récent</option>
            			<option value="desc">Du plus récent au plus ancien</option>
        			</select>
    		</div>
		</form>






		<!-- Catalogue photo -->
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
