<?php if ($my_query->have_posts()) : ?>

    <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
	
		<?php  $infos_photo = recuperer_infos_photo(get_the_id()); ?>
	
        <?php if ( is_front_page() ) : ?>

			<div class="col-img-catalogue">
            	<?php the_post_thumbnail(); ?> 
				<a href="<?php echo get_permalink(); ?>" class="display-front-hover"></a>
				<span class="uppercase reference"><?php the_field( 'reference' ); ?></span>
                <span class="uppercase categorie"> <?php echo $infos_photo['nom_categories']; ?></span>
				<a href="<?php echo get_permalink(); ?>"><i class="fa-regular fa-eye"></i></a>
				<i class="fa-sharp fa-solid fa-expand"></i>
			</div>

                

        <?php elseif ( is_single('photo') ) : ?>

			<div class="col-img-similaire">
            	<a href="<?php echo get_permalink(); ?>">
            	<?php the_post_thumbnail('medium_large'); ?> </a>
			</div>

        <?php else : ?>
            <!-- ceci serait un cas ultérieur, par exemple de création du blog" --> 
        <?php endif; ?>
        
    <?php endwhile; ?>

<?php endif; ?>

<?php wp_reset_postdata(); ?>


 


				