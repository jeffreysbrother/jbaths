<?php
/**
 * Template Name: Visualizer
 *
 * @package jbaths
 */

get_header();

while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php //the_content(); ?>
	<div><iframe style="float:left;width:100%" src="http://www.jacuzzi.com/visualizer/<?php
// check for ?t=
$t = get_query_var('t');
if ( $t != '' ) {
	$t = absint($t);
	if ( $t > 0 ) {
		echo '?t='. $t;
	}
}
?>" width="100%" height="748"></iframe></div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

<?php
endwhile; // end of the loop.
get_footer();
?>
