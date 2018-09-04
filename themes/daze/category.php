<?php
/* ==============================================
	CATEGORY ARCHIVE
	Daze - Premium WordPress Theme, by NordWood
================================================= */
	get_header();

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	
	if ( have_posts() ) :	
		$layout_type = get_theme_mod( 'daze_custom_category_layout',  false ) ?
			get_theme_mod( 'daze_category_layout_type', 'tiny' ) :
			get_theme_mod( 'daze_blog_layout_type', 'masonry' );
		
		$layout_width = get_theme_mod( 'daze_custom_category_layout', false ) ?
			get_theme_mod( 'daze_category_layout_width', 'narrow' ) :
			get_theme_mod( 'daze_blog_layout_width', 'narrow' );
		
		$s = get_theme_mod( 'daze_custom_category_layout', false ) ?
			get_theme_mod( 'daze_category_include_sidebar', false ) :
			get_theme_mod( 'daze_include_sidebar', false );		
		
		$show_sidebar = ( 'standard-list' != $layout_type && 'full-width' === $layout_width ) ? false : $s;
	/*
		==# Begin of Daze demo code adjustments #==
		The following piece of code is created for the demo content only
		and will only affect the categories with the slugs:
		daze-demo-masonry-3
		daze-demo-masonry-2-sidebar
		daze-demo-masonry-5
		daze-demo-masonry-4-mini
		daze-demo-standard-sidebar
		
		Each of them has different layout settings, in order to represent
		the different blog layouts for the home page.
		Once you remove those categories, or rename their slugs,
		they will inherit your own settings from Customizer
		and all the category archives will behave the same way.
	*/
	// Layout type	
		if( is_category( 'daze-demo-masonry-3' ) || is_category( 'daze-demo-masonry-2-sidebar' ) || is_category( 'daze-demo-masonry-5' ) ) {
			$layout_type = 'masonry';
		}
		
		if( is_category( 'daze-demo-masonry-4-mini' ) ) {
			$layout_type = 'masonry-mini';
		}
		
		if( is_category( 'daze-demo-standard-sidebar' ) ) {
			$layout_type = 'standard-list';
		}
		
	// Layout width
		if( is_category( 'daze-demo-masonry-3' ) || is_category( 'daze-demo-masonry-2-sidebar' ) || is_category( 'daze-demo-standard-sidebar' ) ) {
			$layout_width = 'narrow';
		}
		
		if( is_category( 'daze-demo-masonry-5' ) || is_category( 'daze-demo-masonry-4-mini' ) ) {
			$layout_width = 'full-width';
		}
		
	// Sidebar
		if( is_category( 'daze-demo-masonry-3' ) || is_category( 'daze-demo-masonry-5' ) || is_category( 'daze-demo-masonry-4-mini' ) ) {
			$show_sidebar = false;
		}
		
		if( is_category( 'daze-demo-masonry-2-sidebar' ) || is_category( 'daze-demo-standard-sidebar' ) ) {
			$show_sidebar = true;
		}
		
	// Show the default archive header for all the categories, except the ones listed above
		if( !(
			is_category( 'daze-demo-masonry-3' )
			|| is_category( 'daze-demo-masonry-2-sidebar' )
			|| is_category( 'daze-demo-masonry-5' )
			|| is_category( 'daze-demo-masonry-4-mini' )
			|| is_category( 'daze-demo-standard-sidebar' )
		) ) {
	/*
		==# End of Daze demo code adjustments #==
	*/
	?>
		<div class="archive-header-holder content-wrapper clearfix">
			<div class="archive-header post-header">
				<h6><?php esc_html_e( 'Category:', 'daze' ); ?></h6>
				<h1><?php echo esc_html( single_cat_title( '', false ) ); ?></h1>
				<div class="post-meta"><?php echo apply_filters( 'the_content', term_description() ); ?></div>
			</div>
		</div>
	<?php
	/*
		==# Begin of Daze demo code adjustments #==
	*/
		}
		
		$post_order = 0;
	/*
		==# End of Daze demo code adjustments #==
	*/
	?>			
		<div class="main-holder content-wrapper clearfix">
			<div class="content-wrapper featured-area"></div>
		<?php
		// Get the sidebar 'blog_top' if it has active widgets
			if ( is_active_sidebar( 'sidebar-blog_top' )  ) {
		?>
			<div id="sidebar-blog_top" class="sidebar"><?php dynamic_sidebar( 'sidebar-blog_top' ); ?></div>
		<?php
			}
		?>
			<main id="main" <?php daze_main_class(); ?>>
				<div <?php daze_layout_class(); ?>><?php
				if( 'standard-list' != $layout_type ) :
				?>
					<div class="masonry-item-sizer"></div>
					<?php
				/*
					==# Begin of Daze demo code adjustments #==
					The following piece of code is created for the demo content only
					and will only affect the categories with the slugs:
					daze-demo-masonry-3
					daze-demo-masonry-2-sidebar
					daze-demo-masonry-5
					daze-demo-masonry-4-mini
					daze-demo-standard-sidebar
					
					Each of them has different layout settings, in order to represent
					the different blog layouts for the home page.
					Once you remove those categories, or rename their slugs,
					they will inherit your own settings from Customizer
					and all the category archives will behave the same way.
				*/
					if( is_category( 'daze-demo-masonry-3' ) ) {
						$bnnr_start = 2;
						$bnnr_step = 19;
						
						$soc_start = 5;
						$soc_step = 9;
						
						$tp_start = 7;
						$tp_step = 30;
					}
					
					if( is_category( 'daze-demo-masonry-5' ) ) {
						$bnnr_start = 2;
						$bnnr_step = 15;
						
						$soc_start = 5;
						$soc_step = 10;
						
						$tp_start = 7;
						$tp_step = 10;
					}
					
					if( is_category( 'daze-demo-masonry-2-sidebar' ) ) {
						$soc_start = 2;
						$soc_step = 5;
					}
				/*
					==# End of Daze demo code adjustments #==
				*/
					while ( have_posts() ) :
						the_post();
					/*
						==# Begin of Daze demo code adjustments #==
						The following piece of code is created for the demo content only
						and will only affect the categories with the slugs:
						daze-demo-masonry-3
						daze-demo-masonry-2-sidebar
						daze-demo-masonry-5
						daze-demo-masonry-4-mini
						daze-demo-standard-sidebar
						
						Each of them has different layout settings, in order to represent
						the different blog layouts for the home page.
						Once you remove those categories, or rename their slugs,
						they will inherit your own settings from Customizer
						and all the category archives will behave the same way.
					*/
						$item_order = ( $paged - 1 )*get_option( 'posts_per_page' ) + $post_order;
					
					// Image box
						if( is_category( 'daze-demo-masonry-3' ) || is_category( 'daze-demo-masonry-5' ) ) {							
							if ( daze_special_widget_order( true, $bnnr_start, $bnnr_step, $item_order ) ) {
								daze_special_box_bnnr_1();
							}
						}
						
					// Social box
						if( is_category( 'daze-demo-masonry-3' ) || is_category( 'daze-demo-masonry-5' ) || is_category( 'daze-demo-masonry-2-sidebar' ) ) {							
							if ( daze_special_widget_order( true, $soc_start, $soc_step, $item_order ) ) {
								daze_special_box_social();
							}
						}
						
					// Top posts
						if( is_category( 'daze-demo-masonry-3' ) || is_category( 'daze-demo-masonry-5' ) ) {							
							if ( daze_special_widget_order( true, $tp_start, $tp_step, $item_order ) ) {
								daze_special_box_top_posts();
							}
						}
					/*
						==# End of Daze demo code adjustments #==
					*/
					?>					
						<div class="masonry-item-wrapper">
							<div class="masonry-item">
								<?php
									if( false === get_theme_mod( 'daze_masonry_animated_bgr_off', false ) ) {
								?>
									<div class="drop-overlay pattern-bgr"></div>
								<?php
									}
								?>									
								<div class="masonry-content"><?php
									if( 'tiny' === $layout_type ) {
										get_template_part( 'template-parts/content', 'tiny' );
										
									} else {
										get_template_part( 'template-parts/content', 'masonry' );
									}								
								?></div>
							</div>
						</div>
					<?php
				/*
					==# Begin of Daze demo code adjustments #==
				*/
					$post_order++;
				/*
					==# End of Daze demo code adjustments #==
				*/
					endwhile;
				else:
					while ( have_posts() ) :
						the_post();
							
						$post_format = get_post_format();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php
							get_template_part( 'template-parts/fullheader' );
							
							if( !( "quote" === $post_format || "link" === $post_format ) ) {
								get_template_part( 'template-parts/featuredarea' );
							}
							
						/*
							==# Begin of Daze demo code adjustments #==
							The following piece of code is created for the demo content only
							and will only affect the category with the slug:
							daze-demo-standard-sidebar
							
							This category has different layout settings, in order to represent
							the different blog layouts for the home page.
							Once you remove it, or rename its slug,
							it will inherit your own settings from Customizer
							and all the category archives will behave the same way.
						*/
							if( !is_category( 'daze-demo-standard-sidebar' ) ) {
						/*
							==# End of Daze demo code adjustments #==
						*/
								get_template_part( 'template-parts/content', 'excerpt' );
							
						/*
							==# Begin of Daze demo code adjustments #==
							The following piece of code is created for the demo content only
							and will only affect the category with the slug:
							daze-demo-standard-sidebar
							
							This category has different layout settings, in order to represent
							the different blog layouts for the home page.
							Once you remove it, or rename its slug,
							it will inherit your own settings from Customizer
							and all the category archives will behave the same way.
						*/
							}
						/*
							==# End of Daze demo code adjustments #==
						*/
						?></article><!-- .post-content / .post-excerpt -->
						<?php
					endwhile;
				endif;
				?></div>
			<?php				
				daze_posts_pagination( $wp_query->max_num_pages, "2", $paged );				
				wp_reset_postdata();
				echo daze_posts_loading_animation();
			?>
			</main>
	<?php
		if ( true === $show_sidebar ) {
			get_sidebar();
		}
	?>
		</div>
<?php
	endif;
	get_footer();
?>