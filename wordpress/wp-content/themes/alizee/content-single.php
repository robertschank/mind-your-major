<?php
/**
 * @package Alizee
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( (has_post_thumbnail()) && ( get_theme_mod( 'alizee_post_img' )) ) : ?>
		<div class="single-thumb">
			<?php the_post_thumbnail('alizee-thumb'); ?>
		</div>	
	<?php endif; ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php alizee_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'alizee' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'alizee' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'alizee' ) );

			if ( ! alizee_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = '<i class="fa fa-tag"></i> %2$s' . '<i class="fa fa-link"></i>' . __( '<a href="%3$s" rel="bookmark"> permalink</a>.', 'alizee' );
				} else {
					$meta_text = '<span><i class="fa fa-link"></i>' . __( '<a href="%3$s" rel="bookmark"> permalink</a>', 'alizee' ) . '</span>';
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = '<span><i class="fa fa-folder"></i> %1$s</span>' . '<span><i class="fa fa-tag"></i> %2$s</span>' . '<span><i class="fa fa-link"></i>' . __( '<a href="%3$s" rel="bookmark"> permalink</a>', 'alizee' ) . '</span>';
				} else {
					$meta_text = '<span><i class="fa fa-folder"></i> %1$s</span>' . '<span><i class="fa fa-link"></i>' . __( '<a href="%3$s" rel="bookmark"> permalink</a>', 'alizee' ) . '</span>';
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'alizee' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
