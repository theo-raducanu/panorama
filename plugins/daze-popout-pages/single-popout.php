<?php
/* ===================================
	Template for single Popout pages
	Daze Pop-out pages plugin
====================================== */
$post = get_post( get_the_ID() );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
	?>		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
			if( has_post_thumbnail() ) {
				echo '<div class="popout-featured-image">';
				
				if( $img_link = daze_popout_get_meta( 'daze_popout_img_link' ) ) {
				?>
				<a href="<?php echo esc_url( $img_link ); ?>" <?php if( daze_popout_get_meta( 'daze_popout_img_link_new_tab' ) === "new-tab" ) echo 'target="_blank"'; ?>><?php
					echo function_exists( 'daze_giffy_featured_img' ) ? daze_giffy_featured_img( get_the_ID() ) : get_the_post_thumbnail();
				?></a>
				<?php
				
				} else {
					echo function_exists( 'daze_giffy_featured_img' ) ?
						daze_giffy_featured_img( get_the_ID() ) :
						get_the_post_thumbnail( get_the_ID(), 'large' );
				}
				
				echo '</div>';
			}			
			
			if( get_the_content() ) {
				echo '<div class="popout-content clearfix">';
				the_title('<h1 class="popout-title">','</h1>');
				the_content();
				echo '</div>';
			}
			
			if( function_exists( 'daze_edit_post' ) ) {
				daze_edit_post();
				
			} else {
				edit_post_link(
					esc_html__( 'Edit this post', 'daze-popout-pages' )
				);
			}
		?>
		</article>
	<?php
	endwhile;
endif;
?>