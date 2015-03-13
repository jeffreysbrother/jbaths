<?php
/**
 * @package jbaths
 */

global $post;

$attachment = false;

if ( wp_get_attachment_url( $post->ID ) ) {
	$attachment = true;
}

?>

<?php if ( $attachment ) { ?>
	<a href="<?php echo wp_get_attachment_url( $post->ID ); ?>">
<?php } else { ?>
	<a href="<?php echo get_permalink(); ?>">
<?php } ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="search-result-header">
				<h2 class="entry-title">
					<?php the_title( '', '' ); ?>
				</h2>
			</header><!-- .entry-header -->

			<section class="search-content">
				<?php if ( has_post_thumbnail() ) { ?>
					<?php //the_post_thumbnail('small'); ?>

				<?php } else if ( wp_attachment_is_image( $post->ID ) ) { ?>
					<?php echo wp_get_attachment_image( $post->ID, 'small' ); ?>
					<p>File type: <?php echo $post->post_mime_type; ?></p>

				<?php } else if ( $post->post_mime_type == 'application/pdf' ) { ?>
					<a href="<?php echo wp_get_attachment_url( $post->ID ); ?>">Download</a>
					<p>File type: <?php echo $post->post_mime_type; ?></p>

				<?php } ?>
			</section>

			<section class="search-excerpt">
				<?php the_excerpt(); ?>
			</section>

			<div class="entry-meta">
				<?php jbaths_posted_on(); ?>
			</div><!-- .entry-meta -->

		</article><!-- #post-## -->
</a>