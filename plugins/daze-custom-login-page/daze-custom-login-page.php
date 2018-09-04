<?php /*
Plugin Name:    Daze Custom Login Page
Description:    Custom login page for wp-admin
Version:		2.0
Author:         NordWood Themes
Author URI:		http://nordwoodthemes.com/
Text Domain:	daze-custom-login-page
*/
	if ( ! function_exists( 'daze_admin_fonts_url' ) ) :
		function daze_admin_fonts_url() {
			$fonts_url = '';
			
		/*
			Translators: If there are characters in your language that are not
			supported by Raleway, translate this to 'off'. Do not translate
			into your own language.
		*/			
			$raleway = esc_attr_x( 'on', 'Raleway font: on or off', 'daze-custom-login-page' );
 
			if ( 'off' !== $raleway ) {
				$fonts_url = add_query_arg( 'family', rawurlencode( 'Raleway:400,500,600,700&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
			}
			
			return esc_url_raw( $fonts_url );
		}
	endif;

	if ( ! function_exists( 'daze_login_page' ) ) :
		function daze_login_page() {
			wp_enqueue_style( 'daze_login_page', plugins_url( '/css/login.css' , __FILE__ ) );			
			wp_enqueue_style( 'daze-admin-fonts', daze_admin_fonts_url(), array(), null );
			
			wp_register_script(
				'daze_login_page',
				plugins_url( '/js/login.js' , __FILE__ ),
				array('jquery'),
				'',
				true
			);
			
			$bgr = get_theme_mod( 'daze_admin_login_bgr', 'image' );
			$bgr_img = get_theme_mod( 'daze_admin_login_bgr_img', plugins_url( '/img/nordwood/login-page-bgr.jpg' , __FILE__ ) );
			$bgr_color = get_theme_mod( 'daze_admin_login_bgr_color', '#e6e7ec' );
			$text_color = get_theme_mod( 'daze_admin_login_txt_color', '#373c47' );
			
			$fields_bgr_color = get_theme_mod( 'daze_admin_login_fields_bgr', '#fff' );
			$fields_bgr_opacity = get_theme_mod( 'daze_admin_login_fields_opacity', 100 );			
			$fields_bgr = daze_hex2rgba( $fields_bgr_color, 0.01*$fields_bgr_opacity );
			
			$show_nw_logo = true === get_theme_mod( 'daze_admin_login_nw_logo', true ) ? 1 : 0;
			$nw_logo = plugin_dir_url( __FILE__ ) . 'img/nordwood/nordwood.png';
						
			$args = array(
				'bgr' 					=> esc_attr( $bgr ),
				'bgr_img' 				=> esc_url( $bgr_img ),
				'bgr_color' 			=> esc_attr( $bgr_color ),
				'text_color' 			=> esc_attr( $text_color ),
				'fields_bgr' 			=> esc_attr( $fields_bgr ),
				'fields_solid_color'	=> esc_attr( $fields_bgr_color ),
				'title_before' 			=> esc_html__( 'Welcome to', 'daze-custom-login-page' ),
				'title_after' 			=> esc_html__( 'login page', 'daze-custom-login-page' ),
				'show_nw_logo' 			=> esc_attr( $show_nw_logo ),
				'nw_logo' 				=> esc_url_raw( $nw_logo )
			);
			wp_localize_script( 'daze_login_page', 'args', $args );
			wp_enqueue_script( 'daze_login_page' );
		}
	endif;
	
	add_action( 'login_enqueue_scripts', 'daze_login_page' );
		
	function daze_admin_logo_url() {
		return esc_url( "http://nordwoodthemes.com/" );
	}
	
	add_filter( 'login_headerurl', 'daze_admin_logo_url' );

	function daze_admin_logo_url_title() {
		return esc_attr__( 'Daze Theme, by NordWood Themes', 'daze-custom-login-page' );
	}
	
	add_filter( 'login_headertitle', 'daze_admin_logo_url_title' );
	
/*	Customizer
================ */  
	if ( !function_exists( 'daze_admin_customizer' ) ) : 
		function daze_admin_customizer( $wp_customize ) {
		// Daze custom login page
			$wp_customize->add_section( 'daze_admin_login', array(
				'title'    => esc_html__( 'Daze custom login page', 'daze-custom-login-page' ),
				'priority' => 20
			));
	
		// Login page background
			$wp_customize->add_setting(	'daze_admin_login_bgr', array(
				'default'			=> 'image',
				'capability'     	=> 'edit_theme_options',
				'type'           	=> 'theme_mod',
				'sanitize_callback' => 'daze_sanitize_choices'
			));
			
			$wp_customize->add_control( 'daze_admin_login_bgr', array(
				'label'      => esc_html__( 'Background', 'daze-custom-login-page' ),
				'section'    => 'daze_admin_login',
				'settings'   => 'daze_admin_login_bgr',
				'type'       => 'radio',
				'choices'    => array(
									'image'		=> esc_html__( 'Image', 'daze-custom-login-page' ),
									'pattern'	=> esc_html__( 'Pattern', 'daze-custom-login-page' ),
									'color'		=> esc_html__( 'Solid color', 'daze-custom-login-page' )
								)
			));
	
		// Background image
			$wp_customize->add_setting( 'daze_admin_login_bgr_img', array(
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw',
				'type'           	=> 'theme_mod'
			));
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'daze_admin_login_bgr_img', array(
				'label'				=> esc_html__( 'Background image', 'daze-custom-login-page' ),
				'section'			=> 'daze_admin_login',
				'settings'			=> 'daze_admin_login_bgr_img',
				'active_callback'	=> 'daze_is_admin_login_bgr_image'
			)));
	
		// Login page background color
			$wp_customize->add_setting( 'daze_admin_login_bgr_color', array(
				'default'           => '#e6e7ec',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'type'				=> 'theme_mod'
			));
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'daze_admin_login_bgr_color', array(
				'label'				=> esc_html__( 'Background color', 'daze-custom-login-page' ),
				'section'  			=> 'daze_admin_login',
				'settings' 			=> 'daze_admin_login_bgr_color',
				'active_callback'	=> 'daze_is_admin_login_bgr_color'
			)));
	
		// Text color
			$wp_customize->add_setting( 'daze_admin_login_txt_color', array(
				'default'           => '#373c47',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'type'				=> 'theme_mod'
			));
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'daze_admin_login_txt_color', array(
				'label'		=> esc_html__( 'Text color', 'daze-custom-login-page' ),
				'section'  	=> 'daze_admin_login',
				'settings' 	=> 'daze_admin_login_txt_color'
			)));
	
		// Fields background color
			$wp_customize->add_setting( 'daze_admin_login_fields_bgr', array(
				'default'           => '#fff',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'type'				=> 'theme_mod'
			));
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'daze_admin_login_fields_bgr', array(
				'label'		=> esc_html__( 'Fields background', 'daze-custom-login-page' ),
				'section'  	=> 'daze_admin_login',
				'settings' 	=> 'daze_admin_login_fields_bgr'
			)));
	
		// Fields background opacity
			$wp_customize->add_setting( 'daze_admin_login_fields_opacity', array(
				'capability'     	=> 'edit_theme_options',
				'type'           	=> 'theme_mod',
				'default'           => esc_attr__( '100', 'daze-custom-login-page' ),
				'sanitize_callback' => 'absint'
			));
			
			$wp_customize->add_control( 'daze_admin_login_fields_opacity', array(
				'label'      	=> esc_html__( 'Fields background opacity (%)', 'daze-custom-login-page' ),
				'section'    	=> 'daze_admin_login',
				'settings'   	=> 'daze_admin_login_fields_opacity',
				'type'       	=> 'number'
			));
	
		// Social profiles in top bar
			$wp_customize->add_setting( 'daze_admin_login_nw_logo', array(
				'default'			=> true,
				'capability'		=> 'edit_theme_options',
				'type'				=> 'theme_mod',
				'sanitize_callback' => 'daze_sanitize_checkbox',
			));
			
			$wp_customize->add_control( 'daze_admin_login_nw_logo', array(
				'label'      => esc_html__( 'Show NordWood logo', 'daze-custom-login-page' ),
				'section'    => 'daze_admin_login',
				'settings'   => 'daze_admin_login_nw_logo',
				'type'       => 'checkbox'
			));
		}
		
	endif;
	
	add_action( 'customize_register', 'daze_admin_customizer' );
	
/*	Customizer callbacks
========================== */ 
// Check the background type
	if ( ! function_exists( 'daze_admin_login_bgr' ) ) :
		function daze_admin_login_bgr( $control ) {
			$bgr_type = $control->manager->get_setting( 'daze_admin_login_bgr' )->value();
			
			return $bgr_type;
		}
	endif;
	
// Background is an image
	if ( ! function_exists( 'daze_is_admin_login_bgr_image' ) ) :
		function daze_is_admin_login_bgr_image( $control ) {			
			if ( 'image' === daze_admin_login_bgr( $control ) || 'pattern' === daze_admin_login_bgr( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Background is an image
	if ( ! function_exists( 'daze_is_admin_login_bgr_color' ) ) :
		function daze_is_admin_login_bgr_color( $control ) {			
			if ( 'color' === daze_admin_login_bgr( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
?>