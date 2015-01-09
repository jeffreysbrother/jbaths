<?php
/**
 * The template used for displaying page content in page.php
 *
 * NOTE : template no longer used : now moved just to page.php
 *
 * @package jbaths
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php 
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<div id="breadcrumbs">', '</div>' );
		}
		the_title( '<h1 class="title">', '</h1>' );
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
