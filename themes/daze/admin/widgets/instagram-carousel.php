<?php 
/* ===============================================
	Daze Instagram carousel widget
	Daze - Premium WordPress Theme, by NordWood
================================================== */
add_action( 'widgets_init', 'daze_insta_car_init' );

if( !function_exists( 'daze_insta_car_init' ) ) :
	function daze_insta_car_init() {
		register_widget( 'daze_insta_car' );
	}
endif;
 
class Daze_Insta_Car extends WP_Widget { 	
    public function __construct() {
        $widget_ops = array(
            'classname' => 'insta insta-car social-instagram clearfix',
            'description' => esc_html__( 'Show Instagram feed', 'daze' )
        );
 
        parent::__construct( 'daze_insta_car', esc_html__( 'Daze Instagram carousel', 'daze' ), $widget_ops );
		
		add_action( 'wp_enqueue_scripts', array($this, 'daze_insta_car_widget_assets') );
    }

	public function daze_insta_car_widget_assets() {
		wp_enqueue_style( 'daze_assets_slick_slider' );
		wp_enqueue_script( 'daze_instagram_carousel' );
	}
	
// Widget frontend
    function widget( $arg, $instance ) {
		
        extract($arg);
		
		$get_title = isset( $instance['title'] ) ? esc_html( $instance['title'] ) : esc_html__( 'Follow me on Instagram', 'daze' );
		
		$i_user = isset( $instance['i_user'] ) ? $instance['i_user'] : 'nordwood';
		
		$title = sprintf(
			'<a href="http://instagram.com/%1$s" target="_blank">%2$s%3$s</a>',
			esc_attr($i_user),
			daze_get_svg_instagram(),
			apply_filters( 'widget_title', $get_title )
		);
		
		$num = isset( $instance['num'] ) ? absint( $instance['num'] ) : 9;
	
		$user = wp_remote_get( esc_url_raw( 'http://instagram.com/'.$i_user ) );
		
		if( is_wp_error( $user ) || empty( $instance['i_user'] ) || 'OK' != $user['response']['message'] ) {
			return '';
			
		} else if( 'OK' === $user['response']['message'] ) {
			$user_body = explode( 'window._sharedData = ', $user['body'] );
			$insta_json = explode( ';</script>', $user_body[1] );
			$user_array = json_decode( $insta_json[0], TRUE );
		
			echo $before_widget;
		
			if ( $get_title ) {
				echo $before_title . $title . $after_title;		
			}
		
			$items = $user_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
			
			if( ( $count = $user_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['count'] ) < $num ) {
				$num = $count;
			}
			
			$size = 'spread';
			
			if( 'sidebar-1' == $arg['id'] ) {
				$size = 'mini';				
			}
			
			?>
			<div class="carousel <?php echo esc_attr( $size ); ?>">
			<?php
			for( $i = 0; $i < $num; $i++ ) {
				$item = $items[$i]['node'];
			?>
				<div class="item">
					<a href="<?php echo esc_url( 'http://instagram.com/p/'.$item['shortcode'] ); ?>" target="_blank" >
						<div class="overlay">
							<table class="stats"><tbody>
								<tr>
									<td>
										<?php echo daze_get_svg_heart(); ?>
										<span><?php echo absint( $item['edge_liked_by']['count'] ); ?></span>
									</td>
									<td>									
										<?php echo daze_get_svg_comments_cloud(); ?>
										<span><?php echo absint( $item['edge_media_to_comment']['count'] ); ?></span>
									</td>
								</tr>
							</tbody></table>
						</div>
						<img data-lazy="<?php echo esc_attr( $item['thumbnail_src'] ); ?>" />
					</a>
				</div>			
			<?php		
			}
			?>
			</div>			
			<?php
			echo $after_widget;
			
		} else {
			return '';
		}
    }
	
// Widget backend
    function form( $instance ) {	
		$defaults = array(
				'title' => esc_html__( 'Follow me on Instagram', 'daze' ),
				'i_user' => 'nordwood',
				'num' => 9
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$i_user = $instance['i_user'];
		$num = absint( $instance['num'] );
		$user = wp_remote_get( esc_url_raw( 'http://instagram.com/'.$i_user ) );
			
		if( is_wp_error( $user ) ) {
		?>
			<p style="color: #f00;"><?php
				$error_message = $user->get_error_message();
				
				printf(
					'%1$s %2$s',
					esc_html__( 'Oops, something went wrong: ', 'daze' ),
					esc_html( $error_message )
				);
			?></p>
		<?php
		} else if( empty( $instance['i_user'] ) ) {
		?>
			<p style="color: #f00;"><?php esc_html_e( 'Username field is empty.', 'daze' ); ?></p>
			
		<?php
		} else if( 'OK' != $user['response']['message'] ) {
		?>
			<p style="color: #f00;"><?php esc_html_e( 'No such profile found.', 'daze' ); ?></p>
		<?php
		}
	?>	
		<p>	
			<label for="<?php echo esc_attr( $this->get_field_name('title') ); ?>"><?php esc_html_e( 'Title:', 'daze' ); ?></label>			
			<input type="text" class="widefat"
				name="<?php echo esc_attr( $this->get_field_name('title') ); ?>"
				id="<?php echo esc_attr( $this->get_field_id('title') ); ?>"
				value="<?php echo esc_attr( $instance['title'] ); ?>"
			>
		</p>
		
		<p>	
			<label for="<?php echo esc_attr( $this->get_field_name('i_user') ); ?>"><?php esc_html_e( 'Instagram username:', 'daze' ); ?></label>			
			<input type="text" class="widefat"
				name="<?php echo esc_attr( $this->get_field_name('i_user') ); ?>"
				id="<?php echo esc_attr( $this->get_field_id('i_user') ); ?>"
				value="<?php echo esc_attr( $instance['i_user'] ); ?>"
			>
		</p>
		
		<p>
			<input type="number"
				name="<?php echo esc_attr( $this->get_field_name('num') ); ?>"
				id="<?php echo esc_attr( $this->get_field_id('num') ); ?>"
				value="<?php echo absint( $instance['num'] ); ?>"
			>
			<label for="<?php echo esc_attr( $this->get_field_id('num') ); ?>"><?php esc_html_e( 'Number of items', 'daze' ); ?></label>
		</p>
	<?php
    }
	
//saving widget data 
    function update( $new_instance, $old_instance ) {  
        $instance = $old_instance;
		
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['i_user'] = sanitize_text_field( $new_instance['i_user'] );
        $instance['num'] = absint( $new_instance['num'] );	

        return $instance;
    }
}
?>