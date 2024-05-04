<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nathalie-mota
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

<div id="NM-page">

	<header id="NM-header" class="">
		
		<nav role="navigation" aria-label="<?php _e('Menu principal', 'text-domain'); ?>" id="NM-nav-header">

			 <a href="<?php echo home_url( '/' ); ?>." id="logo-header">
				<img src=" <?php echo get_stylesheet_directory_uri() .'/assets/logo/Logo.png'; ?> " alt="Logo de la photographe évènementielle Nathalie Mota">
			</a>

  			<?php
    			wp_nav_menu([
        			'theme_location' => 'main-menu',
        			'container'      => false,
        			'walker'         => new Nathalie_Mota_Walker_Nav_Menu(),
					'menu_id' 		 => 'header-menu'
    			]);
  			?>

			<button id="NM-button-burger" type="button" aria-expanded="false" aria-controls="primary-menu" class="menu_button">
    			<span class="menu_button_line top"></span>
    			<span class="menu_button_line mid"></span>
    			<span class="menu_button_line botm"></span>
  			</button>
		</nav>
	</header>

