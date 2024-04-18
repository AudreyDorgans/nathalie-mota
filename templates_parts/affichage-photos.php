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
				<button class="load-lightbox-photo"
    				data-postid="<?php echo get_the_ID(); ?>"
    				data-nonce="<?php echo wp_create_nonce('NM_load_lightbox_photo'); ?>"
    				data-action="NM_load_lightbox_photo"
    				data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">
					<i class="fa-sharp fa-solid fa-expand"></i>
				</button>
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

		<div class="no-photo-message-1"></div>
		<div class="no-photo-message-2" style="display: none;"> <p>Il n'y a pas, pour le moment, d'autres photos disponibles.</p></div>


		<!-- Lightbox -->
		<div class="lightbox">
		<?php 
			$next_post = $infos_photo['next_posts'];
			$prev_post = $infos_photo['prev_posts'];
		?>
    	<div class="container-elements-lightbox">
        <button class="lightbox_close">X</button>
        <button class="lightbox_prev"><a href="<?php echo $prev_post ? get_permalink($prev_post) : '#'; ?>">Précédent</a></button>
        <button class="lightbox_next"><a href="<?php echo $next_post ? get_permalink($next_post) : '#'; ?>">Suivant</a></button></button>

        <div class="lightbox__container">
            <img class="lightbox-image" src="" alt="Photo">
        </div>

        <div class="lightbox__container">
            <span class="reference"></span>
            <span class="categorie"></span>
        </div>
    </div>
</div>

		

 <!-- AFFICHAGE SINGLE_PHOTO --> 
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


 


				