<?php

/**
 * Theme functions.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

/**
 * Theme dependencies.
 */
add_action( 'after_setup_theme', 'load_theme_dependencies' );
function load_theme_dependencies(){
	// Register theme menus.
	register_nav_menus(
		[
			'header_menu'	=> esc_html__( 'Header Menu', 'bydlokod' ),
			'footer_menu'	=> esc_html__( 'Footer Menu', 'bydlokod' )
		]
	);

	// Please place all custom functions declarations in this file.
	require_once( 'theme-functions/theme-functions.php' );
	require_once( 'theme-functions/ajax.php' );
	// CarbonFields settings file.
	require_once( 'carbon-fields/settings.php' );
}

/**
 * Theme initalization.
 */
add_action( 'init', 'init_theme' );
function init_theme(){
	// Remove extra styles and default SVG tags.
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

	load_theme_textdomain( 'bydlokod', get_stylesheet_directory() . '/languages' );

	// Enable post thumbnails.
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes.
	// add_image_size( 'full-hd', 1920, 0, 1 );
}

add_action( 'wp_enqueue_scripts', 'inclusion_enqueue' );
/**
 * Enqueue styles and scripts.
 */
function inclusion_enqueue(){
	// Remove Gutenberg styles on front-end.
	if( ! is_admin() ){
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'wc-blocks-style' );
	}

	// Random value to prevent caching.
	// Change to some value on production, for example: '1.0.0'.
	$ver_num = mt_rand();

	// Styles.
	wp_enqueue_style( 'main', get_template_directory_uri() . '/static/css/main.min.css', [], $ver_num, 'all' );

	// Scripts.
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/static/js/main.min.js', [], $ver_num, true );
}

