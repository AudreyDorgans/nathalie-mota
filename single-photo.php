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

		$id_photo = get_the_id();

		$categories = get_the_terms( get_the_ID(), 'categorie');
			foreach( $categories as $categorie ){
    			$nom_categories = $categorie->name;
				$slug_categories[] = $categorie->slug;
			}

		$formats = get_the_terms( get_the_ID(), 'format');
			foreach( $formats as $format ){
    			$formats = $format->name;
			} 

		$next_posts = get_next_posts_link(); 
		$prev_posts = get_previous_posts_link();

		$prev_post = get_previous_post();
		$prev_thumbnail = get_the_post_thumbnail( $prev_post, [ 80, 80 ] ); 

		$next_post = get_next_post();
		$next_thumbnail = get_the_post_thumbnail( $next_post, [ 80, 80 ] ); 

?>		
		
<?php endwhile; else : ?>
<?php endif; ?>


	<main class="single-photo-main">   

		<div class="row-infos-photo-single">

			<div class="colonne-infos-photo">
				<h2> <?php echo get_the_title(); ?> </h2>
				<p> Référence : <span class="reference"><?php the_field( 'reference' );?></span> </p>
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
				<p> Cette photo vous intéresse ? </p>
				<button class="myBtnContact bouton-avec-reference">Contact</button>
			</div>

			<div class="photos__navigation">
				<span class="photo-prev"> <?php previous_post_link('%link','<img src="' . get_bloginfo("template_directory") . '/assets/icones/prev.png" />'); ?> </span>
				<?php echo "<span class=\"nav_thumbnails\">".$prev_thumbnail."</span>"; ?>

				<span class="photo-next"> <?php next_post_link('%link','<img src="' . get_bloginfo("template_directory") . '/assets/icones/next.png" />'); ?> </span>
				<?php echo "<span class=\"nav_thumbnails\">".$next_thumbnail."</span>";?>
			</div>
	
		</div>

		<div class="row-photo-contact">
			<h3> Vous aimerez aussi </h3>
			<div class="colonne-photo-autre colonne-photo-autre-1">
			</div>

			<div class="colonne-photo-autre colonne-photo-autre-2">
			</div>


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
                <div class="">
                    <div class="single_posts">
                        <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
                        	<a href="<?php echo get_permalink(); ?>">
                        	<?php the_post_thumbnail(); ?> </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php wp_reset_postdata(); ?>

	</div>

</main>

			



		

	


