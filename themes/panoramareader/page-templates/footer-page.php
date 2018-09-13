<?php
/* ==============================================
	Template Name: Footer
	Daze - Premium WordPress Theme, by NordWood
================================================= */
	get_header();
	
	$layout_class = "";
	if( 'include-sidebar' === daze_get_meta( 'daze_include_sidebar' ) ) {
		$layout_class = "include-sidebar";
	}
?>
	<div class="main-holder content-wrapper clearfix">
		<div class="post-header">
		<?php
			if ( 'hide-title' !== daze_get_meta( 'daze_pages_hide_title' ) ) {
				the_title( '<h1>', '</h1>' );
			}
			
		// Edit
			daze_edit_page();
		?>
		</div>
		
		<div class="featured-area">
		<?php
			if(
				has_post_thumbnail() &&
				!(
					daze_get_meta( 'daze_hide_featured_image' ) ||
					( true === get_theme_mod( 'daze_hide_featured_image' ) && !( daze_posts_get_meta( 'daze_ignore_global' ) ) )
				)
			) :
		?>
			<div class="featured-img"><?php echo get_the_post_thumbnail(); ?></div>
		<?php else : ?>
			<div class="h-line"></div>
		<?php endif; ?>
		</div><!-- .featured-area -->
		
		<main id="main" class="clearfix <?php echo esc_attr( $layout_class ); ?>">
		<?php
		while ( have_posts() ) :
			the_post();
			
			get_template_part( 'template-parts/content', 'page' );
			
		endwhile;
		?>
		</main><!-- #main -->
	
		<?php
			if( daze_get_meta( 'daze_include_sidebar' ) ) {
				get_sidebar();
			}
		?>
	</div><!-- .main-holder -->
		
<?php get_footer(); ?>