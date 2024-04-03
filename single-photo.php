<?php
/**
 * The template for displaying all single photo
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package nathalie-mota
 */

get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 

		$categories = get_the_terms( get_the_ID(), 'categorie');
			foreach( $categories as $categorie ){
    			$nom_categories = $categorie->name;
			}

		$formats = get_the_terms( get_the_ID(), 'format');
		
			foreach( $formats as $format ){
    			$formats = $format->name;
			} 
?>
		
<?php endwhile; else : ?>
<?php endif; ?>

	<main class="single-photo-main">   

		<div class="row-infos-photo-single">

			<div class="colonne-infos-photo">
				<h2> <?php echo get_the_title(); ?> </h2>
				<p> Référence : <?php the_field( 'reference' );?> </p>
				<p> Catégorie <?php echo $nom_categories;?> </p>
				<p> Format : <?php echo $formats;?> </p>
				<p> Type : <?php the_field( 'type' );?> </p>
				<p> Date : <?php the_time( 'Y' ); ?> </p>	
			</div>

			<div class="colonne-photo">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
	
		</div>

		<div class="row-photo-contact">
			<div class="colonne-photo-contact">
			</div>

			<div class="colonne-photo-next">
			</div>
	
		</div>

		<div class="row-photo-contact">
			<h3> Vous aimerez aussi </h3>
			<div class="colonne-photo-autre colonne-photo-autre-1">
			</div>

			<div class="colonne-photo-autre colonne-photo-autre-2">
			</div>
	
		</div>

		

	

	</main>

			



		

	

<?php

get_footer();
