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



		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="search-result-header">
				<h2 class="entry-title">
					<?php if ( $attachment ) { ?>
						<a href="<?php echo wp_get_attachment_url( $post->ID ); ?>">
					<?php } else { ?>
						<a href="<?php echo get_permalink(); ?>">
					<?php } ?>
						<?php the_title( '', '' ); ?>
						</a>	
				</h2>
			</header><!-- .entry-header -->

			<?php if ( $post->post_mime_type == 'application/pdf' ) { ?>
			<section class="search-content">
				<a href="<?php echo wp_get_attachment_url( $post->ID ); ?>" alt="Download PDF" title="Download PDF"><img src="<?php echo get_template_directory_uri(); ?>/images/pdf_download.png"  alt="Download PDF"/></a>
			</section>
			<?php } ?>

			<?php if ( ! $attachment ) { ?>
			<section class="search-excerpt">
				<p>
					<?php the_excerpt(); ?>
				</p>
				<p style="text-align: right;">
					<a class="vc_btn vc_btn_grey vc_btn-grey vc_btn_md vc_btn-md vc_btn_square_outlined btn-search-more" href="<?php the_permalink(); ?>" title="" target="">LEARN MORE</a>
				</p>
			</section>
			<?php } ?>

			<div class="entry-meta">
				<?php jbaths_posted_on(); ?>
			</div><!-- .entry-meta -->

		</article><!-- #post-## -->
