<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package jbaths
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Oops! Nothing Found', 'jbaths' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'jbaths' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<h2><?php printf( __( 'Sorry, but nothing matched your search terms &ldquo;%s&rdquo;. Please try again.', 'jbaths' ), get_search_query() ); ?></h2>

		<?php else : ?>

			<h2><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'jbaths' ); ?></h2>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
