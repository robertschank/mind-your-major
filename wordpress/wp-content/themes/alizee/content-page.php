<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Alizee
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( (has_post_thumbnail()) && ( get_theme_mod( 'alizee_page_img' )) ) : ?>
		<div class="single-thumb">
			<?php the_post_thumbnail('alizee-thumb'); ?>
		</div>	
	<?php endif; ?>	

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
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
		<?php edit_post_link( __( 'Edit', 'alizee' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
