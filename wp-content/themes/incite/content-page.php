<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package incite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'incite' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<div class="fb-like" data-href="https://www.facebook.com/InciteSocialPromotion" data-width="50" data-colorscheme="dark" data-layout="button_count" data-show-faces="true" data-send="true"></div>

	<?php edit_post_link( __( 'Edit', 'incite' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
