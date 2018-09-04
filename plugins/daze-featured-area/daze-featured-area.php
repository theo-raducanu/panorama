<?php /*
Plugin Name:    Daze Featured Area
Description:    Custom fields for the featured area on various post formats
Version:		1.1
Author:         NordWood Themes
Author URI:		http://nordwoodthemes.com/
Text Domain:	daze-featured-area
*/

/* Get custom fields
====================== */
	if( !function_exists( 'daze_featured_area_get_meta' ) ) :
		function daze_featured_area_get_meta( $value ) {
			global $post;

			$field = get_post_meta( $post->ID, $value, true );
			
			if( !empty( $field ) ) {
				return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
				
			} else {
				return false;
			}
		}
	endif;

	if( !function_exists( 'daze_featured_area_add_meta' ) ) :
		function daze_featured_area_add_meta() {
			add_meta_box(
				'daze_featured_area_meta_boxes-daze-featured-area-meta-boxes',
				esc_html__( 'Featured Area', 'daze-featured-area' ),
				'daze_featured_area_html',
				'post',
				'after_title',
				'high'
			);
		}
	endif;
	
	add_action( 'add_meta_boxes', 'daze_featured_area_add_meta' );
	
/* Create custom fields
========================= */
	if ( !function_exists( 'daze_featured_area_html' ) ):
		function daze_featured_area_html( $post) {
			wp_nonce_field( '_daze_featured_area_nonce', 'daze_featured_area_nonce' );
		?>			
			<div id="daze-featured-image" class="daze-featured-metabox">
				<?php esc_html_e( 'Please scroll down to the "Featured Image" section to upload your photo.', 'daze-featured-area' ); ?>
			</div><!-- post format: image -->
			
			<div id="daze-featured-gallery" class="daze-featured-metabox">
				<label for="daze_featured_gallery"><?php esc_html_e( 'Gallery images', 'daze-featured-area' ); ?></label>
				
				<?php
					$get_current_imgs = explode( ', ', daze_featured_area_get_meta( 'daze_featured_gallery' ) );				
					$current_imgs_is_array = is_array( $get_current_imgs );
					
					if( $get_current_imgs == array("") ) {
						$get_current_imgs = array();
					}
				?>

				<div class="gallery-preview clearfix"><?php
				if( $current_imgs_is_array ) :
					foreach( $get_current_imgs as $each_img_id ) : 
						$each_img_src = wp_get_attachment_image_src( $each_img_id, 'thumbnail' );
					?>			
						<div class="img-wrapper">
							<span class="remove-image">X</span>
							<img src="<?php echo esc_url( $each_img_src[0] ); ?>" class="gallery-img" />
							<input type="hidden" class="img-id"
								id="img-id-<?php echo absint( $each_img_id ); ?>"
								name="img-id-<?php echo absint( $each_img_id ); ?>"
								value="<?php echo absint( $each_img_id ); ?>"
							>
						</div>
					<?php
					endforeach;
				endif;
				?></div>
				
				<input type="button" class="button add-images"
					id="daze_featured_area_add_to_gallery"
					name="daze_featured_area_add_to_gallery"
					value="<?php esc_attr_e( 'Add images', 'daze-featured-area' ); ?>"
				>
				
				<input type="button" class="button remove-all"
					id="daze_featured_area_remove_from_gallery"
					name="daze_featured_area_remove_from_gallery"
					value="<?php esc_attr_e( 'Remove all images', 'daze-featured-area' ); ?>"
				>
					
				<div class="gallery-data">
					<input type="hidden" class="widefat gallery-ids"
						id="daze_featured_gallery"
						name="daze_featured_gallery"
						value="<?php echo esc_attr( daze_featured_area_get_meta( 'daze_featured_gallery' ) ); ?>"
					>
				</div>
			</div><!-- post format: gallery -->
			
			<div id="daze-featured-video" class="daze-featured-metabox">
				<label for="daze_featured_video_url"><?php esc_html_e( 'Video URL', 'daze-featured-area' ); ?></label>
				<input type="url" class="widefat"
					name="daze_featured_video_url"
					id="daze_featured_video_url"		
					value="<?php echo esc_url_raw( daze_featured_area_get_meta( 'daze_featured_video_url' ) ); ?>"
				>
			</div><!-- post format: video -->
			
			<div id="daze-featured-audio" class="daze-featured-metabox">
				<label for="daze_featured_audio_url"><?php esc_html_e( 'Audio URL', 'daze-featured-area' ); ?></label>
				<input type="url" class="widefat"
					name="daze_featured_audio_url"
					id="daze_featured_audio_url"		
					value="<?php echo esc_url_raw( daze_featured_area_get_meta( 'daze_featured_audio_url' ) ); ?>"
				>
			</div><!-- post format: audio -->
			
			<div id="daze-featured-link" class="daze-featured-metabox">
				<label for="daze_featured_link"><?php esc_html_e( 'Link (URL)', 'daze-featured-area' ); ?></label>
				<input type="url" class="widefat"
					name="daze_featured_link"
					id="daze_featured_link"
					value="<?php echo esc_url_raw( daze_featured_area_get_meta( 'daze_featured_link' ) ); ?>"
				>
			</div><!-- post format: link -->
			
			<div id="daze-featured-quote" class="daze-featured-metabox">
				<label for="daze_featured_quote"><?php esc_html_e( 'Quote', 'daze-featured-area' ); ?></label><br>
				<textarea class="widefat" rows="5"
					name="daze_featured_quote"
					id="daze_featured_quote"
				><?php echo esc_textarea( daze_featured_area_get_meta( 'daze_featured_quote' ) ); ?></textarea>
				
				<label for="daze_featured_quote_author"><?php esc_html_e( 'Author', 'daze-featured-area' ); ?></label><br>	
				<input type="text" class="widefat"
					name="daze_featured_quote_author"
					id="daze_featured_quote_author"
					value="<?php echo esc_attr( daze_featured_area_get_meta( 'daze_featured_quote_author' ) ); ?>"
				>		
			</div><!-- post format: quote -->
	<?php
		}
	endif;	
	
/* Updating custom fields
=========================== */
	if( !function_exists( 'daze_featured_area_save' ) ):
		function daze_featured_area_save( $post_id ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			if( !isset( $_POST['daze_featured_area_nonce'] ) || !wp_verify_nonce( $_POST['daze_featured_area_nonce'], '_daze_featured_area_nonce' ) ) {
				return;
			}
			
			if( !current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			if( isset( $_POST['daze_featured_video_url'] ) ) {
				update_post_meta( $post_id, 'daze_featured_video_url', esc_url_raw( $_POST['daze_featured_video_url'] ) );				
				
			} else {
				update_post_meta( $post_id, 'daze_featured_video_url', null );
			}
				
			
			if( isset( $_POST['daze_featured_audio_url'] ) ) {
				update_post_meta( $post_id, 'daze_featured_audio_url', esc_url_raw( $_POST['daze_featured_audio_url'] ) );
				
			} else {
				update_post_meta( $post_id, 'daze_featured_audio_url', null );
			}
			
			if( isset( $_POST['daze_featured_link'] ) ) {
				update_post_meta( $post_id, 'daze_featured_link', esc_url_raw( $_POST['daze_featured_link'] ) );
				
			} else {
				update_post_meta( $post_id, 'daze_featured_link', null );
			}
			
			if( isset( $_POST['daze_featured_quote'] ) ) {
				update_post_meta( $post_id, 'daze_featured_quote', sanitize_text_field( $_POST['daze_featured_quote'] ) );
				
			} else {
				update_post_meta( $post_id, 'daze_featured_quote', null );				
			}
			
			if( isset( $_POST['daze_featured_quote_author'] ) ) {
				update_post_meta( $post_id, 'daze_featured_quote_author', sanitize_text_field( $_POST['daze_featured_quote_author'] ) );
				
			} else {
				update_post_meta( $post_id, 'daze_featured_quote_author', null );
			}
			
			if( isset( $_POST['daze_featured_gallery'] ) ) {
				update_post_meta( $post_id, 'daze_featured_gallery', sanitize_text_field( $_POST['daze_featured_gallery'] ) );
				
			} else {
				update_post_meta( $post_id, 'daze_featured_gallery', null );
			}
		}
	endif;
	
	add_action( 'save_post', 'daze_featured_area_save' );
	
	
/* Place metaboxes above the main editor
========================================== */
	if( !function_exists( 'daze_featured_area_position' ) ):
		function daze_featured_area_position() {
			global $post, $wp_meta_boxes;
			do_meta_boxes( get_current_screen(), 'after_title', $post );
		}
	endif;
	
	add_action( 'edit_form_after_title', 'daze_featured_area_position' );

	
/* Shortcodes
================ */	
// Featured video	
	if( !function_exists( 'daze_shortcode_featured_area_video' ) ):
		function daze_shortcode_featured_area_video() {
			if( $video_url = daze_featured_area_get_meta( 'daze_featured_video_url' ) ) {
				global $wp_embed;
				
				return $wp_embed->run_shortcode('[embed]' . esc_url( $video_url ) . '[/embed]');
			}
		}
	endif;
	
	add_shortcode( 'daze-shortcode-featured-video', 'daze_shortcode_featured_area_video' );
	
// Featured audio	
	if( !function_exists( 'daze_shortcode_featured_area_audio' ) ):
		function daze_shortcode_featured_area_audio() {
			if( $audio_url = daze_featured_area_get_meta( 'daze_featured_audio_url' ) ) {
				global $wp_embed;
				
				return $wp_embed->run_shortcode('[embed]' . esc_url( $audio_url ) . '[/embed]');
			}
		}
	endif;
	
	add_shortcode( 'daze-shortcode-featured-audio', 'daze_shortcode_featured_area_audio' );	
	
// Featured link	
	if( !function_exists( 'daze_shortcode_featured_area_link' ) ):
		function daze_shortcode_featured_area_link() {	
			if( $link_url = daze_featured_area_get_meta( 'daze_featured_link' ) ) {
				return sprintf(
					'<a href="%s" target="_blank">%s</a>',
					esc_url( $link_url )
				);
			}
		}
	endif;
	
	add_shortcode( 'daze-shortcode-featured-link', 'daze_shortcode_featured_area_link' );
	
// Featured gallery
	if( !function_exists( 'daze_shortcode_featured_area_gallery' ) ):
		function daze_shortcode_featured_area_gallery() {
			if( $gallery_ids = daze_featured_area_get_meta( 'daze_featured_gallery' ) ) {
				return do_shortcode( '[gallery include="' . esc_attr( $gallery_ids ) . '"]' );
			}
		}
	endif;
	
	add_shortcode( 'daze-shortcode-featured-gallery', 'daze_shortcode_featured_area_gallery' );	
	
// Featured quote
	if( !function_exists( 'daze_shortcode_featured_area_quote' ) ):
		function daze_shortcode_featured_area_quote() {
			if( $quotation = daze_featured_area_get_meta( 'daze_featured_quote' ) ) {		
				$quote = '<span class="quotation">&ldquo;' . esc_html( $quotation ) . '&rdquo;</span>';
				
				if( $author = daze_featured_area_get_meta( 'daze_featured_quote_author' ) ) {
					$quote .= '&mdash;<span class="quote-author">' . esc_html( $author ) . '</span>';
				}
				
				return $quote;
			}
		}
	endif;
	
	add_shortcode( 'daze-shortcode-featured-quote', 'daze_shortcode_featured_area_quote' );
	
/* Scripts & Styles
===================== */
	if( !function_exists( 'daze_featured_area_scripts' ) ):
		function daze_featured_area_scripts( $hook ) {
			if( 'post.php' != $hook && 'post-new.php' != $hook ) {
				return;
			}	
			
			global $post;
			
		/* Switch active featured area metabox as the post format changes */
			wp_enqueue_script(
				'daze_featured_area_switch',
				plugin_dir_url( __FILE__ ) . '/js/featured-area-switch.js',
				array('jquery'),
				'',
				true
			);
			
		/* Prepare the WordPress Media Uploader */
			wp_enqueue_media();
			wp_register_script(
				'daze_featured_gallery',
				plugin_dir_url( __FILE__ ) . '/js/images-to-gallery.js',
				array('jquery'),
				'',
				true
			);
			
		// Pass the selected gallery images data to the JavaScript above
			$get_current_imgs = explode(', ', daze_featured_area_get_meta( 'daze_featured_gallery' ));				
			$current_imgs_is_array = is_array( $get_current_imgs );
			
			if( $get_current_imgs == array("") ) {
				$get_current_imgs = array();
			}
			
			$gallargs = array(
				'get_current_imgs' => $get_current_imgs
			);
				
			wp_localize_script('daze_featured_gallery', 'gallargs', $gallargs );			
			wp_enqueue_script( 'daze_featured_gallery' );
			
			wp_enqueue_style( 'daze_featured_area', plugin_dir_url( __FILE__ ) . '/css/featured-area.css' );
		}
	endif;
	
	add_action('admin_enqueue_scripts', 'daze_featured_area_scripts');
?>