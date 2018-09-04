<?php

function theme_enqueue_styles() {
	$parent_style = 'daze-style';
	$child_style = array('panorama-custom-style');
	wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css', array());
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', $child_style);

	wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom.js', 'jquery');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
