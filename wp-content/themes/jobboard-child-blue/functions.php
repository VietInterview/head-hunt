<?php

/**
 *  JobBoard child theme setup
 *
 * @since 1.0.0
 */
function jobboard_child_setup(){

	load_child_theme_textdomain( 'jobboard-child', get_stylesheet_directory() . '/langauges' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'secondary' => esc_html__( 'Secondary Menu', 'jobboard-child' ),
	) );

}
add_action( 'after_setup_theme', 'jobboard_child_setup', 15 );

/**
 *  JobBoard Child theme scripts
 *
 * @since 1.0.0
 */
function jobboard_child_scripts(){

	// Check the homepage active or not, then execute the javascript
	if( is_page_template( 'page-templates/template-homepage.php' ) ){

		// jQuery Simple Slider
		wp_enqueue_script( 'simple-slider', get_template_directory_uri().'/assets/js/simple-slider.min.js', array( 'jquery' ), '1.0.0', true  );
		wp_enqueue_script( 'simple-slider-init', get_template_directory_uri().'/assets/js/simple-slider-init.js', array( 'jquery' ), '1.0.0', true  );
		wp_enqueue_style( 'simple-slider', get_template_directory_uri().'/assets/css/simple-slider.css', '1.0', 'all' );
		wp_enqueue_style( 'simple-slider-volume', get_template_directory_uri().'/assets/css/simple-slider-volume.css', '1.0', 'all' );

		// Homepage Image Slider
		$slider_settings = array(
			'auto_play'			=> jobboard_option('slider_auto_slide'),
			'auto_play_timeout'	=> jobboard_option('slider_delay'),
			'animate_in'		=> jobboard_option('slider_entrance_animation'),
			'animate_out'		=> jobboard_option('slider_exit_animation'),
		);
		wp_localize_script( 'theme-js', 'home_slider', $slider_settings );
		wp_localize_script( 'theme-js', 'slider', array( 'init' => false, 'home_init' => true ) );
	}
	wp_enqueue_script( 'jobboard-child', get_stylesheet_directory_uri() . '/js/jobboard-child.js', array(), '1.0.0', true );
	wp_enqueue_script( 'jobboard-child', get_stylesheet_directory_uri() . '/js/jquery.easy-pie-chart.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'jobboard_child_scripts', 99 );

/**
 *  JobBoard Child theme scripts
 *
 * @since 1.0.0
 */
function jobboard_child_remove_page_templates( $page_templates ) {
	unset( $page_templates['page-templates/template-homepage.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'jobboard_child_remove_page_templates' );

/**
 *  JobBoard Child theme scripts
 *
 * @since 1.0.0
 */
function jobboard_child_custom_menu_item( $items, $args ) {
    if ( !jobboard_option('enable_admin_menu') || $args->theme_location != 'primary_menu' ) {
        return $items;
    }
	if ( is_user_logged_in() ) {
		$items .= '<li class="dropdown usermenu">';
		$items .= '<a class="dropdown-toggle usermenu-item" data-toggle="dropdown" role="button" aria-expanded="false" href="#">';
		$items .= get_avatar( get_current_user_id(), 35 ).'<span>'.esc_attr( get_userdata( get_current_user_id() )->display_name ).'</span>';
		$items .= '</a>';
		$items .= '<ul class="dropdown-menu">';
		$items .= '<li><a href="'.jobboard_get_permalink( 'dashboard' ).'">'.__( 'Dashboard', 'jobboard' ).'</a></li>';
		$items .= '<li><a href="'.jobboard_get_permalink( 'profile' ).'">'.__( 'Profile', 'jobboard' ).'</a></li>';
		$items .= '<li><a href="'.jobboard_get_permalink( 'logout' ).'">'.__( 'Log Out', 'jobboard' ).'</a></li>';
		$items .= '</ul>';
	} else {
		$items .= '<li class="dropdown usermenu off">';
		$items .= '<a class="dropdown-toggle usermenu-item" href="'.jobboard_get_permalink( 'login' ).'">'.__( 'LOG IN', 'jobboard' ).'</a>';
	}
	$items .= '</li>';
    return $items;
}
add_filter( 'wp_nav_menu_items', 'jobboard_child_custom_menu_item', 99, 2 );
