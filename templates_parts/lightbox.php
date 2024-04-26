<!-- Lightbox -->
		<div class="lightbox">

			<div class="container-lightbox">
				
				<div class="container-elements">

					<div class="lightbox-container-image">
						<img class="lightbox-image" src="" alt="Photo">		
					</div>

					<button class="lightbox-close">
						<i class="fa-solid fa-xmark"></i>
					</button>

					<button class="lightbox-prev" data-action="NM_load_lightbox_photo" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>" data-nonce="<?php echo wp_create_nonce('NM_load_lightbox_photo'); ?>">
						<i class="fa-solid fa-arrow-left"></i> Précédente
					</button>
					<button class="lightbox-next" data-action="NM_load_lightbox_photo" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>" data-nonce="<?php echo wp_create_nonce('NM_load_lightbox_photo'); ?>">
						Suivante <i class="fa-solid fa-arrow-right"></i>
					</button>
					<span class="lightbox-reference uppercase"></span>
					<span class="lightbox-categorie uppercase"></span>
				</div>		

    		</div>

		</div>