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

			<?php if ( $post->post_mime_type == 'application/pdf' ) { ?>
			<section class="search-content">
				<a href="<?php echo wp_get_attachment_url( $post->ID ); ?>">Download</a>
			</section>
			<?php } ?>

			<?php if ( ! $attachment ) { ?>
			<section class="search-excerpt">
				<p>
					<?php the_excerpt(); ?>
				</p>
			</section>
			<?php } ?>

			<div class="entry-meta">
				<?php jbaths_posted_on(); ?>
			</div><!-- .entry-meta -->

		</article><!-- #post-## -->
</a>