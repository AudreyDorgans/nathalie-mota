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

<?php include_once('include/requetes_single_photo.php'); ?>

	<main class="single-photo-main">   

		<div class="row-infos-photo-single">

			<div class="colonne-infos-photo">
				<h2> <?php echo get_the_title(); ?> </h2>
				<p class="uppercase">Référence :  <span class="reference"><?php the_field( 'reference' );?></span> </p>
				<p class="uppercase">Catégorie : <?php echo $nom_categories;?> </p>
				<p class="uppercase">Format : <?php echo $formats;?> </p>
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
				<?php echo "<span class=\"nav-thumbnails-prev thumbnails_hide\">".$prev_thumbnail."</span>"; ?>
				<?php echo "<span class=\"nav-thumbnails-next thumbnails_hide\">".$next_thumbnail."</span>";?>
				
				<span class="photo-prev"> <?php previous_post_link('%link','<img src="' . get_bloginfo("template_directory") . '/assets/icones/prev.png" />'); ?> </span>
				<span class="photo-next"> <?php next_post_link('%link','<img src="' . get_bloginfo("template_directory") . '/assets/icones/next.png" />'); ?> </span>
			</div>
		</div>
	

	</main>

	<aside class="aside-photo-comp">
		
		<h3> Vous aimerez aussi </h3>

			<div class="row-img-similaires">
			
			<?php
                   
        	$args_photos_similaires = array(
            'post_type' => 'photo',
			'post__not_in' => array($id_photo),
            'posts_per_page' => 2,
            'tax_query' => array(
                                array(
                                    'taxonomy' => 'categorie',
                                    'field' => 'slug',
                                    'terms' => $slug_categories, 
                                ),
                            ),
                        );
                
			$my_query = new WP_Query($args_photos_similaires);

            if ($my_query->have_posts()) : ?>
	
                    
                <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
					<div class="col-img-similaire">
                        <a href="<?php echo get_permalink(); ?>">
                        <?php the_post_thumbnail(); ?> </a>
					</div>
                <?php endwhile; ?>

			<?php else : ?>
    			<p> Il n'y a pas de photos apparentées pour cette catégorie </p> 	
               
            <?php endif; ?>

        	<?php wp_reset_postdata(); ?>
		
			</div>

	</aside>



<?php
get_footer();

			



		

	


