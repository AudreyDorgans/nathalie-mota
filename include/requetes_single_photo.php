<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 

	/* Récupère l'id pour l'exclure par la suite des photos apparentées */
		$id_photo = get_the_id();
	
	/* Récupère les catégories pour affichage des infos photo en cours ainsi que les suggestions des photos apparentées */
		$categories = get_the_terms( get_the_ID(), 'categorie');
			foreach( $categories as $categorie ){
    			$nom_categories = $categorie->name;
				$slug_categories[] = $categorie->slug;
			}
	/* Récupère les formats pour affichage des infos photo en cours */
		$formats = get_the_terms( get_the_ID(), 'format');
			foreach( $formats as $format ){
    			$formats = $format->name;
			} 
			
	/* Récupère les liens et images pour la navigation entre les photos */
		$next_posts = get_next_posts_link(); 
		$prev_posts = get_previous_posts_link();

		$prev_post = get_previous_post();
		$prev_thumbnail = get_the_post_thumbnail( $prev_post, array(80,70)  ); 

		$next_post = get_next_post();
		$next_thumbnail = get_the_post_thumbnail( $next_post, array(80,70) ); 

?>		
		
<?php endwhile; else : ?>
<?php endif; ?>


