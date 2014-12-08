<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package jbaths
 */

get_header(); ?>
	<header class="entry-header">
		<!-- BREADCRUMBS here -->
		<h1 class="title">Bathtubs</h1>
		<!-- BATHTUB SELECTOR here -->
	</header><!-- .entry-header -->
<?php if ( have_posts() ) { ?>
	<article class="page">
		<div class="entry-content">
			<div class="baths-filters">
				<div class="wpb_row vc_row-fluid">
	<div class="vc_span2 wpb_column column_container fcol-size"><div class="wpb_wrapper"><div class="wpb_text_column wpb_content_element"><div class="wpb_wrapper"><h4>SIZE</h4>
<p><select name="length" id="filter-length">
<option value="">Length</option>
<?php
/* hardcoded? */
$sizes = array(72,71,66,62,60,56,55);
$n = count($sizes);
while ( $n-- ) {
	$s = absint( $sizes[$n] );
	echo '<option value="'. $s .'">L: '. $s .'"</option>';
}
?>
</select>
<br />
<br />
<select name="width" id="filter-width">
<option value="">Width</option>
<?php
/* hardcoded? */
$sizes = array(66,60,55,43,42,36,33,32,30);
$n = count($sizes);
while ( $n-- ) {
	$s = absint( $sizes[$n] );
	echo '<option value="'. $s .'">W: '. $s .'"</option>';
}
?>
</select></p>
</div></div></div></div>
<?php
/*
 * dynamically generate the other Taxonomy filters
 * ( while is faster than for? so reverse order here)
 */
$filters = array(
	array('experience'),
	array('installation'),
	array('collection'),
	array('shape')
);
/*
 * note : orderby ID order DESC because then we loop backwords for speed
 * this may need to change if we try to add a new checkbox at some point
 * and don't want new checkbox at the bottom of it's column...
 */
$termargs = array(
	'orderby' => 'id',
	'order' => 'DESC',
	'hide_empty' => false,
);
$f = 4;
while ( $f-- ) {
	$fname = $filters[$f][0];
	$args = $termargs;
	if ( $f == 1 ) {
		// exclude "Walk-In" / "walk-in"
		$args['exclude'] = array(29);
	}
	$filters[$f][1] = get_terms( $fname, $args );

	echo '<div class="vc_span2 wpb_column column_container chx fcol-'. $fname .'"><div class="wpb_wrapper"><div class="wpb_text_column wpb_content_element"><div class="wpb_wrapper"><h4>'. strtoupper( $fname ) .'</h4><p>';

	$c = count($filters[$f][1]);
	while ( $c-- ) {
		$v = $filters[$f][1][$c]->slug;
		echo '<label class="control checkbox"><input type="checkbox" id="'. $fname .'-'. $v .'" name="'. $fname .'['. $v .']" value="'. $v .'"><span class="control-indicator"></span>'. $filters[$f][1][$c]->name .'</label>';
	}
	echo '</p></div></div></div></div>';
}
//print_r($filters);
?>
				</div>
				<div class="wpb_row vc_row-fluid">
				<div class="vc_span12">
<a href="#filter" class="vc_btn vc_btn_grey vc_btn_xs vc_btn_square_outlined alignright">CLEAR</a>
				</div>
				</div>
			</div>
<?php
/* first, include content from /baths/ page?! */
$bathspage = get_page_by_title( 'Bathtubs' );
if ( $bathspage ) {
?>
			<div class="baths-content">
				<?php echo apply_filters( 'the_content', $bathspage->post_content ); ?>
			</div>
<?php
}
/* Now : Start the Loop */ ?>
			<div class="baths-results">
				<div class="wpb_row vc_row-fluid">
	<?php
	while ( have_posts() ) : the_post();
	global $post;
	$fclasses = 'bathtub';
	$bathfs = array();
	/* shapes */
	$bathfs[0] = wp_get_object_terms($post->ID, 'shape');
	/* collections */
	$bathfs[1] = wp_get_object_terms($post->ID, 'collection');
	/* installation types */
	$bathfs[2] = wp_get_object_terms($post->ID, 'installation');
	/* experiences */
	$bathfs[3] = wp_get_object_terms($post->ID, 'experience');
	$b = 4;
	while( $b-- > 0 ) {
		$l = count($bathfs[$b]);
		while( $l-- > 0 ) {
			$fclasses .= ' '. $bathfs[$b][$l]->slug;
			$bathfs[$b][$l] = $bathfs[$b][$l]->name;
		}
	}
	/* dimensions */
	$length = types_render_field( 'length' );
	$sizeattr = '" data-min-length="';
	if ( $length != '' ) {
		$sizeattr .= absint($length);
	}
	$width = types_render_field( 'width' );
	$sizeattr .= '" data-min-width="';
	if ( $width != '' ) {
		$sizeattr .= absint($width);
	}
/*
	?>
<pre style="display:none">
<?php
echo "shapes :\n";
print_r($bathfs[0]);
echo "collec :\n";
print_r($bathfs[1]);
echo "installs :\n";
print_r($bathfs[2]);
echo "exps :\n";
print_r($bathfs[3]);
echo "\n\nclasses = $fclasses";
?>
</pre>
*/ 
?>
	<div class="vc_span3 wpb_column column_container <?php esc_attr_e($fclasses); echo $sizeattr; ?>">
		<div class="wpb_wrapper">
			<a href="<?php echo get_permalink(); ?>">
			<div class="wpb_single_image wpb_content_element vc_align_center">
				<div class="wpb_wrapper">
					<?php the_post_thumbnail('full'); ?>
				</div> 
			</div>
			<div class="wpb_text_column wpb_content_element ld">
<?php
$ld = types_render_field( 'limited-distribution' );
if ( $ld ) { ?>
	<div>Limited Distribution</div><i>LD</i>
<?php } ?>
			</div>
			<div class="wpb_text_column wpb_content_element dets">
				<div class="wpb_wrapper">
		<h4><?php echo strtoupper($post->post_title); ?></h4>
		<h5><?php echo implode( ', ', $bathfs[1] ) .(count($bathfs[2]) ? '<br>' . implode( ' | ', $bathfs[2] ) : '' ) .(count($bathfs[0]) ? '<br>'. implode( ', ', $bathfs[0] ) : '' ); ?></h5>
				</div> 
			</div> 
			</a>
		</div> 
	</div>
	<?php endwhile; ?>
				</div>
			</div>
		</div>
	</article>
<?php 
	if ( $bathspage ) {
		$bcss = get_post_meta( $bathspage->ID, '_wpb_shortcodes_custom_css', true );
		if ( !empty($bcss) ) {
			echo '<style type="text/css" data-type="vc-shortcodes-custom-css">'. $bcss .'</style>';
		}
	}

} else { ?>
	<div class="baths-results empty">
		<p>Sorry, but there aren't any baths that meet your search criteria. Please change one or more of your selections to search again.</p>
	</div>
<?php
}
get_footer();
?>
