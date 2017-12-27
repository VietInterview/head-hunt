<?php

/*------------------------------------------------------------*/
/*	Register "Application" Post Type	*/
/*------------------------------------------------------------*/

// Register Custom Post Type
function jobboard_register_application_post_type() {

	$labels = array(
		'name'                => _x( 'Applications', 'Post Type General Name', 'jobboard' ),
		'singular_name'       => _x( 'Application', 'Post Type Singular Name', 'jobboard' ),
		'menu_name'           => __( 'Applications', 'jobboard' ),
		'parent_item_colon'   => __( 'Parent Application:', 'jobboard' ),
		'all_items'           => __( 'All Applications', 'jobboard' ),
		'view_item'           => __( 'View Application', 'jobboard' ),
		'add_new_item'        => __( 'Add New Application', 'jobboard' ),
		'add_new'             => __( 'Add New', 'jobboard' ),
		'edit_item'           => __( 'Edit Application', 'jobboard' ),
		'update_item'         => __( 'Update Application', 'jobboard' ),
		'search_items'        => __( 'Search Application', 'jobboard' ),
		'not_found'           => __( 'Not found', 'jobboard' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'jobboard' ),
	);
	$args = apply_filters( 'jobboard_register_application_post_type_args', array(
		'label'               => __( 'application', 'jobboard' ),
		'description'         => __( 'Application post type', 'jobboard' ),
		'labels'              => apply_filters( 'jobboard_register_application_post_type_labels', $labels ),
		'supports'            => array( 'title', 'author' ),
		'taxonomies'          => array( 'application_status' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => false,
		'menu_position'       => 57.2,
		'menu_icon'           => 'dashicons-clipboard',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	) );
	register_post_type( 'application', $args );
}
add_action( 'init', 'jobboard_register_application_post_type', 0 );


/*------------------------------------------------------------*/
/*	Register "Appplication Status" Taxonomy	*/
/*------------------------------------------------------------*/

// Register Custom Taxonomy
function jobboard_register_application_status() {

	$labels = apply_filters( 'jobboard_register_application_status_labels', array(
		'name'                       => _x( 'Application Statuses', 'Taxonomy General Name', 'jobboard' ),
		'singular_name'              => _x( 'Application Status', 'Taxonomy Singular Name', 'jobboard' ),
		'menu_name'                  => __( 'Application Status', 'jobboard' ),
		'all_items'                  => __( 'All Statuses', 'jobboard' ),
		'parent_item'                => __( 'Parent Status', 'jobboard' ),
		'parent_item_colon'          => __( 'Parent Status:', 'jobboard' ),
		'new_item_name'              => __( 'New Status Name', 'jobboard' ),
		'add_new_item'               => __( 'Add New Status', 'jobboard' ),
		'edit_item'                  => __( 'Edit Status', 'jobboard' ),
		'update_item'                => __( 'Update Status', 'jobboard' ),
		'separate_items_with_commas' => __( 'Separate statuses with commas', 'jobboard' ),
		'search_items'               => __( 'Search Statuses', 'jobboard' ),
		'add_or_remove_items'        => __( 'Add or remove statuses', 'jobboard' ),
		'choose_from_most_used'      => __( 'Choose from the most used statuses', 'jobboard' ),
		'not_found'                  => __( 'Not Found', 'jobboard' ),
	) );
	$args = apply_filters( 'jobboard_register_application_status_args', array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'meta_box_cb'								 => '__return_false',
		'rewrite'										 => array( 'with_front' => false )
	) );
	register_taxonomy( 'application_status', array( 'application' ), $args );
}
add_action( 'init', 'jobboard_register_application_status', 0 );