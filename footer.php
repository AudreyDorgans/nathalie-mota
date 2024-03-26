<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nathalie-mota
 */

?>

<div class="container-footer">
	<footer class="NM-footer">
		<?php
    			wp_nav_menu([
        			'theme_location' => 'footer-menu',
        			'container'      => false,
					'menu_id' 		 => 'footer-menu'
    			]);
  		?>

	</footer>
</div>
</div> <!-- #NM-page -->

<?php wp_footer(); ?>

</body>
</html>
