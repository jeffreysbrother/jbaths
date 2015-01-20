<?php
/**
 * @package jbaths
 */

global $post;
?>

<h2 class="entry-title">
	<a href="<?php echo get_permalink(); ?>">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="search-result-header">
				<?php the_title( '', '' ); ?>
				<?php the_excerpt(); ?>
				<div class="entry-meta">
					<?php jbaths_posted_on(); ?>
				</div><!-- .entry-meta -->
			</header><!-- .entry-header -->
		</article><!-- #post-## -->
	</a>
</h2>