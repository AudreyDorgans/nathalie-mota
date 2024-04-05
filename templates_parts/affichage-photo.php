 <?php if ($my_query->have_posts()) : ?>

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
		

