<?php
/**
 * Template index.php Nathalie Mota
 * pages générales
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package nathalie-mota
 */

get_header();
?>


<main class="main-index">

<h1><?php single_post_title(); ?></h1>

<?php $content = apply_filters( 'the_content', get_the_content() );
echo $content;?>

		
</main>

<?php
get_footer();