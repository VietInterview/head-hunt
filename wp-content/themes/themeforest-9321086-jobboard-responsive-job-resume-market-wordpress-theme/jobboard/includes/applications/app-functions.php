<?php
/**
 * Job Board pre-defined functions
 * All functions for Job Application System
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 2.5
 */

/**
 * Add predefined term if not already set.
 */
if ( ! function_exists( 'jobboard_predefined_application_status' ) ) :
function jobboard_predefined_application_status() {

	$is_app_status = get_option( 'jboard_appstatus_terms', false );

	if ( $is_app_status ) {
		return;
	}

	$status = array(
		__( 'Waiting', 'jobboard' ),
		__( 'Under Review', 'jobboard' ),
		__( 'Considering', 'jobboard' ),
		__( 'Accepted', 'jobboard' ),
		__( 'Rejected', 'jobboard' ),
	);

	foreach($status as $stat){
		$term = term_exists($stat, 'application_status');
		if ($term !== 0 && $term !== null) {
			continue;
		}
		wp_insert_term($stat, 'application_status');
	}

	add_option( 'jboard_appstatus_terms', true );
}
add_action( 'init' , 'jobboard_predefined_application_status' );
endif;

/**
 * Remove metabox taxonomy applications_status
 */
if ( ! function_exists( 'jobboard_remove_app_status_metabox' ) ) :
function jobboard_remove_app_status_metabox() {
	remove_meta_box( 'tagsdiv-application_status', 'application', 'side' );
}
add_action( 'admin_menu' , 'jobboard_remove_app_status_metabox' );
endif;

/**
 * Remove other unused metabox on edit post screen application.
 */
if ( !function_exists( 'jobboard_set_custom_edit_application_columns' ) ) :
function jobboard_set_custom_edit_application_columns($columns){

	unset( $columns['author'] );
	unset( $columns['taxonomy-application_status'] );
	unset( $columns['date'] );

	$columns['applicant_name'] = __( 'Applicant Name', 'jobboard' );
	$columns['job'] = __( 'Applied Job', 'jobboard' );
	$columns['application_status'] = __( 'Status', 'jobboard' );
	$columns['action'] = __( 'Action', 'jobboard' );

	if ( isset( $_GET['application_status_id'] ) ) {
		unset($columns['application_status']);
	}

	return $columns;
}
add_filter( 'manage_edit-application_columns', 'jobboard_set_custom_edit_application_columns' );
endif;

/**
 * Set custom admin column on application lists page.
 */
if ( !function_exists( 'jobboard_custom_application_column' ) ) :
function jobboard_custom_application_column( $column, $post_id ){
    switch ( $column ){
    	case 'applicant_name':
    		echo get_the_author_meta( 'display_name', get_post_meta( $post_id, '_jboard_applicant_name', true ) );
    	break;

    	case 'action':
    		$resume_id = get_post_meta( $post_id, '_jboard_applicant_resume', true );
    		echo '<a target="_" href="'.esc_url( get_permalink( $resume_id ) ).'">'.__( 'View Resume', 'jobboard' ).'</a> | <a href="'.esc_url( get_edit_post_link( $post_id ) ).'">'.__( 'Edit', 'jobboard' ).'</a>';
    	break;

    	case 'job':
    		$job_id = get_post_meta( $post_id, '_jboard_applied_job', true );
    		echo '<a target="_blank" href="'.esc_url( get_permalink($job_id) ).'">'.esc_attr( get_the_title($job_id) ).'</a> ';
    	break;

    	case 'application_status':
    		$apps = get_post_meta( $post_id, '_jboard_application_status', true);
    		$terms = get_term_by( 'id', intval($apps), 'application_status' );
    		if($terms){
					if ( !has_term( $terms->slug, 'application_status', intval($post_id) ) ) {
						wp_set_object_terms( $post_id, intval($apps), 'application_status', false );
					}
    			echo esc_attr( $terms->name );
    		}
    	break;
    }
}
add_action( 'manage_application_posts_custom_column' , 'jobboard_custom_application_column', 10, 2 );
endif;

/**
 * Save custom taxonomy application status on post save.
 */
if ( ! function_exists( 'jobboard_save_post_application' ) ) :
function jobboard_save_post_application( $post_id, $post, $update ) {

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	$meta = get_post_meta($post_id, '_jboard_application_status', true);

	if ( empty( $meta ) || $meta == '' ) {
		return;
	}

	wp_set_object_terms( $post_id, intval($meta), 'application_status', false );
}
add_action( 'save_post_application' , 'jobboard_save_post_application', 10, 3 );
endif;

/**
 * Add custom application_status filter.
 */
if ( ! function_exists( 'jobboard_application_column_filter' ) ):
function jobboard_application_column_filter( $post_type ) {
	if($post_type != 'application'){
		return;
	}

	$tax_args = array(
		'show_option_all'		=> __( 'All Application Status', 'jobboard' ),
		'orderby'						=> 'NAME',
		'order'							=> 'ASC',
		'name'							=> 'application_status_id',
		'taxonomy'					=> 'application_status'
	);
	if(isset($_GET['application_status_id'])){
		$tax_args['selected'] = sanitize_text_field($_GET['application_status_id']);
	}
	wp_dropdown_categories($tax_args);
}
add_action( 'restrict_manage_posts', 'jobboard_application_column_filter' );
endif;

/**
 * Add custom application_status filter query.
 */
if ( ! function_exists( 'jobboard_application_column_filter_query' ) ):
function jobboard_application_column_filter_query( $query ) {
	if ( ! is_admin() )
		return;

	global $post_type, $pagenow;

	if($pagenow == 'edit.php' && $post_type == 'application'){
		if ( isset($_GET['application_status_id']) ) {

			//get the desired post format
			$term_id = absint($_GET['application_status_id']);
			//if the post format is not 0 (which means all)
			if ($term_id != 0) {
				$query->query_vars['tax_query'] = array(
					array(
						'taxonomy'  => 'application_status',
						'field'     => 'ID',
						'terms'     => $term_id
					)
				);
			}
		}
	}
}
add_action( 'pre_get_posts', 'jobboard_application_column_filter_query' );
endif;