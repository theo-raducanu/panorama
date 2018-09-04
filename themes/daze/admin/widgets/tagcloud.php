<?php
/* ==============================================
	Daze tagcloud widget
	Daze - Premium WordPress Theme, by NordWood
================================================= */
add_action( 'widgets_init', 'daze_tagcloud_load_widget' );

if( !function_exists( 'daze_tagcloud_load_widget' ) ) :
	function daze_tagcloud_load_widget() {
		register_widget( 'daze_tagcloud_widget' );
	}
endif;

class Daze_Tagcloud_Widget extends WP_Widget {
    public function __construct() {
        $widget_ops = array(
			'description' => esc_html__( 'Cloud of the most used tags', 'daze' )
        );

        parent::__construct( 'daze_tagcloud_widget', esc_html__( 'Daze tagcloud', 'daze'), $widget_ops );
    }

// Widget frontend content
	function widget( $args, $instance ) {
		extract( $args );		
		
		$get_title = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : esc_html__( 'Tags', 'daze' );
		$title = apply_filters( 'widget_title', $get_title );
		
		echo $before_widget;
		
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		
		$tagargs = array(
			'number' => isset( $instance['num_of_tags'] ) ? absint( $instance['num_of_tags'] ) : 12,
			'orderby' => 'count',
			'order' => 'DESC'
		);
		
		$tags = get_tags( $tagargs );
		
		$tagcloud = '<div class="tagcloud">';
		foreach ( $tags as $tag ) {
			$tag_link = get_tag_link( $tag->term_id );
			
			$tagcloud .= '<a href="' . esc_url( $tag_link ) . '" title="' . esc_attr( $tag->name ) . '" class="tag">';
			$tagcloud .= '<span class="tag-name">' . esc_html( $tag->name ) . '</span>';
			$tagcloud .= '<span class="separator"></span>';
			$tagcloud .= '<span class="count">' . absint( $tag->count ) . '</span>';
			$tagcloud .= '</a>';
		}
		$tagcloud .= '</div>';
		
		echo $tagcloud;
		
		echo $after_widget;
	}

// Widget backend
	function form( $instance ) {		
		$defaults = array(
			'title' => esc_html__( 'Tags', 'daze' ),
			'num_of_tags' => 12
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'daze' ) ?></label>
			<input type="text" class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				value="<?php echo esc_attr( esc_html( $instance['title'] ) ); ?>"
			>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'num_of_tags' ) ); ?>"><?php esc_html_e( 'Number of tags:', 'daze' ) ?></label>
			<input type="number" class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'num_of_tags' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'num_of_tags' ) ); ?>"
				value="<?php echo esc_attr( $instance['num_of_tags'] ); ?>"
			>
		</p>
	<?php
	}

    // widget update
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['num_of_tags'] = absint( $new_instance['num_of_tags'] );

		return $instance;
	}
}
?>