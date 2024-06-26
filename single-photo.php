<?php
/**
 * The template for displaying all single photo
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package nathalie-mota
 */
?>

<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
	$infos_photo = recuperer_infos_photo(get_the_id());
?>		
		
<?php endwhile; else : ?>
<?php endif; ?>

	<main class="single-photo-main">   

		<div class="row-infos-photo-single">

			<div class="colonne-infos-photo">
				<h2> <?php echo get_the_title(); ?> </h2>
				<p class="uppercase">Référence :  <span class="reference"><?php the_field( 'reference' );?></span> </p>
				<p class="uppercase">Catégorie : <?php echo $infos_photo['nom_categories'];?> </p>
				<p class="uppercase">Format : <?php echo $infos_photo['formats'];?> </p>
				<p class="uppercase">Type : <?php the_field( 'type' );?> </p>
				<p class="uppercase">Date : <?php the_time( 'Y' ); ?> </p>	

			</div>

			<div class="colonne-photo">
				<?php the_post_thumbnail( 'full', array('id' => 'main_thumbnail') ); ?>
			</div>
		</div>
		
		<div class="row-infos-photo-contact">
	
			<div class="colonne-photo-contact">
				<p> Cette photo vous intéresse ? </p>
				<button class="myBtnContact bouton-avec-reference">Contact</button> 
			</div>

			<div class="photos-navigation">
				<!-- images thumbnails-->
				<span class="nav-thumbnails-prev thumbnails_hide"><img src="<?php echo $infos_photo['prev_thumbnail']; ?>" alt="Miniature de l'image précédente"></span>
				<span class="nav-thumbnails-next thumbnails_hide"><img src="<?php echo $infos_photo['next_thumbnail']; ?>" alt="Miniature de l'image suivante"></span>
				
				<!-- fleches navigation et lien -->
				<span class="photo-prev"> <?php previous_post_link('%link','<i class="fa-solid fa-arrow-left"></i>'); ?> </span>
				<span class="photo-next"> <?php next_post_link('%link','<i class="fa-solid fa-arrow-right"></i>'); ?> </span>
			</div>
		</div>
	

	</main>

	<aside class="aside-photo-comp">
		
		<h3> Vous aimerez aussi </h3>

			<div class="row-img-similaires">
			
			<?php	      
        	$args_photos_similaires = array(
            'post_type' => 'photo',
			'post__not_in' => array($infos_photo['id_photo']),
            'posts_per_page' => 2,
            'tax_query' => array(
                                array(
                                    'taxonomy' => 'categorie',
                                    'field' => 'slug',
                                    'terms' => $infos_photo['slug_categories'], 
                                ),
                            ),
                        );
                
			$my_query = new WP_Query($args_photos_similaires); 
			set_query_var( 'my_query', $my_query );?>

            <?php get_template_part('templates_parts/affichage-photos'); ?>
			</div>

	</aside>

<?php
get_footer();

			



		

	