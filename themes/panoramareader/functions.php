<?php
	function daze_child_theme_enqueue_scripts() {
		wp_enqueue_style( 'daze_main', get_template_directory_uri() . '/style.css' );
		
		wp_enqueue_style( 'daze_child',
			get_stylesheet_directory_uri() . '/style.css',
			array( 'daze_main' ),
			wp_get_theme()->get('Version')
		);
		wp_enqueue_style('cs-select', get_stylesheet_directory_uri() . '/css/cs-select.css');
		wp_enqueue_style('cs-skin-border', get_stylesheet_directory_uri() . '/css/cs-skin-border.css');
		wp_enqueue_style('menu-component', get_stylesheet_directory_uri() . '/css/component.css');

		wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom.js', 'jquery');
		wp_enqueue_script('classie', get_stylesheet_directory_uri() . '/js/classie.js', 'jquery');
		wp_enqueue_script('selectFx', get_stylesheet_directory_uri() . '/js/selectFx.js', 'jquery');
		wp_enqueue_script('clipboard', get_stylesheet_directory_uri() . '/js/clipboard.min.js', 'jquery');

		
	}
	add_action('wp_enqueue_scripts', 'daze_child_theme_enqueue_scripts');
	
	
	// add_action( 'wp_enqueue_scripts', 'mdcf7_cf7_cleanup', 100 );
	// function mdcf7_cf7_cleanup() {
	// 	wp_deregister_style( 'contact-form-7' );
	// }

	// function get_contact_form() {
		
	// 	wp_register_script ( 'mdcf7-script', plugin_dir_path(__FILE__) . 'cf7-material-design/addons/js/material-cf7.js', 'jquery'); /* in a Footer */

	// 	wp_register_style( 'mdcf7-styles', plugin_dir_path(__FILE__) . 'cf7-material-design/addons/css/cf7material-styles.css', 'jquery' );
	// }
	// add_action('wp_enqueue_scripts', 'get_contact_form');
		
	function get_panorama_logo() {
		$site_logo_retina_url = get_theme_mod( 'daze_site_logo_retina' );
		$site_logo_url = get_theme_mod( 'daze_site_logo' );
		// $site_logo_links_to = get_theme_mod( 'daze_logo_link' );
		$site_logo_links_to = get_home_url();

		if ( isset( $site_logo_retina_url ) ) {
			printf( '<div class="site-logo"><a href="%1$s"><img class="panorama-logo retina-logo" src="%2$s"/></a></div>',
				esc_url( $site_logo_links_to ),
				$site_logo_retina_url 
			);
			return;
		}
		if ( isset( $site_logo_url ) ) {
			printf( '<div class="site-logo"><a href="%1$s"><img class="panorama-logo normal-logo" src="%2$s"/></a></div>',
				esc_url( $site_logo_links_to ),
				$site_logo_url 
			);
			return;
		}
		printf( '<div class="site-logo va-middle"><a href="%1$s"><h1>%2$s</h1></a></div>',
			esc_url( $site_logo_links_to ),
			esc_html( get_bloginfo('name') )
		);
	}

	function custom_add_google_fonts() {
		wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i', false );
	}
	add_action( 'wp_enqueue_scripts', 'custom_add_google_fonts' );

	Class My_Categories_Widget extends WP_Widget_Categories {
			function widget( $args, $instance ) {
				static $first_dropdown = true;

				$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Categories' );
		
				/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
				$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
				$c = ! empty( $instance['count'] ) ? '1' : '0';
				$h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
				$d = ! empty( $instance['dropdown'] ) ? '1' : '0';
		
				echo $args['before_widget'];
		
				if ( $title ) {
					echo $args['before_title'] . $title . $args['after_title'];
				}
		
				$cat_args = array(
					'orderby'      => 'name',
					'show_count'   => $c,
					'hierarchical' => $h,
				);
		
				if ( $d ) {
					echo sprintf( '<form action="%s" method="get">', esc_url( home_url() ) );
					$dropdown_id = ( $first_dropdown ) ? 'cat' : "{$this->id_base}-dropdown-{$this->number}";
					$first_dropdown = false;
		
					echo '<label class="screen-reader-text" for="' . esc_attr( $dropdown_id ) . '">' . $title . '</label>';
		
					$cat_args['show_option_none'] = __( 'Select Category' );
					$cat_args['id'] = $dropdown_id;
					$cat_args['class'] = 'cs-select cs-skin-border postform';

					/**
					 * Filters the arguments for the Categories widget drop-down.
					 *
					 * @since 2.8.0
					 * @since 4.9.0 Added the `$instance` parameter.
					 *
					 * @see wp_dropdown_categories()
					 *
					 * @param array $cat_args An array of Categories widget drop-down arguments.
					 * @param array $instance Array of settings for the current widget.
					 */

					wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args, $instance ) );
		
					echo '</form>';
					?>
		
					<script type='text/javascript'>
					/* <![CDATA[ */
					(function() {
						var dropdown = document.getElementById( "<?php echo esc_js( $dropdown_id ); ?>" );
						function onCatChange() {
							if ( dropdown.options[ dropdown.selectedIndex ].value > 0 ) {
								dropdown.parentNode.submit();
							}
						}
						dropdown.onchange = onCatChange;
					})();
					/* ]]> */
					</script>
					
					<?php
							} else {
					?>
							<ul>
					<?php
							$cat_args['title_li'] = '';
					
							/**
							 * Filters the arguments for the Categories widget.
							 *
							 * @since 2.8.0
							 * @since 4.9.0 Added the `$instance` parameter.
							 *
							 * @param array $cat_args An array of Categories widget options.
							 * @param array $instance Array of settings for the current widget.
							 */
							wp_list_categories( apply_filters( 'widget_categories_args', $cat_args, $instance ) );
					?>
							</ul>
					<?php
							}
					
							echo $args['after_widget'];
			}
	}

	function my_categories_widget_register() {
			unregister_widget( 'WP_Widget_Categories' );
			register_widget( 'My_Categories_Widget' );
	}
	add_action( 'widgets_init', 'my_categories_widget_register' );

	add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
	function special_nav_class($classes, $item){
			$classes[] = 'menu__item';
			return $classes;
	}

	function add_menuclass($ulclass) {
		return preg_replace('/<a/', '<a class="menu__link"', $ulclass, -1);
	}
	add_filter('wp_nav_menu','add_menuclass');

	add_filter('nav_menu_css_class' , 'active_nav_class' , 10 , 2);
	function active_nav_class($classes, $item) {
		if (in_array('current-menu-item', $classes) ){
				$classes[] = 'menu__item--current ';
		}
		return $classes;
	}