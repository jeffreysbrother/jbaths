<?php
/**
 * The Template for displaying all single posts.
 *
 * @package jbaths
 */

get_header();

while ( have_posts() ) :
	the_post();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<div class="title">', '</div>' ); 
		/*
		<div class="breadcrumbs"><a href="../" title="Back" class="back tobaths">Bathtubs</a></div>
		*/
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
<?php
	//jbaths_post_nav();
endwhile; // end of the loop.

get_footer(); ?>