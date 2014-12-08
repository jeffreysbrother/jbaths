<?php
/**
 * General template for displaying pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on the WordPress site may use a
 * different template.
 *
 * @package jbaths
 */

get_header();

while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php 
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
		}
		the_title( '<h1 class="title">', '</h1>' );
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

<?php
endwhile; // end of the loop.
get_footer();
?>
