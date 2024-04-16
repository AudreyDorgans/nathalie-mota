<?php if ($my_query->have_posts()) : ?>

	<?php if ( is_front_page() ) : ?>
		
		<div class="catalogue-photos">

    	<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
	
			<?php  $infos_photo = recuperer_infos_photo(get_the_id()); ?>

			<div class="col-img-catalogue">
            	<img src="<?php echo $infos_photo['image_photo']; ?>" alt="Photo">
				<a href="<?php echo $infos_photo['permalien']; ?>" class="display-front-hover"></a>
				<span class="uppercase reference"><?php echo $infos_photo['reference']; ?></span>
                <span class="uppercase categorie"> <?php echo $infos_photo['nom_categories']; ?></span>
				<a href="<?php echo $infos_photo['permalien']; ?>"><i class="fa-regular fa-eye"></i></a>
				<i class="fa-sharp fa-solid fa-expand"></i>
			</div>

    	<?php endwhile; ?>
        </div>

		<div class="load-result catalogue-photos"></div>
		
		<button
			class="load-catalogue-photos"
    		data-postid="<?php echo get_the_ID(); ?>"
    		data-nonce="<?php echo wp_create_nonce('NM_load_catalogue_photos'); ?>"
    		data-action="NM_load_catalogue_photos"
    		data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		Charger plus
		</button>


		
    <?php elseif (is_single()) : ?>

		<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>

			<?php  $infos_photo = recuperer_infos_photo(get_the_id()); ?>
	
			<div class="col-img-similaire">
            	<a href="<?php echo $infos_photo['permalien']; ?>">
            	<img src="<?php echo $infos_photo['image_photo']; ?>" alt="Photo"> </a>
			</div>
		
		<?php endwhile; ?>

    <?php else : ?>
            <!-- ceci serait un cas ultérieur, par exemple de création du blog" --> 
    <?php endif; ?>
        
<?php endif; ?>

<?php wp_reset_postdata(); ?>


 


				