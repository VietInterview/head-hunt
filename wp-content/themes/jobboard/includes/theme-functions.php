<?php
/**
 * Job Board pre-defined functions
 * All functions is pluggable
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 */
?><?php


/**
 * Add Package System
 */

require_once( get_template_directory().'/includes/package-system/package.php' );

/**
 * Add Resume Subscription System
 */

require_once( get_template_directory().'/includes/resume-subscription/resume-subscription.php' );

/**
 * Add Resume Application System
 */

require_once( get_template_directory().'/includes/applications/app-init.php' );


if( !function_exists( 'jobboard_seo_url' ) ){
	function jobboard_seo_url($string){
		//Lower case everything
		$string = strtolower($string);
		//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
		//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}
}//endif;

if( !function_exists( 'jobboard_not_found' ) ){
	function jobboard_not_found( $type ){

		$default_type = 'post';

		switch( $type ){

			case 'job_search':
				echo '
					<div class="alert alert-info">
						<strong>'.__( 'Sorry,', 'jobboard' ).'</strong> '.__( 'your search did not match any jobs.', 'jobboard' ).'
					</div>
				';
			break;
		}

	}
}//endif;

/*
 * Redirect non-admin to homepage if loggedin from wp-login.php
 */
function jobboard_login_redirect() {
	global $current_user, $wp_roles;
	return ( current_user_can( 'manage_options' ) ) ? admin_url() : site_url();
}
add_filter( 'login_redirect', 'jobboard_login_redirect' );

/*
 * Backward compatibility with WordPress 4.0 and older
 */
if ( !function_exists( '_wp_render_title_tag' ) ):
    function jobboard_render_title() {
?>
<title><?php wp_title( '-', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'jobboard_render_title', 9 );
endif;


if( !function_exists( 'jobboard_read_more_link' ) ){
	add_filter( 'the_content_more_link', 'jobboard_read_more_link' );
	function jobboard_read_more_link() {
		return '<div class="jobboard-more-link"><a href="' . get_permalink() . '">'.__( 'Read More', 'jobboard' ).' <i class="fa fa-chevron-right"></i></a></div>';
	}
}//endif;

if( !function_exists( 'jobboard_search_form' ) ){
	function jobboard_search_form( $form ) {
		$form = '<form role="search" method="get" id="searchform" class="jobboard-searchform" action="' . home_url( '/' ) . '" >
		<div class="form-group">
			<div class="input-group">
				<div class="input-group-addon">
				<a href="#"><i class="fa fa-search"></i></a>
				</div>
				<input class="form-control" type="text" id="s" name="s" />
				<input type="hidden" id="searchsubmit" value="'. __( 'Search', 'jobboard' ) .'" />
			</div>
		</div>
		</form>';

		return $form;
	}
	add_filter( 'get_search_form', 'jobboard_search_form' );
}//endif;

/*------------------------------------------------------------------*/
/*	Custom comment form callback	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_remove_comment_url_field' ) ){

	function jobboard_remove_comment_url_field($fields){
		unset($fields['url']);
    	return $fields;
	}
	//add_filter( 'comment_form_default_fields', 'jobboard_remove_comment_url_field');
}

/*------------------------------------------------------------------*/
/*	Custom post thumbnail function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_get_the_post_thumbnail' ) ){
	function jobboard_get_the_post_thumbnail( $id, $size ){

		if( has_post_thumbnail() ){
			return get_the_post_thumbnail( $id, $size );
		}

	}
}

/*------------------------------------------------------------------*/
/*	Custom CSS function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_custom_css_box' ) ){

	add_action( 'wp_head', 'jobboard_custom_css_box', 99 );
	function jobboard_custom_css_box(){
		$custom_css = jobboard_option( 'custom_css_box' );
		if ( !empty( $custom_css ) ) {
			echo '<style type="text/css" id="custom_css">';
				echo $custom_css;
			echo '</style>';
		}
	}

}//endif;

/*------------------------------------------------------------------*/
/*	Relative date function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_time_ago' ) ){
	function jobboard_time_ago($from=''){
		$to = current_time( 'timestamp' );

		if ( empty( $from ) )
			$from = get_the_time('U');

		return human_time_diff( $from, $to );
	}
}

/*------------------------------------------------------------------*/
/*	Get Currency Settings from Number	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_price' ) ){
	function jobboard_price( $value = '' ){

		$curr_sign 	= jobboard_option( 'currency_sign' );
		$position  	= jobboard_option( 'currency_position' );
		$dec_point  = jobboard_option( 'decimal_point_numbers' );
		$dec_sep  	= jobboard_option( 'decimal_point_separator' );
		$thou_sep  	= jobboard_option( 'thousands_separator' );

		$number = number_format( floatval($value), intval($dec_point), $dec_sep, $thou_sep );

		if ( $position == 'after_nominal' ) {
			$result = $number.' '.$curr_sign;
		} else {
			$result = $curr_sign.' '.$number;
		}

		return $result;
	}
}

/*------------------------------------------------------------------*/
/*	Get Attachment ID by attachmanet URL	*/
/*------------------------------------------------------------------*/
function jobboard_get_attach_id( $url ) {
	// Split the $url into two parts with the wp-content directory as the separator
	$parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

	// Get the host of the current site and the host of the $url, ignoring www
	$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );

	// Return nothing if there aren't any $url parts or if the current host and $url host do not match
	if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}

	// Now we're going to quickly search the DB for any attachment GUID with a partial path match
	// Example: /uploads/2013/05/test-image.jpg
	global $wpdb;

	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ) );

	// Returns null if no attachment is found
	return $attachment[0];
}
/*------------------------------------------------------------------*/
/*	Form action path url	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_form_action' ) ){
	function jobboard_form_action(){
		return get_template_directory_uri().'/includes/frontend-submission/form-submit.php';
	}
}//endif;

/*------------------------------------------------------------------*/
/*	Comment Walker Class	*/
/*------------------------------------------------------------------*/
class Jobboard_Walker_Comment extends Walker_Comment {

	// init classwide variables
	var $tree_type = 'comment';
	var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

	/** CONSTRUCTOR
	 * You'll have to use this if you plan to get to the top of the comments list, as
	 * start_lvl() only goes as high as 1 deep nested comments */
	function __construct() { ?>
		<ul id="comment-list" class="comment-list">

	<?php }

	/** START_LVL
	 * Starts the list before the CHILD elements are added. Unlike most of the walkers,
	 * the start_lvl function means the start of a nested comment. It applies to the first
	 * new level under the comments that are not replies. Also, it appear that, by default,
	 * WordPress just echos the walk instead of passing it to &$output properly. Go figure.  */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1; ?>

				<ul class="children">
	<?php }

	/** END_LVL
	 * Ends the children list of after the elements are added. */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1; ?>

		</ul><!-- /.children -->

	<?php }

	/** START_EL */

	function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;
		$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); ?>

		<li <?php comment_class( $parent_class ); ?> id="comment-<?php comment_ID() ?>">
			<div id="comment-body-<?php comment_ID() ?>" class="comment-body clearfix">
				<div class="comment-left-side">
					<div class="comment-author vcard author">
						<?php echo ( $args['avatar_size'] != 0 ? get_avatar( $comment, $args['avatar_size'] ) :'' ); ?>
					</div><!-- /.comment-author -->
				</div><!-- /.comment-left-side -->

				<div class="comment-right-side">
					<span class="comment-meta comment-meta-data">
						<cite class="fn n author-name"><?php echo get_comment_author_link( get_comment_ID() ); ?></cite>,
						<a href="<?php echo htmlspecialchars( get_comment_link( get_comment_ID() ) ) ?>"><?php comment_date(); ?> at <?php comment_time(); ?></a>
					</span><!-- /.comment-meta -->
					&nbsp;:&nbsp;
					<span id="comment-content-<?php comment_ID(); ?>" class="comment-content">
						<?php if( !$comment->comment_approved ) : ?>
						<em class="comment-awaiting-moderation">Your comment is awaiting moderation.</em>

						<?php else: echo esc_attr( get_comment_text() ); ?>
						<?php endif; ?>
					</span><!-- /.comment-content -->

					<div class="reply">
					<?php
						$reply_args = array(
							'depth' => $depth,
							'max_depth' => $args['max_depth'],
							'reply_text' => '<i class="fa fa-reply"></i>&nbsp;'.__( 'Reply', 'jobboard' ),
						);

						comment_reply_link( array_merge( $args, $reply_args ) );  ?>
						<?php edit_comment_link( '(Edit)' ); ?>
					</div><!-- /.reply -->
				</div><!-- /.comment-right-side -->
			</div><!-- /.comment-body -->

	<?php }

	function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

		</li><!-- /#comment-' . get_comment_ID() . ' -->

	<?php }

	/** DESTRUCTOR
	 * I just using this since we needed to use the constructor to reach the top
	 * of the comments list, just seems to balance out :) */
	function __destruct() { ?>

	</ul><!-- /#comment-list -->

	<?php }
}

/*------------------------------------------------------------------*/
/*	Function to handle frontend Post Resume	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_post_resume' ) ){

function jobboard_post_resume($data = array(), $files = array(), $update = false ){

	$post_status = 'pending';

	if( jobboard_option( 'auto_publish_resume' ) == '1' || jobboard_option('enable_package_resume') == '1' ){
		$post_status = 'publish';
	}

	$resume_args = array(
		'post_content'		=> $data['resume_content'],
		'post_title'		=> $data['title'],
		'post_status'		=> $post_status,
		'post_type'			=> 'resume',
		'post_author'		=> $data['user_id'],
	);
	$message = '10';
	if($update){
		$resume_args['post_status'] = get_post_status( $_POST['resume_id'] );
		$resume_args['ID'] = $_POST['resume_id'];
		$message = '11';
	}//endif;

	$resume_url = array();
	$i = 0;
	foreach($data['url_address'] as $url){
		if( $url != '' ){
			$resume_url[] = array(
				'url_name' => $data['url_name'][$i],
				'url_address' => $url,
			);
		}
		$i++;
	}

	$resume_education = array();
	$i = 0;
	foreach( $data['education_name'] as $edu ){
		if( $edu != '' ){
			$resume_education[] = array(
				'education_period' => $data['education_period'][$i],
				'institution_name' => $edu,
				'qualification' => $data['education_qualification'][$i],
				'study_field' => $data['education_study'][$i],
				'grade' => $data['education_grade'][$i],
			);
		}
		$i++;
	}

	$resume_experience = array();
	$i = 0;
	foreach( $data['experience_company'] as $exp ){
		if( $exp != '' ){
			$resume_experience[] = array(
				'employment_period' => $data['experience_period'][$i],
				'company_name' => $data['experience_company'][$i],
				'position' => $data['experience_position'][$i],
				'sallary' => $data['experience_sallary'][$i],
				'job_duties' => $data['experience_job'][$i],
			);
		}
		$i++;
	}

	$meta_input = array(
		'resume_professional_title' => $data['job_title'],
		'year_experience' => $data['year_experience'],
		'proposed_monthly_sallary' => $data['proposed_monthly_sallary'],
		'resume_location' => $data['location'],
		'skills_group' => array(
			array(
				'resume_skills' => $data['skills'],
			),
		),
		'url_group_container' => array(
			array(
				'url_group' => $resume_url,
			),
		),
		'education_group_container' => array(
			array(
				'education_group' => $resume_education,
			),
		),
		'experience_group_container' => array(
			array(
				'experience_group' => $resume_experience,
			),
		),
	);


	$resume_id = wp_insert_post( $resume_args );
	if( isset($resume_id) ){
		if( isset($data['category']) ){
			wp_set_object_terms( $resume_id, $data['category'], 'resume_category' );
		}

		$old_post_meta = get_post_meta( $resume_id, 'jobboard_resume_mb', true );
		update_post_meta( $resume_id, 'jobboard_resume_mb', $meta_input, $old_post_meta );


		// Location
		update_post_meta( $resume_id, '_resume_location', $data['location'] );

		// Monthly salary
		update_post_meta( $resume_id, '_resume_monthly_salary', (int)$data['proposed_monthly_sallary'] );

		// Experience
		update_post_meta( $resume_id, '_resume_experience', (int)$data['year_experience'] );


		// Upload  photo file
		if( !empty( $files['photo']['name'] ) ){
			$attach_id = jobboard_file_upload( $files['photo'], 'image', $resume_id );
			if( $attach_id ){
				set_post_thumbnail( $resume_id, $attach_id );
			}
		}

		//mark as removed resume file
		if( $data['resume_file_status'] == '1' ){
			$old_resume_file = get_post_meta( $resume_id, 'jobboard_resume_file', true );
			if( !empty($old_resume_file) ){
				$exfile = parse_url($old_resume_file);
				unlink( substr($exfile['path'], 1) );
				update_post_meta( $resume_id, 'jobboard_resume_file', '', $old_resume_file );
			}
		}

		// Upload resume file
		if( !empty( $files['resume_file']['name'] ) ){
			$resume_file = jobboard_file_upload( $files['resume_file'], 'file' );
			$old_resume_file = get_post_meta( $resume_id, 'jobboard_resume_file', true );
			if($resume_file){
				$exfile = parse_url($old_resume_file);
				unlink( substr($exfile['path'], 1) );
				update_post_meta( $resume_id, 'jobboard_resume_file', $resume_file['url'], $old_resume_file  );
			}
		}

		wp_redirect( add_query_arg( array( 'action' => 'edit', 'jid' => $resume_id, 'message' => $message ) ) );
		exit;

	}//endif $resume_id
}

}//endif;

/*------------------------------------------------------------------*/
/*	Function to handle frontend Post Job	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_post_job' ) ){

	function jobboard_post_job( $data = array(), $update = false ){

		$post_status = 'pending';
		$message = 'pending';
        $jobs_tatus = 'closed';
        $append_terms = true;

		if(jobboard_option('auto_publish_job') == '1' || jobboard_option('enable_package_job') == '1'){
			$post_status ='publish';
			$message = '1';
            $jobs_tatus = 'open';
		}

		$job_args = array(
			'post_content'		=> $data['job_description'],
			'post_title'		=> $data['job_title'],
			'post_status'		=> $post_status,
			'post_type'			=> 'job',
			'post_author'		=> $data['user_id'],
		);

		$job_id = '';
		if( $update ){
			$job_args['ID'] = $data['post_id'];
			$job_args['post_status'] = get_post_status( $data['post_id'] );
			$message = '2';
            $append_terms = false;
			$jobs_tatus = ( isset($data['job_status']) && $job_args['post_status'] == 'publish' )
				? $data['job_status'] : get_post_meta( $data['post_id'], '_jboard_job_status', true );
		}

		$job_id = wp_insert_post( $job_args );

		if($job_id){
			if( isset( $data['job_region'] ) ){
				wp_set_object_terms( $job_id, $data['job_region'], 'job_region', $append_terms );
			}
			if( isset( $data['job_type'] ) ){
				wp_set_object_terms( $job_id, $data['job_type'], 'job_type', $append_terms );
			}
			if( isset( $data['job_category'] ) ){
				wp_set_object_terms( $job_id, $data['job_category'], 'job_category', $append_terms );
			}

			// Job Status Metabox
			update_post_meta( $job_id, '_jboard_job_status', $jobs_tatus );

			// Job Company Metabox
			update_post_meta( $job_id, '_jboard_job_company', $data['job_company'] );

			// Job Experience Metabox
			update_post_meta( $job_id, '_jboard_job_experiences', $data['job_experience'] );

			// Job Salary Metabox
			update_post_meta( $job_id, '_jboard_job_sallary', $data['job_sallary'] );

			// Job Summary Metabox
			update_post_meta( $job_id, '_jboard_job_summary', $data['job_summary'] );

			// Job Overview Metabox
			update_post_meta( $job_id, '_jboard_job_overview', $data['job_overview'] );

			// Job metabox data set
			$job_meta = array(
                '_jboard_job_status',
				'_jboard_job_company',
				'_jboard_job_experiences',
				'_jboard_job_sallary',
				'_jboard_job_summary',
				'_jboard_job_overview',
			);
			update_post_meta( $job_id, 'jobboard_job_mb_fields', $job_meta );

			wp_redirect( add_query_arg( array( 'action' => 'edit', 'jid' => $job_id, 'message' => $message ) ) );
			exit;
		}
	}

}//endif;

/*------------------------------------------------------------------*/
/*	Function to handle frontend Post Company	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_post_company' ) ){

	function jobboard_post_company( $data = array(), $files = array(), $update = false ){

		if ( $update && ( empty( $data['post_id'] ) || false === get_post_status( $data['post_id'] ) ) ) {
			wp_redirect( add_query_arg( 'message', '99' ) );
			exit;
		}

		$message = 'pending';
		$status = 'pending';

		//later use for plugin auto update all company database
		$updated_db = ( get_post_meta( $data['post_id'], '_jboard_company_mb_updated', true ) ) ? true : false;

		if(jobboard_option('auto_publish_company') == '1') {
			$status = 'publish';
			$message = '3';
		}

		$company_args = array(
			'post_type'		=> 'company',
			'post_title'	=> $data['company_name'],
			'author'		=> get_current_user_id(),
		);

		if( $update ){
			$company_args['ID'] = $data['post_id'];
			$company_args['post_status'] = get_post_status( $data['post_id'] );
			$message = '4';
		} else {
            $company_args['post_status'] = $status;
        }

		// Service repeatable meta data
		$company_service = array();
		$i = 0;
		foreach($data['service_name'] as $service_name){
			if( $service_name != '' ){
				$company_service[] = array(
					'service_icon' => $data['service_icon'][$i],
					'service_name' => $service_name,
					'service_detail' => $data['service_detail'][$i]
				);
			}
			$i++;
		}

		// Client repeeatable meta data
		$company_client = array();
		$i = 0;
		foreach($data['project_name'] as $project_name){
			if( $project_name != '' ){
				$company_client[] = array(
					'project_name' => $project_name,
					'project_year' => $data['project_year'][$i],
					'project_url' => $data['project_url'][$i],
					'project_detail' => $data['project_detail'][$i]
				);
			}
			$i++;
		}

		if ( $updated_db ) {
			//plugin update company database
			$company_service_group = array(
				array( 'company_service_group' => $company_service )
			);
		} else {
			$company_service_group = array( '_jboard_company_service_group' => $company_service );
		}

		if ( $updated_db ) {
			//plugin update company database
			$company_client_group = array(
				array( 'company_client_group' => $company_client )
			);
		} else {
			$company_client_group = array( '_jboard_company_client_group' => $company_client );
		}

		$comp_id = wp_insert_post($company_args);

		if($comp_id){

			// Company Description Metabox
			update_post_meta( $comp_id, '_jboard_company_description', $data['company_description'] );

			// Company Overview Metabox
			update_post_meta( $comp_id, '_jboard_company_overview', $data['company_overview'] );

			// Company Website URL
			update_post_meta( $comp_id, '_jboard_company_web_address', $data['company_website'] );

			// Company Facebook URL
			update_post_meta( $comp_id, '_jboard_company_social_facebook', $data['company_facebook'] );

			// Company Twitter URL
			update_post_meta( $comp_id, '_jboard_company_social_twitter', $data['company_twitter'] );

			// Company Google Plus
			update_post_meta( $comp_id, '_jboard_company_social_googleplus', $data['company_google_plus'] );

			// Company Expertises
			update_post_meta( $comp_id, '_jboard_hidden_expertises', $data['company_expertises']);

			if ( !$update ) {
				update_post_meta( $comp_id, 'jobboard_company_mb_fields', array(
					'_jboard_company_description',
					'_jboard_company_overview',
					'_jboard_company_web_address',
					'_jboard_company_social_facebook',
					'_jboard_company_social_twitter',
					'_jboard_company_social_googleplus',
				) );
			}

			// Company Service
			update_post_meta( $comp_id, '_jboard_company_service_headline', $data['company_service_headline'] );
			update_post_meta( $comp_id, '_jboard_company_service_group_container', $company_service_group );
			if ( !$update ) {
				update_post_meta( $comp_id, 'jobboard_company_mb_services_fields',
				array( '_jboard_company_service_headline', '_jboard_company_service_group_container' ) );
			}

			// Company Client
			update_post_meta( $comp_id, '_jboard_company_client_headline', $data['company_client_headline'] );
			update_post_meta( $comp_id, '_jboard_company_client_group_container', $company_client_group );
			if ( !$update ) {
				update_post_meta( $comp_id, 'jobboard_company_mb_clients_fields',
				array( '_jboard_company_client_headline', '_jboard_company_client_group_container' ) );
			}

			// Expertises
			update_post_meta( $comp_id, '_jboard_company_expertises_headline', $data['company_expertises_headline'] );
			$expertise_array = explode(',', $data['company_expertises']);
			update_post_meta($comp_id, '_jboard_company_expertises', $expertise_array);
			if ( !$update ) {
				update_post_meta( $comp_id, 'jobboard_company_mb_expertise_fields', array(
					'_jboard_company_expertises_headline',
					'_jboard_company_expertises'
				) );
			}

			// Testimonial
			update_post_meta($comp_id, '_jboard_company_testimonial_headline', $data['company_testimonial_headline']);
			update_post_meta($comp_id, '_jboard_company_testimonial_content', $data['testimonial_content']);
			update_post_meta($comp_id, '_jboard_company_testimonial_author', $data['testimonial_author']);
			update_post_meta($comp_id, '_jboard_company_testimonial_author_occupation', $data['testimonial_author_occupation']);
			update_post_meta($comp_id, '_jboard_company_testimonial_author_url', $data['testimonial_author_url']);
			if ( !$update ) {
				update_post_meta( $comp_id, 'jobboard_company_mb_testimonial_fields', array(
					'_jboard_company_testimonial_headline',
					'_jboard_company_testimonial_content',
					'_jboard_company_testimonial_author',
					'_jboard_company_testimonial_author_occupation',
					'_jboard_company_testimonial_author_url',
					'_jboard_company_testimonial_author_avatar',
				) );
			}

			// Testimonial author avatar
			// Upload  Company Image
			if( !empty( $files['testimonial_author_avatar']['name'] ) ){
				$attach_id = jobboard_file_upload( $files['testimonial_author_avatar'], 'image', $comp_id );
				if( $attach_id ){
					update_post_meta($comp_id, '_author_avatar_id_hidden', $attach_id);
					$attachment_url = wp_get_attachment_url($attach_id);
					update_post_meta($comp_id, '_jboard_company_testimonial_author_avatar', $attachment_url);
				}
			}

			// Upload  Company Image
			if( !empty( $files['company_image']['name'] ) ){
				$attach_id = jobboard_file_upload( $files['company_image'], 'image', $comp_id );
				if( $attach_id ){
					if( has_post_thumbnail( $comp_id ) ){
						delete_post_thumbnail($comp_id);
					}
					set_post_thumbnail( $comp_id, $attach_id );
				}
			}

			// Portfolio repeatable meta data
			$multiple_images = $_FILES['portfolio_image'];

			$n = 0;
			$single_img_group = array();
			foreach($multiple_images as $key => $val_array) :
				$single_img_group[] = array(
					'name' => $multiple_images['name'][$n],
					'type' => $multiple_images['type'][$n],
					'tmp_name' => $multiple_images['tmp_name'][$n],
					'error' => $multiple_images['error'][$n],
					'size' => $multiple_images['size'][$n]
				);
				$n++;
			endforeach;

			$portfolio_attachments = array();
			foreach($single_img_group as $single_img ) :

				// Push upload here
				if($single_img['name'] != '' || $single_img['name'] != NULL) {
					// Push upload
					$attach_id = jobboard_file_upload( $single_img, 'image', $comp_id );
					$portfolio_attachments[] = $attach_id;
				}

			endforeach;

			// Service repeatable meta data
			$company_portfolio = array();
			$i = 0;
			foreach($portfolio_attachments as $portfolio_attachment){
				if( $portfolio_attachment != '' ){

					$stored_id = ($data['portfolio_stored_image_id'][$i]) ? $data['portfolio_stored_image_id'][$i] : $portfolio_attachment;
					$company_portfolio[] = array(
						'portfolio_stored_image_id' => $portfolio_attachment,
						'portfolio_image' => wp_get_attachment_url($portfolio_attachment),
						'portfolio_url' => $data['portfolio_url2'][$i]
					);
				}
				$i++;
			}

			if ( empty($company_portfolio) && !empty( $data['portfolio_stored_image_id'] ) ) {

				$company_portfolio = array();

				foreach ( $data['portfolio_stored_image_id'] as $key => $img ) {

					$portfolio_url = !empty( $data['portfolio_url2'][ $key ] )
						? $data['portfolio_url2'][ $key ] : '';

					$company_portfolio[ $key ] = array(
						'portfolio_image'			=> wp_get_attachment_url( (int)$img ),
						'portfolio_stored_image_id'	=> (int)$img,
						'portfolio_url'				=> $portfolio_url,
					);
				}
			}

			if ( $updated_db ) {
				//plugin update company database
				$company_portfolio_group = array(
					array( 'company_portfolio_group' => $company_portfolio )
				);
			} else {
				$company_portfolio_group = array( '_jboard_company_portfolio_group' => $company_portfolio );
			}

			// Update portfolio meta
			update_post_meta( $comp_id, '_jboard_company_portfolio_headline', $data['company_portfolio_headline'] );
			update_post_meta( $comp_id, '_jboard_company_portfolio_group_container', $company_portfolio_group );
			if ( !$update ) {
				update_post_meta( $comp_id, 'jobboard_company_mb_portfolio_fields', array(
					'_jboard_company_portfolio_headline',
					'_jboard_company_portfolio_group_container'
				) );
			}

			// stored images
			update_post_meta( $comp_id, '_jboard_company_portfolio_stored_img', $data['portfolio_stored_image_id'] );
			// stored urls
			update_post_meta( $comp_id, '_jboard_company_portfolio_stored_url', $data['portfolio_url2'] );

			// Company address
			update_post_meta( $comp_id, '_jboard_company_address_gmap_latitude', $data['gmap_latitude'] );
			update_post_meta( $comp_id, '_jboard_company_address_gmap_longitude', $data['gmap_longitude'] );
			update_post_meta( $comp_id, '_jboard_company_address', $data['company_address'] );
			update_post_meta( $comp_id, '_jboard_company_phone', $data['company_phone'] );
			update_post_meta( $comp_id, '_jboard_company_email', $data['company_email'] );
			if ( !$update ) {
				update_post_meta( $comp_id, 'jobboard_company_mb_address_fields', array(
					'_jboard_company_address_gmap_latitude',
					'_jboard_company_address_gmap_longitude',
					'_jboard_company_address',
					'_jboard_company_phone',
					'_jboard_company_email'
				) );
				update_post_meta( $comp_id, '_jboard_company_mb_updated', '1' );
			}

			wp_redirect( add_query_arg( array( 'action' => 'edit', 'jid' => $comp_id, 'message' => $message ) ) );
			exit;
		}//endif;
	}

}//endif;

/*------------------------------------------------------------------*/
/*	Create retina-ready images   */
/*------------------------------------------------------------------*/
if( !function_exists( 'retina_support_create_images' ) ){

    function retina_support_create_images( $file, $width, $height, $crop = false ) {
        if ( $width || $height ) {
            $resized_file = wp_get_image_editor( $file );
            if ( ! is_wp_error( $resized_file ) ) {
                $filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x' );

                $resized_file->resize( $width * 2, $height * 2, $crop );
                $resized_file->save( $filename );

                $info = $resized_file->get_size();

                return array(
                    'file' => wp_basename( $filename ),
                    'width' => $info['width'],
                    'height' => $info['height'],
                );
            }
        }
        return false;
    }
}//endif;

/*------------------------------------------------------------------*/
/*	Filter Uploaded File for Retina Images   */
/*------------------------------------------------------------------*/
if( !function_exists( 'retina_support_attachment_meta' ) ){

  add_filter( 'wp_generate_attachment_metadata', 'retina_support_attachment_meta', 10, 2 );

  function retina_support_attachment_meta( $metadata, $attachment_id ) {
      foreach ( $metadata as $key => $value ) {
          if ( is_array( $value ) ) {
              foreach ( $value as $image => $attr ) {
                  if ( is_array( $attr ) && isset( $attr['width'] ) && isset( $attr['height'] ) )
                      retina_support_create_images( get_attached_file( $attachment_id ), $attr['width'], $attr['height'], true );
              }
          }
      }

      return $metadata;
  }

}//endif;

/*------------------------------------------------------------------*/
/*	Delete retina-ready images if Attachment Deleted	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'delete_retina_support_images' ) ){

    add_filter( 'delete_attachment', 'delete_retina_support_images' );

    function delete_retina_support_images( $attachment_id ) {
        $meta = wp_get_attachment_metadata( $attachment_id );
        $upload_dir = wp_upload_dir();
		if( is_array($meta) ) {
          $path = pathinfo( $meta['file'] );
          foreach ( $meta as $key => $value ) {
            if ( 'sizes' === $key ) {
                foreach ( $value as $sizes => $size ) {
                    $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
                    $retina_filename = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
                    if ( file_exists( $retina_filename ) )
                        unlink( $retina_filename );
                }
            }
          }
		}
    }
}//endif;

/*------------------------------------------------------------------*/
/*	Function to handle upload files	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_file_upload' ) ){

	function jobboard_file_upload( $file = array(), $type = 'image', $post_id = null ){

		// Phase 1 : Upload photo to WordPress upload directory
		if ( ! function_exists( 'wp_handle_upload' ) ){
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		$uploadedfile = $file;
		$movefile = wp_handle_upload( $uploadedfile, array( 'test_form' => false ) );

		if ( $movefile ) {

			if( $type == 'file' ){
				return $movefile;
			}elseif( $type == 'image' ){
				// Phase 2 : Insert Photo as attachment post
				$filename =  $movefile['file'];

				// The ID of the post this attachment is for.
				$parent_post_id = $post_id;

				// Check the type of tile. We'll use this as the 'post_mime_type'.
				$filetype = wp_check_filetype( basename( $filename ), null );

				// Get the path to the upload directory.
				$wp_upload_dir = wp_upload_dir();

				// Prepare an array of post data for the attachment.
				$attachment = array(
					'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);

				// Insert the attachment.
				$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

				// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
				require_once( ABSPATH . 'wp-admin/includes/image.php' );

				// Generate the metadata for the attachment, and update the database record.
				$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
				wp_update_attachment_metadata( $attach_id, $attach_data );

				return $attach_id;
			}

		}else{
			return __( 'Upload failed', 'jobboard' );
		}

	}

}//endif;



/*------------------------------------------------------------------*/
/*	Function to handle upload files (multiple images)	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_multiple_file_upload' ) ){

	function jobboard_multiple_file_upload( $file = array(), $type = 'image', $post_id = null ){


		// Phase 1 : Upload photo to WordPress upload directory
		if ( ! function_exists( 'wp_handle_upload' ) ){
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		$uploadedfile = $file;


		$i = 0;
		foreach($uploadedfile as $key => $value){

			// echo '<br /> | <br />';
			// var_dump($_FILES['portfolio_image'][$key]);

			$img_array = array(
				'name' => $uploadedfile['name'][$i],
				'type' => $uploadedfile['type'][$i],
				'size' => $uploadedfile['size'][$i]
			);

			$my_array[] = $img_array;

			$i++;
		}


		// Upload multiple files start
		foreach($my_array as $a){

			// echo ' -- <br />';
			// var_dump($a);
			$movefile = wp_handle_upload( $a, array( 'test_form' => false ) );

			if ( $movefile ) {

				if( $type == 'file' ){
					return $movefile;
				}elseif( $type == 'image' ){
					// Phase 2 : Insert Photo as attachment post
					$filename =  $movefile['file'];

					// The ID of the post this attachment is for.
					$parent_post_id = $post_id;

					// Check the type of tile. We'll use this as the 'post_mime_type'.
					$filetype = wp_check_filetype( basename( $filename ), null );

					// Get the path to the upload directory.
					$wp_upload_dir = wp_upload_dir();

					// Prepare an array of post data for the attachment.
					$attachment = array(
						'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
						'post_mime_type' => $filetype['type'],
						'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
						'post_content'   => '',
						'post_status'    => 'inherit'
					);

					// Insert the attachment.
					$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

					// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
					require_once( ABSPATH . 'wp-admin/includes/image.php' );

					// Generate the metadata for the attachment, and update the database record.
					$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
					wp_update_attachment_metadata( $attach_id, $attach_data );

					return $attach_id;
				}

			}else{
				return __( 'Upload failed', 'jobboard' );
			}




		} // End of upload multiple files


	} // end of function

}//endif;



/*------------------------------------------------------------------*/
/*	Google map init functions	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_create_gmaps' ) ){

	function jobboard_create_gmaps( $object = '', $args = array() ){
		$default_args = array(
			'target'	  => $object,
			'latitude'	=> '',
			'longitude'	=> '',
      'title'     => '',
      'content'   => '',
			'zoom'		  => 12,
			'marker'	  => false,
			'infowindow'=> false
		);
    $args = wp_parse_args( $args, $default_args );

    if ( empty( $args['target'] ) ) {
      return;
    }

		$get_option_google_map_api = jobboard_option( 'google_api_key' );
		$maps_api = 'https://maps.googleapis.com/maps/api/js?key='.$get_option_google_map_api;
		$google_maps_url = apply_filters( 'jobboard_google_maps_url', $maps_api );
		wp_enqueue_script( 'google-maps', esc_url_raw( $google_maps_url ), array(), '3.25', true );
		wp_enqueue_script( 'jobboard-maps', get_template_directory_uri().'/assets/js/map.js', array( 'google-maps' ), '1.0', true );
		wp_localize_script( 'jobboard-maps', 'jobboard_maps', $args );
	}

}//endif;


/*------------------------------------------------------------------*/
/*	Ajax Contact form function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_contact_form' ) ){
	add_action( 'wp_ajax_nopriv_jobboard_send_contact_form', 'jobboard_contact_form' );
	add_action( 'wp_ajax_jobboard_send_contact_form', 'jobboard_contact_form' );

	function jobboard_contact_form(){

		if( isset( $_POST['contact_submit'] ) && md5($_POST['human_answer']) == $_POST['hash_answer'] ){

			$data = array();

			if( isset( $_POST['contact_name'] ) ){
				$data['name'] = trim( $_POST['contact_name'] );
			}
			if( isset( $_POST['contact_email'] ) ){
				$data['email'] = trim( $_POST['contact_email'] );
			}
			if( isset( $_POST['contact_telp'] ) ){
				$data['telp'] = trim( $_POST['contact_telp'] );
			}
			if( isset( $_POST['contact_website'] ) ){
				$data['website'] = trim( $_POST['contact_website'] );
			}
			if( isset( $_POST['contact_subject'] ) ){
				$data['subject'] = trim( $_POST['contact_subject'] );
			}
			if( isset( $_POST['contact_message'] ) ){
				$data['message'] = wp_kses( $_POST['contact_message'], array() );
			}

			$email_to = jobboard_option( 'contact_info_email' );
			$subject = __( 'Contact Form Submission From : ', 'jobboard' ).$data['name'];
			$body = "You have received message from : \n\nName : ".$data['name']." \n\nEmail : ".$data['email']." \n\nTel : ".$data['telp']." \n\nWebsite : ".$data['website']." \n\nSubject : ".$data['subject']." \n\nMessage : \n".$data['message'];
			$headers = 'From: '.get_bloginfo('name').' <'.get_bloginfo('admin_email').'>';

			$sent = wp_mail( $email_to, $subject, $body, $headers );
				if($sent){
					$response = array(
					   'id'=>'1',
					   'message'=>true
					);
					wp_send_json($response);
				}

		}else{
			$response = array(
			   'id'=>'2',
			   'message'=>'not_human'
			);
			wp_send_json($response);
		}//endif;

	}

}//endif;



/* Send message for company contact in single company */
/*------------------------------------------------------------------*/
/*	Ajax Contact form function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_contact_form_company' ) ){
	add_action( 'wp_ajax_nopriv_jobboard_send_contact_form_company', 'jobboard_contact_form_company' );
	add_action( 'wp_ajax_jobboard_send_contact_form_company', 'jobboard_contact_form_company' );

	function jobboard_contact_form_company(){

		if( isset( $_POST['contact_submit'] ) && $_POST['contact_submit'] == '1' ){

			$data = array();

			if( isset( $_POST['contact_name'] ) ){
				$data['name'] = trim( $_POST['contact_name'] );
			}
			if( isset( $_POST['contact_email'] ) ){
				$data['email'] = trim( $_POST['contact_email'] );
			}
			if( isset( $_POST['contact_telp'] ) ){
				$data['telp'] = trim( $_POST['contact_telp'] );
			}
			if( isset( $_POST['contact_website'] ) ){
				$data['website'] = trim( $_POST['contact_website'] );
			}
			if( isset( $_POST['contact_subject'] ) ){
				$data['subject'] = trim( $_POST['contact_subject'] );
			}
			if( isset( $_POST['contact_message'] ) ){
				$data['message'] = wp_kses( $_POST['contact_message'], array() );
			}
			if( isset( $_POST['contact_mailto'] ) ){
				$data['mailto'] = wp_kses( $_POST['contact_mailto'], array() );
			}

			$email_to = $data['mailto'];
			$subject = __( 'Contact Form Submission From : ', 'jobboard' ).$data['name'];
			$body = "You have received message from : \n\nName : ".$data['name']." \n\nEmail : ".$data['email']." \n\nMessage : \n".$data['message'];
			$headers = 'From: '.get_bloginfo('name').' <'.get_bloginfo('admin_email').'>';

			$sent = wp_mail( $email_to, $subject, $body, $headers );
			if($sent){
				$response = array(
					'what'=>'status',
					'action'=>'contact_email',
					'id'=>'1',
					'data'=>true
				);
				$xmlResponse = new WP_Ajax_Response($response);
				$xmlResponse->send();
			}else{
				echo 'fail';
			}

		}//endif;

	}

}


/*------------------------------------------------------------------*/
/*	Ajax delete post item function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_delete_post_item' ) ){

	add_action( 'wp_ajax_nopriv_jobboard_delete_post_item', 'jobboard_delete_post_item' );
	add_action( 'wp_ajax_jobboard_delete_post_item', 'jobboard_delete_post_item' );

	function jobboard_delete_post_item(){

		$post_id = $_POST['post_id'];
		if( $post_id != '' ){
			wp_delete_post($post_id);
			$response = array(
			   'what'=>'foobar',
			   'action'=>'update_something',
			   'id'=>'1',
			   'data'=>$post_id
			);
			$xmlResponse = new WP_Ajax_Response($response);
			$xmlResponse->send();
		}
	}

}//endif;

/*------------------------------------------------------------------*/
/*	Ajax Featured post item function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_featured_post_item' ) ){

	add_action( 'wp_ajax_nopriv_jobboard_add_featured_post', 'jobboard_featured_post_item' );
	add_action( 'wp_ajax_jobboard_add_featured_post', 'jobboard_featured_post_item' );

	function jobboard_featured_post_item(){

		$post_id = $_POST['post_id'];
		if( $post_id != '' ){

			$old_post_meta = get_post_meta( $post_id, '_jboard_job_featured', true );
			update_post_meta( $post_id, '_jboard_job_featured', '1', $old_post_meta );

		}//endif;

	}

}//endif;

/*------------------------------------------------------------------*/
/*	Add Extra Field on user page function	*/
/*------------------------------------------------------------------*/

if( !function_exists( 'jobboard_add_user_extra_field' ) ){
	$user_id = get_current_user_id();
	if ( current_user_can( 'edit_users', $user_id ) ){
		add_action( 'show_user_profile', 'jobboard_add_user_extra_field' );
		add_action( 'edit_user_profile', 'jobboard_add_user_extra_field' );
	}

	function jobboard_add_user_extra_field( $user ){

		if ( !current_user_can( 'edit_users', $user->ID ) ){
			return;
		}

		if( !current_user_can( 'edit_theme_options' ) ){
			$disabled = 'disabled="disabled"';
		}else{
			$disabled = '';
		}

		$old_value = get_user_meta( $user->ID, 'jobboard_user_role', true );

	?>
	<h3><?php _e('Job Board Extra Profile Information', 'jobboard'); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="jobboard_user_role"><?php _e( 'User Role', 'jobboard' ); ?></label></th>
			<td>
				<select name="jobboard_user_role" id="jobboard_user_role" <?php echo $disabled; ?> >
					<option value=""<?php if( $old_value == '' ){ echo 'selected="selected"'; } ?>><?php _e( '-- Select Role --', 'jobboard' ); ?></option>
					<option value="job_lister" <?php if( $old_value == 'job_lister' ){ echo 'selected="selected"'; } ?>><?php _e( 'Job Lister', 'jobboard' ); ?></option>
					<option value="job_seeker" <?php if( $old_value == 'job_seeker' ){ echo 'selected="selected"'; } ?>><?php _e( 'Job Seeker', 'jobboard' ); ?></option>
				</select>
			</td>
		</tr>
		<!-- Available Job Packages -->
		<?php
		$job_packages = jobboard_get_packages_obj( '_package_job' );
		$selected_job_packages = get_user_meta( $user->ID, 'jobboard_user_package_job', true );
		if( $job_packages && jobboard_option('enable_package_job') == '1' ) : ?>
	  	<tr class="tr-user-role job-lister">
			<th><label for="jobboard_user_package_job"><?php _e( 'Job Package for Job Lister', 'jobboard' ); ?></label></th>
			<td>
				<select name="jobboard_user_package_job" id="jobboard_user_package_job" <?php echo $disabled; ?>>
				<option value="" <?php if( $selected_job_packages == '' ){ echo 'selected="selected"'; } ?>><?php echo __('None', 'jobboard'); ?></option>
				  <?php

					foreach($job_packages as $post):
						setup_postdata($post); ?>
					<option value="<?php echo $post->ID; ?>" <?php if( $selected_job_packages == $post->ID ){ echo 'selected="selected"'; } ?>>
						<?php echo $post->post_title; ?></option>
					<?php
				  endforeach; ?>
				</select>
			</td>
		</tr>
		<?php
		$remain_entries = jobboard_get_remaining_entry($user->ID,'_package_job');
		$limit_entries = get_user_meta($user->ID, 'jobboard_user_package_job_max_entry', true);
		?>
		<tr class="tr-user-role job-lister">
			<th><label for="add-credit"><?php _e( 'Job Post Remaining', 'jobboard' ); ?></label></th>
			<td>
				<p style="color:<?php echo ( $remain_entries >= 0 ) ? 'green' : 'red'; ?>">
					<strong id="job_remain"><?php echo $remain_entries ?></strong> <?php _e('Job to Publish','jobboard') ?>
					&nbsp;&nbsp;<button type="button" class="button button-secondary" id="add_credit"><?php _e('Add Credit','jobboard') ?></button>
					&nbsp;<button type="button" class="button button-secondary" id="cancel_credit" style="display:none"><?php _e('Cancel','jobboard') ?></button>
				</p>
				<input type="hidden" name="jobboard_user_package_job_max_entry" id="job_credit" value="<?php echo $limit_entries ?>">
			</td>
		</tr>
		<?php endif; ?>
		<!-- Available Job Packages End -->

	  <!-- Available Resume Subscription -->
		<?php

		$resume_subscription_packages = jobboard_get_packages_obj( '_resume_subscription' );
		$selected_resume_subscription_packages = get_user_meta( $user->ID, 'jobboard_user_resume_subscription', true );

		if ( jobboard_package_is_enabled('_package_resume_view') ): ?>
		<tr  class="tr-user-role job-lister">
			<th><label for="jobboard_user_resume_subscription"><?php _e( 'Resume Subscription for Job Lister', 'jobboard' ); ?></label></th>
			<td>

				<select name="jobboard_user_resume_subscription" id="jobboard_user_resume_subscription" <?php echo $disabled; ?>>
					<option value="" <?php if( $selected_resume_subscription_packages == '' ){ echo 'selected="selected"'; } ?>><?php echo __('None', 'jobboard'); ?></option>
					  <?php
						foreach($resume_subscription_packages as $post):
							setup_postdata($post);
						?>
						<option value="<?php echo $post->ID; ?>" <?php if( $selected_resume_subscription_packages == $post->ID ){ echo 'selected="selected"'; } ?>><?php echo $post->post_title; ?></option>
						<?php
					  endforeach;
					  ?>
				</select>
			</td>

		</tr>
		<?php endif; ?>
		<!-- Available Resume Subscription Ends -->

		<!-- Available Resume Package -->
		<?php
			$resume_packages = jobboard_get_packages_obj( '_package_resume' );

			if( $resume_packages && jobboard_option('enable_package_resume') == '1' ) :

			$selected_resume_packages = get_user_meta( $user->ID, 'jobboard_user_package_resume', true ); ?>

		<tr class="tr-user-role job-seeker">
			<th><label for="jobboard_user_package_resume"><?php _e( 'Resume Package for Job Seeker', 'jobboard' ); ?></label></th>
			<td>
				<select name="jobboard_user_package_resume" id="jobboard_user_package_resume" <?php echo $disabled; ?>>
					<option value="" <?php if( $selected_resume_packages == '' ){ echo 'selected="selected"'; } ?>><?php echo __('None', 'jobboard'); ?></option>
				  <?php
					foreach($resume_packages as $post):
						setup_postdata($post);
					?>
					<option value="<?php echo $post->ID; ?>" <?php if( $selected_resume_packages == $post->ID ){ echo 'selected="selected"'; } ?>><?php echo $post->post_title; ?></option>
					<?php
				  endforeach;
					?>
				</select>
			</td>
		</tr>
		<?php endif; ?>

		<!-- Available Resume Package Ends -->
	</table>
<script>
jQuery(document).ready(function($){

	var i_remains = parseInt( $('#job_remain').clone().text() ),
		i_limits  = parseInt( $('#job_credit').clone().val() );

	function changeUserRolesRow(role) {
		var lister = $('.job-lister'),seeker = $('.job-seeker');
		$('.tr-user-role').hide();
		if( role !== '' && role !== false && role !== undefined ){
			if( role == 'job_lister' )
				lister.slideDown();

			if( role == 'job_seeker' )
				seeker.slideDown();
		} else {
			$('.tr-user-role').slideDown();
		}
	}

	$('#jobboard_user_role').on('change', function(){
		changeUserRolesRow( this.value );
	});
	$('#jobboard_user_role').trigger('change');

	$('#add_credit').on('click', function(){

		var remains   = parseInt( $('#job_remain').text() ),
			limits	  = parseInt( $('#job_credit').val() );

		$('#job_remain').text( remains + 1 );
		$('#job_credit').val( limits + 1 );

		if( limits != i_limits ) {
			$('#cancel_credit').show();
		} else {
			$('#cancel_credit').hide();
		}

		if( remains > 0 )
			$(this).closest('p').css('color','green');

		if( remains < 0 )
			$(this).closest('p').css('color','red');

		console.log( '[remains : '+remains+', i_remains : '+i_remains+']' );
		console.log( '[limits : '+limits+', i_limits : '+i_limits+']' );
	});

	$('#cancel_credit').on('click', function(){
		$('#job_remain').text( i_remains );
		$('#job_credit').val( i_limits );
		if( i_remains < 0 )
			$(this).closest('p').css('color','red');
		$(this).hide();
	});
});
</script>
	<?php
	}
}

/*------------------------------------------------------------------*/
/*	Save Extra Field on user page function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_save_user_extra_field' ) ){

	add_action( 'personal_options_update', 'jobboard_save_user_extra_field' );
	add_action( 'edit_user_profile_update', 'jobboard_save_user_extra_field' );

	function jobboard_save_user_extra_field( $user_id ) {

		if ( !current_user_can( 'edit_users', $user_id ) ){
		    return;
		}

        update_user_meta( $user_id, 'jobboard_user_role', $_POST['jobboard_user_role'] );

        $job_packages = jobboard_get_packages_obj( '_package_job' );
        $resume_packages = jobboard_get_packages_obj( '_package_resume' );
        $resume_subscription_packages = jobboard_get_packages_obj( '_resume_subscription' );

        if( $job_packages && jobboard_option('enable_package_job') == '1' ){

            $active_pack = jobboard_get_user_active_package_data($user_id, '_package_job');
            $max_entry = $_POST['jobboard_user_package_job_max_entry'];
            $pack_id = $_POST['jobboard_user_package_job'];
            $meta_key = '_jboard_package_job_limit';
            $limit = get_post_meta($pack_id, $meta_key, true);

            update_user_meta( $user_id, 'jobboard_user_package_job', $_POST['jobboard_user_package_job'] );

            if( $active_pack == $pack_id && $max_entry != $limit ){
                update_user_meta( $user_id, 'jobboard_user_package_job_max_entry', $max_entry );
            } else {
                update_user_meta( $user_id, 'jobboard_user_package_job_max_entry', $limit );
            }
        }
        if( $resume_packages && jobboard_option('enable_package_resume') == '1' ){

            $active_pack = jobboard_get_user_active_package_data($user_id, '_package_resume');
            $pack_id = $_POST['jobboard_user_package_resume'];
            $meta_key = '_jboard_package_resume_limit';
            $limit = get_post_meta($pack_id, $meta_key, true);

            update_user_meta( $user_id, 'jobboard_user_package_resume', $_POST['jobboard_user_package_resume'] );
            update_user_meta( $user_id, 'jobboard_user_package_resume_max_entry', $limit );

        }
        if( $resume_subscription_packages && jobboard_package_is_enabled('_package_resume_view') == '1' ){

            $active_pack = jobboard_get_user_active_package_data($user_id, '_resume_subscription');
            $pack_id = $_POST['jobboard_user_resume_subscription'];
            $meta_key = '_jboard_resume_subscription_limit';
            $meta_key_unlimited = '_jboard_resume_subscription_is_unlimited';

            $view_unlimited = get_post_meta($pack_id, $meta_key_unlimited, true);

            $view_limit = get_post_meta($pack_id, $meta_key, true);

            $prev_limit = get_user_meta( $user_id, 'jobboard_user_resume_subscription_max_entry', true );

            // if($prev_limit != '' && $prev_limit != 'unlimited' ){

            if($prev_limit != '' && $prev_limit != 'unlimited' ){
                $limit = $prev_limit+$view_limit;
            } else {
                $limit = $view_limit;
            }

            /*
            $cpt = 'resume';
            $count_key = 'single_visit_'.$cpt.'_'.$user_id;
            update_user_meta($user_id, $count_key, '0');
            */

            if( $pack_id == '') {
                $cpt = 'resume';
                $count_key = 'single_visit_'.$cpt.'_'.$user_id;
                update_user_meta($user_id, $count_key, '0');
                delete_user_meta( $user_id, 'jobboard_user_resume_subscription' );
                delete_user_meta( $user_id, 'jobboard_user_resume_subscription_max_entry' );

            } else {

                update_user_meta( $user_id, 'jobboard_user_resume_subscription', $_POST['jobboard_user_resume_subscription'] );
                // Check if unlimited
                if( '1' == $view_unlimited ){
                    update_user_meta( $user_id, 'jobboard_user_resume_subscription_max_entry', 'unlimited' );
                } else {
                    update_user_meta( $user_id, 'jobboard_user_resume_subscription_max_entry', $limit );
                }

            }

            /*
            if( $pack_id != '') {

                update_user_meta( $user_id, 'jobboard_user_resume_subscription', $_POST['jobboard_user_resume_subscription'] );

                if( $view_unlimited == '1' ){
                    update_user_meta( $user_id, 'jobboard_user_resume_subscription_max_entry', 'unlimited' );
                } else {
                    update_user_meta( $user_id, 'jobboard_user_resume_subscription_max_entry', $limit );
                }

            } else {


                // $cpt = 'resume';
                // $count_key = 'single_visit_'.$cpt.'_'.$user_id;
                // update_user_meta($user_id, $count_key, '0');

                delete_user_meta( $user_id, 'jobboard_user_resume_subscription' );

            } // End of $pack_id check
            */


        } // End of $resume_subscription_packages check

	}
}//endif;

/*------------------------------------------------------------------*/
/*	Add CSS role for Custom Styling	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobbboard_custom_style' ) ){

	add_action( 'wp_head', 'jobboard_custom_style', 90 );

	function jobboard_custom_style(){

		echo '<style type="text/css" id="application-status-color">';

		// Aplication Status Color
		$options = array();
		$terms = get_terms( 'application_status',  array( 'hide_empty' => false ) );
		foreach( $terms as $term ){

			echo '
				.application-status_'.$term->slug.'_'.$term->term_id.'{
					background-color:'.jobboard_option( 'application_status_'.$term->slug.'_'.$term->term_id ).';
				}

			';

		}//endforeach;

		echo '</style>';
	}

}//endif;

/*------------------------------------------------------------------*/
/*	Jobboard Get Permalink Function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_get_permalink' ) ){

	function jobboard_get_permalink( $key ){

		$return = '';
		switch( $key ){

			case 'login':
				$return = add_query_arg( 'redirect', urlencode( esc_url( get_permalink() ) ), esc_url( get_permalink( jobboard_option( 'login_page' ) ) ) );
				break;

			case 'logout':
				$return = add_query_arg( 'action', 'logout', esc_url( get_permalink( jobboard_option( 'login_page' ) ) ) );
				break;

			case 'register':
				$return = esc_url( get_permalink( jobboard_option( 'register_page' ) ) );
				break;

			case 'dashboard':
				$return = esc_url( get_permalink( jobboard_option( 'dashboard_page' ) ) );
				break;

			case 'profile':
				// $return = get_edit_user_link(get_current_user_id());
				$return = esc_url( get_permalink( jobboard_option('account_settings_page')) );
				break;

			case 'post_job':
				$return = esc_url( get_permalink( jobboard_option( 'post_job_page' ) ) );
				break;

			case 'post_resume':
				$return = esc_url( get_permalink( jobboard_option( 'post_resume_page' ) ) );
				break;

			case 'post_company':
				$return = esc_url( get_permalink( jobboard_option( 'post_company_page' ) ) );
				break;

			case 'job_search':
				$return = esc_url( get_permalink( jobboard_option( 'search_result_page' ) ) );
				break;

			case 'resume_search':
				$return = esc_url( get_permalink( jobboard_option( 'search_resume_page' ) ) );
				break;

		}//endswicth;

		return $return;

	}

}//endif;

/*------------------------------------------------------------------*/
/*	Jobboard Forbidden Page Function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_404' ) ){
	function jobboard_404() {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		get_template_part( 404 );
		exit();
	}
}

/*------------------------------------------------------------------*/
/*	Jobboard Forbidden Page Function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_forbidden' ) ){

	function jobboard_forbidden( $arg ){

		switch( $arg ){

			case 'login':

			?>
				<div class="forbidden-container">
					<div class="container">
					<?php
						echo __( 'You need to be', 'jobboard' ).' <a href="'.jobboard_get_permalink( 'login' ).'">'.__( 'signed in', 'jobboard' ).'</a> '.__( 'to view this page.', 'jobboard' );
					?>
					</div><!-- /.container -->
				</div><!-- /.forbidden-container -->
			<?php

				break;

		}//endswicth;

	}
}//endif;

/*------------------------------------------------------------------*/
/*	Jobboard Get Social Media Lists	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_get_social_media_items' ) ){

	function jobboard_get_social_media_items(){
		return array(
			'facebook'		=> __( 'Facebook', 'jobboard' ),
			'twitter'		=> __( 'Twitter', 'jobboard' ),
			'google-plus'	=> __( 'Google Plus', 'jobboard' ),
			'youtube'		=> __( 'YouTube', 'jobboard' ),
			'linkedin'		=> __( 'LinkedIn', 'jobboard' ),
			'rss'			=> __( 'RSS', 'jobboard' ),
			'flickr'		=> __( 'Flickr', 'jobboard' ),
			'vimeo'			=> __( 'Vimeo', 'jobboard' ),
			'dribbble'		=> __( 'Dribbble', 'jobboard' ),
			'tumbrl'		=> __( 'Tumblr', 'jobboard' ),
		);
	}

}//endif;

/*------------------------------------------------------------------*/
/*	Function to handle status message	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_set_post_message' ) ){

	function jobboard_set_post_message( $code = false ){

		if($code){

			//echo $code;

			switch($code){

				case 'pending':
					echo '<div class="alert alert-success alert-dismissable" role="alert">';
					echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">'.__( 'Close', 'jobboard' ).'</span></button>';
					_e( 'Item has been submitted and will be visible after admin approval.', 'jobboard' );
					echo '</div>';
					break;

				case '1':
					echo '<div class="alert alert-success alert-dismissable" role="alert">';
					echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">'.__( 'Close', 'jobboard' ).'</span></button>';
					_e( 'Job Published.', 'jobboard' );
					echo '<a href="'.esc_url( get_permalink( $_GET['jid'] ) ).'" target="_blank">'.__( 'View Job', 'jobboard' ).'</a>';
					echo '</div>';
					break;

				case '2':
					echo '<div class="alert alert-success alert-dismissable" role="alert">';
					echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">'.__( 'Close', 'jobboard' ).'</span></button>';
					_e( 'Job Updated.', 'jobboard' );
					echo '<a href="'.esc_url( get_permalink( $_GET['jid'] ) ).'" target="_blank">'.__( 'View Job', 'jobboard' ).'</a>';
					echo '</div>';
					break;

				case '3':
					echo '<div class="alert alert-success alert-dismissable" role="alert">';
					echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">'.__( 'Close', 'jobboard' ).'</span></button>';
					_e( 'Company Added.', 'jobboard' );
					echo '<a href="'.esc_url( get_permalink( $_GET['jid'] ) ).'" target="_blank">'.__( 'View Company', 'jobboard' ).'</a>';
					echo '</div>';
					break;

				case '4':
					echo '<div class="alert alert-success alert-dismissable" role="alert">';
					echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">'.__( 'Close', 'jobboard' ).'</span></button>';
					_e( 'Company Updated. ', 'jobboard' );
					echo '<a href="'.esc_url( get_permalink( $_GET['jid'] ) ).'" target="_blank">'.__( 'View Company', 'jobboard' ).'</a>';
					echo '</div>';
					break;

				case '6':
					echo '<div class="alert alert-danger" role="alert">';
					echo '<strong>'.__( 'Attention!', 'jobboard' ).' </strong>'.__( 'You have to add at least one company in order to post a job. Click', 'jobboard' ).' <a href="'.esc_url( jobboard_get_permalink('post_company') ).'">'.__( 'here', 'jobboard' ).'</a> '.__( 'to add your company first.', 'jobboard' );
					echo '</div>';
					break;

				case '10':
					echo '<div class="alert alert-success alert-dismissable" role="alert">';
					echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">'.__( 'Close', 'jobboard' ).'</span></button>';
					_e( 'Resume created successfully. Your resume will be visible once approved.', 'jobboard' );
					// echo '<a href="'.esc_url( get_permalink( $_GET['jid'] ) ).'" target="_blank"> '.__( 'Preview Resume', 'jobboard' ).'</a>';
					echo '</div>';
					break;
				case '11':
					echo '<div class="alert alert-success alert-dismissable" role="alert">';
					echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">'.__( 'Close', 'jobboard' ).'</span></button>';
					_e( 'Resume Updated.', 'jobboard' );
					echo '<a href="'.esc_url( get_permalink( $_GET['jid'] ) ).'" target="_blank"> '.__( 'View Resume', 'jobboard' ).'</a>';
					echo '</div>';
					break;
				case '12':
					echo '<div class="alert alert-success alert-dismissable" role="alert">';
					_e( 'Your new password saved. Please log in ', 'jobboard' );
					echo '<a href="'.esc_url( jobboard_get_permalink('login')).'">'.__( 'here', 'jobboard' ).'</a>.';
					echo '</div>';
					break;
				case '13':
					echo '<div id="login-success-box" class="alert alert-success alert-dismissable" role="alert">';
					_e( 'Your account created successfully. Log in ', 'jobboard' );
					echo '<a href="'.esc_url( jobboard_get_permalink('login')).'">'.__( 'here', 'jobboard' ).'</a>.';
					echo '</div>';
					break;
				case '14':
					echo '<div class="alert alert-success alert-dismissable" role="alert">';
					echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">'.__( 'Close', 'jobboard' ).'</span></button>';
					_e( 'Your resume published.', 'jobboard' );
					// echo '<a href="'.esc_url( get_permalink( $_GET['jid'] ) ).'" target="_blank"> '.__( 'Preview Resume', 'jobboard' ).'</a>';
					echo '</div>';
					break;
				case '15':
					echo '<div id="login-error-box" class="alert alert-danger"><div id="login_error">';
					_e( 'Registration disabled by Admin!', 'jobboard' );
					echo '</div></div>';
					break;
				case '16':
					echo '<div id="login-error-box" class="alert alert-danger"><div id="login_error">';
					_e( 'Human Check: Your answer incorrect!', 'jobboard' );
					echo '</div></div>';
					break;
			}

		}//endif;
	}
}//endif;


/*------------------------------------------------------------------*/
/*	Function to handle Apply Job button	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_apply_job_button' ) ){

	function jobboard_apply_job_button( $id ){

		$apply_arg = array(
			'post_type'		=> 'application',
			'meta_query'	=> array(
				'relation'	=> 'AND',
				array(
					'key'	=> '_jboard_applied_job',
					'value'	=> $id,
				),
				array(
					'key'	=> '_jboard_applicant_name',
					'value'	=> get_current_user_id(),
				),
			),
		);

		$disable = '';
		$btn_text = __( 'Apply', 'jobboard' );

		$posts = new WP_Query( $apply_arg );
		if( $posts->have_posts() ){
			$disable = 'disabled';
			$btn_text = __( 'Applied', 'jobboard' );
		}

		if( get_post_meta($id, '_jboard_job_status', true) != 'closed'  ){
	?>
		<button class="btn btn-apply-job <?php echo $disable; ?>" type="submit" value="1" data-toggle="modal" data-target="#apply-job-modal"><?php echo esc_attr($btn_text); ?></button>
	<?php
		}
	}

}//endif;

if( !function_exists( 'jobboard_ajax_apply_job' ) ){

	add_action( 'wp_ajax_nopriv_jobboard_apply_job', 'jobboard_ajax_apply_job' );
	add_action( 'wp_ajax_jobboard_apply_job', 'jobboard_ajax_apply_job' );

	function jobboard_ajax_apply_job(){

		$job_id = $_POST['job_id'];
		$applicant = get_current_user_id();

		$app_args = array(
			'post_type' 	=> 'application',
			'author'			=> get_current_user_id(),
			'post_status'	=> 'publish',
			'post_title'	=> get_userdata( $applicant )->display_name.' - '.get_the_title( $job_id ),
		);

		$app_id = wp_insert_post( $app_args );
		$job_author = get_post($job_id)->post_author;

		$email = array(
			'to'	=> get_the_author_meta( 'user_email', $job_author),
			'from'	=> get_the_author_meta( 'user_email', $applicant ),
			'name'	=> get_the_author_meta( 'display_name', $applicant ),
		);

		$to = $email['to'];
		$subject = __( 'You\'ve got a new message from', 'jobboard' ).' : '.$email['name'];
		$header = 'From: '.get_bloginfo('name').' <'.get_bloginfo('admin_email').'>';
		$message = $email['name']." has applied for your job opening. Click ".get_permalink($_POST['job_resume'])." to view the resume.";

		wp_mail( $to, $subject, $message, $header );

		if($app_id){

			$term = get_term_by( 'name', 'Waiting', 'application_status' );

			update_post_meta( $app_id, '_jboard_applied_job', $job_id );
			update_post_meta( $app_id, '_jboard_applicant_resume', $_POST['job_resume'] );
			update_post_meta( $app_id, '_jboard_applicant_name', get_current_user_id() );

			if ( !is_wp_error($term) && isset($term->term_id) ) {
				update_post_meta( $app_id, '_jboard_application_status', $term->term_id );
			} else {
				update_post_meta( $app_id, '_jboard_application_status', '' );
			}

			$meta_args = array(
				'_jboard_applicant_name',
				'_jboard_applicant_resume',
				'_jboard_applied_job',
				'_jboard_application_status',
			);
			update_post_meta( $app_id, 'jobboard_application_mb_fields', $meta_args );

			wp_redirect( add_query_arg( 'message', '10', esc_url( get_permalink($job_id) ) ) );
			exit;
		}//endif;

	}
}//endif;


/*------------------------------------------------------------------*/
/*	Function to handle Contact Form Job Seeker	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_contact_form_job_seeker' ) ){

	add_action( 'wp_ajax_nopriv_jobboard_send_contact_job_seeker', 'jobboard_contact_form_job_seeker' );
	add_action( 'wp_ajax_jobboard_send_contact_job_seeker', 'jobboard_contact_form_job_seeker' );

	function jobboard_contact_form_job_seeker() {

		$email = array(
			'to'		=> $_POST['job_seeker_email'],
			'from'		=> $_POST['contact_email_hide'],
			'name'		=> $_POST['contact_name_hide'],
			'message'	=> $_POST['contact_message'],
		);

		$to			= $email['to'];
		$subject	= __( 'You\'ve got a new message from', 'jobboard' ) . ' : ' . $email['name'];
		$headers	= 'From: ' . $email[ 'name' ] . ' <' . $email[ 'from' ] . '>';
		$message	= $email['message'];

		wp_mail( $to, $subject, $message, $headers );

	}

}//endif;

/*------------------------------------------------------------------*/
/*	Ajax Bookmark Function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_bookmark_resume' ) ){

	add_action( 'wp_ajax_nopriv_jobboard_bookmark_the_resume', 'jobboard_bookmark_resume' );
	add_action( 'wp_ajax_jobboard_bookmark_the_resume', 'jobboard_bookmark_resume' );
	function jobboard_bookmark_resume(){

		$resume_id = $_POST['resume_id'];
		$user_id = $_POST['user_id'];

		// Get the recent bookmarkers ID
		$old_bookmark = get_post_meta( $resume_id, 'jobboard_resume_bookmarker' );

        $bookmark_array = $old_bookmark;

        // Check if current user not bookmarked this resume yet
        if( !in_array( $user_id, $bookmark_array ) ){

            add_post_meta( $resume_id, 'jobboard_resume_bookmarker', $user_id );
            $action = 'add';
            
        } else {
            
            delete_post_meta( $resume_id, 'jobboard_resume_bookmarker', $user_id );
            $action = 'delete';

        }//endif;
        
        $response = array(
           'what'=>'foobar',
           'action'=>'update_something',
           'id'=>'1',
           'data'=>$action
        );
        $xmlResponse = new WP_Ajax_Response($response);
        $xmlResponse->send();

	}
}//endif;

/*------------------------------------------------------------------*/
/*	Ajax delete Bookmark Function	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_resume_unbookmark_item' ) ){

	add_action( 'wp_ajax_nopriv_jobboard_resume_unbookmark_item', 'jobboard_resume_unbookmark_item' );
	add_action( 'wp_ajax_jobboard_resume_unbookmark_item', 'jobboard_resume_unbookmark_item' );

	function jobboard_resume_unbookmark_item(){

		$resume_id = $_POST['resume_id'];
		$user_id = $_POST['user_id'];
        
        $the_bookmark = get_post_meta( $resume_id, 'jobboard_resume_bookmarker' );
        
		// Explode data into array
		if( !empty( $the_bookmark ) ){
			$bookmark_in = $the_bookmark;

			// Check if current user not bookmarked this resume yet
			if( in_array( $user_id, $bookmark_in ) ){

				delete_post_meta( $resume_id, 'jobboard_resume_bookmarker', $user_id );
                
                $response = array(
                   'what'=>'foobar',
                   'action'=>'update_something',
                   'id'=>'1',
                   'data'=>$resume_id
                );
                $xmlResponse = new WP_Ajax_Response($response);
                $xmlResponse->send();

			}//endif;
            
		}//endif;
	}

}//endif;

/*------------------------------------------------------------------*/
/*	Ajax Change Application Status	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_ajax_application_status' ) ){

	add_action( 'wp_ajax_nopriv_jobboard_change_application_status', 'jobboard_ajax_application_status' );
	add_action( 'wp_ajax_jobboard_change_application_status', 'jobboard_ajax_application_status' );
	function jobboard_ajax_application_status(){

		$app_id = $_POST['app_id'];
		$app_status = $_POST['application_status'];
		$old_app_id = get_post_meta( $app_id, '_jboard_application_status', true );
		if($app_id){
			update_post_meta( $app_id, '_jboard_application_status', $app_status, $old_app_id );
			wp_set_object_terms( $app_id, intval($app_status), 'application_status', false );
		}//endif;

	}

}//endif;


/*------------------------------------------------------------------*/
/*	Paypal Payment Integration Mode	*/
/*------------------------------------------------------------------*/
if( !function_exists( 'jobboard_insert_payment' ) ){
	add_action( 'init', 'jobboard_insert_payment' );
	function jobboard_insert_payment(){

        $success = false;

        // Featured payment starts
        if ( (isset( $_GET['action'] ) && $_GET['action'] == 'payment_success') && (isset($_GET['do']) && $_GET['do'] == 'feature_listing' ) ) {

          if ($_POST) {
            $postdata = $_POST;
            //var_dump($postdata);
            $item_number = $postdata['item_number'];
            $amount = $postdata['mc_gross'];
            $payment_status = strtolower( $postdata['payment_status'] );

            //verify payment
            $verified = true; //jobboard_validate_ipn();

            $custom = json_decode( stripcslashes( $postdata['custom'] ) );

            $post_id = $item_number;
            if ( $verified ) {
                $data = array(
                    //'user_id' => (int) $custom->user_id,
                    'status' => 'completed',
                    'cost' => $postdata['mc_gross'],
                    'post_id' => $post_id,
                    //'pack_id' => $pack_id,
                    'payer_first_name' => $postdata['first_name'],
                    'payer_last_name' => $postdata['last_name'],
                    'payer_email' => $postdata['payer_email'],
                    'payment_type' => 'Paypal',
                    'payer_address' => $postdata['residence_country'],
                    'transaction_id' => $postdata['txn_id'],
                    'created' => current_time( 'mysql' )
                );

                add_post_meta( $data['post_id'], 'jobboard_job_payment_status_featured', $data['status'] );
                update_post_meta( $data['post_id'], '_jboard_job_featured', '1' );
                $success = true;
            }//if $verified
          }
        }

        // Listings payment starts
        if ( (isset( $_GET['action'] ) && $_GET['action'] == 'payment_success') && ( isset($_GET['do']) && $_GET['do'] == 'publish_listing' ) ) {

          if ($_POST) {
            $postdata = $_POST;
            // var_dump($postdata);
            $item_number = $postdata['item_number'];
            $amount = $postdata['mc_gross'];
            $payment_status = strtolower( $postdata['payment_status'] );

            //verify payment
            $verified = true; //jobboard_validate_ipn();

            $custom = json_decode( stripcslashes( $postdata['custom'] ) );

            $post_id = $item_number;
            if ( $verified ) {
                $data = array(
                    //'user_id' => (int) $custom->user_id,
                    'status' => 'completed',
                    'cost' => $postdata['mc_gross'],
                    'post_id' => $post_id,
                    //'pack_id' => $pack_id,
                    'payer_first_name' => $postdata['first_name'],
                    'payer_last_name' => $postdata['last_name'],
                    'payer_email' => $postdata['payer_email'],
                    'payment_type' => 'Paypal',
                    'payer_address' => $postdata['residence_country'],
                    'transaction_id' => $postdata['txn_id'],
                    'created' => current_time( 'mysql' )
                );

                add_post_meta( $data['post_id'], 'jobboard_job_payment_status', $data['status'] );
                $success = true;
            }//if $verified
          }
        }

        // Package payment starts
        if ( (isset( $_GET['action'] ) && $_GET['action'] == 'payment_success') && ( isset($_GET['do']) && $_GET['do'] == 'update_package' ) ) {

          if ($_POST) {
            $postdata = $_POST;
              //var_dump($postdata);
            $item_number = $postdata['item_number'];
            $amount = $postdata['mc_gross'];
            $payment_status = strtolower( $postdata['payment_status'] );
            $custom = $postdata['custom'];

            $custom_array = explode( ',', $custom );
            $cpt_slug = $custom_array[0];
            $entry_limit = $custom_array[1];

            //verify payment
            $verified = true; //jobboard_validate_ipn()

            if ( $verified ) {
                $data = array(
                    //'user_id' => (int) $custom->user_id,
                    'status' => 'completed',
                    'cost' => $postdata['mc_gross'],
                    'post_id' => $item_number,
                    //'pack_id' => $pack_id,
                    'payer_first_name' => $postdata['first_name'],
                    'payer_last_name' => $postdata['last_name'],
                    'payer_email' => $postdata['payer_email'],
                    'payment_type' => 'Paypal',
                    'payer_address' => $postdata['residence_country'],
                    'transaction_id' => $postdata['txn_id'],
                    'created' => current_time( 'mysql' )
                );

                $limit = $entry_limit;

                $prev_limit = get_user_meta( get_current_user_id(), 'jobboard_user'.$cpt_slug.'_max_entry', true );
                if( $prev_limit != '' && $prev_limit != 'unlimited' ){
                    $limit = $prev_limit+$entry_limit;
                }
                update_user_meta( get_current_user_id(), 'jobboard_user'.$cpt_slug, $item_number );

                if( $limit == 'unlimited' ){
                    update_user_meta( get_current_user_id(), 'jobboard_user'.$cpt_slug.'_max_entry', 'unlimited' );
                } else {
                    update_user_meta( get_current_user_id(), 'jobboard_user'.$cpt_slug.'_max_entry', $limit );
                }
                $success = true;
            } //if $verified
          }
        }
        // Package payment ends
        if ( $success )
           exit( wp_redirect( jobboard_get_permalink('dashboard') ) );
    }
}//endif;

if( !function_exists( 'jobboard_validate_ipn' ) ){
    function jobboard_validate_ipn() {

        $log_file = get_template_directory()."/includes/package-system/paypal_ipn.log";

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        $paypal_url = jobboard_get_payment_mode();
        $ch = curl_init($paypal_url);
        if ($ch == FALSE)
            return FALSE;

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        if(WP_DEBUG == true) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }
        // Set TCP timeout to 30 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        $res = curl_exec($ch);
        if (curl_errno($ch) != 0) // cURL error
            {
            if(WP_DEBUG == true) {
                error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, $log_file);
            }
            curl_close($ch);
            exit;
        } else {
                // Log the entire HTTP response if debug is switched on.
                if(WP_DEBUG == true) {
                    error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, $log_file);
                    error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, $log_file);
                }
                curl_close($ch);
        }
        // Inspect IPN validation result and act accordingly
        // Split response headers and payload, a better way for strcmp
        $tokens = explode("\r\n\r\n", trim($res));
        $res = trim(end($tokens));

        if (strcmp ($res, "VERIFIED") == 0) {
            if(WP_DEBUG == true) {
                error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, $log_file);
            }
            return true;
        } else if (strcmp ($res, "INVALID") == 0) {
            if(WP_DEBUG == true) {
                error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, $log_file);
            }
            return false;
        }
    }
}

if( !function_exists( 'jobboard_get_payment_mode' ) ){
	function jobboard_get_payment_mode(){
		$sanboxmode = jobboard_option( 'payment_sandbox_mode' )?jobboard_option( 'payment_sandbox_mode' ):'';
		if( $sanboxmode == '1' ){
			$action = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}else{
			$action = 'https://www.paypal.com/cgi-bin/webscr';
		}
		return $action;
	}
}

if( !function_exists( 'jobboard_add_extra_social_links' ) ){
	function jobboard_add_extra_social_links( $contactmethods ) {
		// Add Twitter
		if ( !isset( $contactmethods['twitter'] ) ){
			$contactmethods['twitter'] = __( 'Twitter', 'jobboard' );
		}

		// Add Facebook
		if ( !isset( $contactmethods['facebook'] ) ){
			$contactmethods['facebook'] = __( 'Facebook', 'jobboard' );
		}

		// Add Linked In
		if ( !isset( $contactmethods['linkedin'] ) ){
			$contactmethods['linkedin'] = __( 'Linked In', 'jobboard' );
		}

		return $contactmethods;
	}
	add_filter( 'user_contactmethods', 'jobboard_add_extra_social_links', 10, 1 );
}

if( !function_exists( 'jobboard_add_users_column_table' ) ){
	function jobboard_add_users_column_table( $columns ) {
		  $new = array();
			foreach($columns as $key => $title) {
					if ( $key == 'posts' )
							$new['job_role'] = __( 'Job Role', 'jobboard' );
					$new[$key] = $title;
			}
			return $new;
	}
	add_filter( 'manage_users_columns', 'jobboard_add_users_column_table', 99 );
}

if( !function_exists( 'jobboard_modify_user_table_row' ) ){
	function jobboard_modify_user_table_row( $val, $column_name, $user_id ) {
			$user = get_userdata( $user_id );
			switch ($column_name) {
					case 'job_role' :
							$job_role = get_user_meta( $user_id, 'jobboard_user_role', true );
							if ( $job_role == 'job_seeker' ) {
								$jrole = __( 'Job Seeker', 'jobboard' );
							} elseif ( $job_role == 'job_lister' ) {
								$jrole = __( 'Job Lister', 'jobboard' );
							} else {
								$jrole = '--';
							}
							return $jrole;
							break;
					default:
			}
	}
	add_filter( 'manage_users_custom_column', 'jobboard_modify_user_table_row', 10, 3 );
}

if( !function_exists( 'jobboard_admin_column_width' ) ){
	function jobboard_admin_column_width() {
			echo '<style type="text/css">';
			echo 'th#job_role { width:10%; }';
			echo '</style>';
	}
	add_action( 'admin_head', 'jobboard_admin_column_width' );
}

// Allow redirection, even if my theme starts to send output to the browser
add_action('init', 'do_output_buffer');
function do_output_buffer() {
	ob_start();
}

/*------------------------------------------------------------------*/
/*	User Profile	*/
/*------------------------------------------------------------------*/

function jobboard_get_user_data( $userid = '' ) {

	global $wp;

	if( $userid != '') {
		$user = get_userdata( $userid );
	} else {
		$user = wp_get_current_user();
	}

	$userData = array();

	$userData['id'] = $user->ID;
	$userData['username'] = $user->user_login;
	$userData['firstName'] = $user->user_firstname;
	$userData['$lastName'] = $user->user_lastname;
	$userData['$nickName'] = $user->user_nicename;
	$userData['displayName'] = $user->display_name;
	$userData['email'] = $user->user_email;
	$userData['website'] = $user->user_url;
	$userData['twitter'] = $user->twitter;
	$userData['facebook'] = $user->facebook;
	$userData['linkedin'] = $user->linkedin;
	$userData['bio'] = $user->description;
	$userData['pass'] = $user->user_pass;

	return $userData;

}



/**
 * Get Current Post Type
 */

function get_current_post_type() {
	global $post, $typenow, $current_screen;
	//we have a post so we can just get the post type from that
	if ( $post && $post->post_type ) {
		return $post->post_type;
	}
	//check the global $typenow - set in admin.php
	elseif( $typenow ) {
		return $typenow;
	}
	//check the global $current_screen object - set in sceen.php
	elseif( $current_screen && $current_screen->post_type ){
		return $current_screen->post_type;
	}
	//lastly check the post_type querystring
	elseif( isset( $_REQUEST['post_type'] ) ){
		return sanitize_key( $_REQUEST['post_type'] );
	}
	//we do not know the post type!
	return null;
}



/**
 * Company CPT: admin metaxobox
 */


function jboard_company_expertises_meta_lists(){


	if (isset($_GET['action']) && $_GET['action'] == 'edit') {

		$comp_id = (isset($_GET['post'])) ? $_GET['post'] : '';

		$expertise = get_post_meta( $comp_id,'_jboard_hidden_expertises', true);

		$expertise_array = explode(',', $expertise);

		// $needle = apply_filters('heifilter', array('Val 10', 'Val 11', 'Val 12') );

		$needle = $expertise_array;

		foreach($needle as $val){

			$a[] = array(
				'value' => $val,
				'label' => $val
			);

		}

		if($expertise_array[0] != ""){
			return $a;
		}

	}

}


function jboard_company_expertises_meta_lists_selected(){

	if (isset($_GET['action']) && $_GET['action'] == 'edit') {

		$comp_id = (isset($_GET['post'])) ? $_GET['post'] : '';

		$expertise = get_post_meta( $comp_id,'_jboard_hidden_expertises', true);

		$expertise_array = explode(',', $expertise);

		// if($expertise_array[0] != ""){
			return $expertise_array;
		// }

	}

}


// Get attachment ID by URL

function jboard_get_image_id_by_url($attachment_url = '') {

	global $wpdb;
	$attachment_id = false;

	// If there is no url, return.
	if ( '' == $attachment_url )
	return;

	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}

	return $attachment_id;

}



/**
 * Custom query var
 */

function jobboard_query_vars_filter( $vars ){
	$vars[] = "resume_salary";
	return $vars;
}
add_filter( 'query_vars', 'jobboard_query_vars_filter' );



/**
 * Get single slider value from jb_slider cpt.
 */

if( !function_exists( 'jobboard_get_slider' ) ){
	function jobboard_get_slider($slider_id){

		return vp_metabox('jobboard_image_slider_mb.slider_group', null, $slider_id);

	}
}



/**
 * Get attachment ID from attachment URL
 */
if( !function_exists( 'jobboard_get_attachment_id_from_url' ) ){
	function jobboard_get_attachment_id_from_url( $image_url ) {

		global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
    return $attachment[0];

	}
}


/**
 * Jobboard Retrieve Password
 */

function jobboard_retrieve_password_message( $message, $key ) {

		if ( empty( $_POST['user_login'] ) ) {
			$errors->add( 'empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.', 'jobboard' ));
		} else if ( strpos( $_POST['user_login'], '@' ) ) {
			$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
			if ( empty( $user_data ) )
				$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: There is no user registered with that email address.', 'jobboard' ));
		} else {
			$login = trim($_POST['user_login']);
			$user_data = get_user_by('login', $login);
		}

		// Redefining user_login ensures we return the right case in the email.
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;

	  $login_url =  esc_url( jobboard_get_permalink( 'login' ) );

		$jb_message = __('Someone requested that the password be reset for the following account:', 'jobboard') . "\r\n\r\n";
		$jb_message .= network_home_url( '/' ) . "\r\n\r\n";
		$jb_message .= sprintf(__('Username: %s', 'jobboard'), $user_login) . "\r\n\r\n";
		$jb_message .= __('If this was a mistake, just ignore this email and nothing will happen.', 'jobboard') . "\r\n\r\n";
		$jb_message .= __('To reset your password, visit the following address:', 'jobboard') . "\r\n\r\n";
		$jb_message .= $login_url .'=false&action=rp&key='.$key.'&login='.rawurlencode($user_login);

		return $jb_message;

}
add_filter( 'retrieve_password_message', 'jobboard_retrieve_password_message', 10, 2 );



/**
 * Get user type
 */

function jobboard_get_user_type($user_id){


	$user_type = get_user_meta($user_id, 'jobboard_user_role', true);

	return $user_type;

}



/**
 * ===========================================================
 * Restrict resume details view for only subscribed job lister
 * ===========================================================
 *
 */

/**
 * Define user meta to specify whether an user able to view resume or no
 */

function jobboard_user_meta_job_lister(){

	if( jobboard_get_user_type(get_current_user_id()) == 'job_lister' ){

		add_user_meta($user_id, 'job_lister_able_to_view_resume_details', 'yes' );

	}

}

/**
 * Define resume subscription type
 */

function jobboard_user_resume_subscription_type(){

	if( jobboard_get_user_type(get_current_user_id()) == 'job_lister' ){

		$resume_subscription_type_id = '';

		add_user_meta($user_id, 'job_lister_type_of_resume_subscription', $resume_subscription_type_id );

	}

}

/**
 * Return any location within resume post meta
 *
 * @return array()
 */
function jobboard_get_resume_location(){

	global $post;
	$transient = 'resume_location';
	$location = array();
	$timeout = 14400;

	if( false === $location = get_transient( $transient ) ) :


		$loop = new WP_Query( 'post_type=resume' );
		while ( $loop->have_posts() ) : $loop->the_post();
		    $this_location = vp_metabox('jobboard_resume_mb.resume_location');
	        if ( ! in_array( $this_location, $location ) ) {
	        	//$location_id = preg_replace('/[^A-Za-z0-9\-]/', '', $this_location );
	        	$location_id = strtolower( $this_location );
	            $location[] = array(
	            	'value'	=> $location_id,
	            	'label'	=> $this_location
	            );
	        }
		endwhile;

	if ( $location ) {
		set_transient( $transient, $location, $timeout );
	}

	endif;

	return $location;

}

add_action( 'new_to_publish_resume', 'jobboard_delete_resume_transient' );
add_action( 'save_post_resume', 'jobboard_delete_resume_transient' );
/**
 * Delete transient if there are new published resume
 */
function jobboard_delete_resume_transient() {
    delete_transient( 'resume_location' );
}

/**
 * This function will pull all registered revslider
 *
 * @return array()
 * @since  2.1.0
 */
function jobboard_get_revslider(){

	$get_revslider = array();

	if ( class_exists( 'RevSlider' ) ) {
		$slider = new RevSlider();
		$revsliders = $slider->getArrSliders();

		foreach ( $revsliders as $revslider ) {
			$get_revslider[] = array(
            	'value'	=> $revslider->getAlias(),
            	'label'	=> $revslider->getTitle(),
			);
		}


	} else {
		$get_revslider[] = array(
        	'value'	=> 'no-slider',
        	'label'	=> __( 'No registered slider', 'jobboard' )
		);
	}

	return $get_revslider;

}

if ( is_admin() ) {
	/**
	 * Remove revslider metabox in jb_slider post-type
	 */
	function jobboard_remove_revslider_meta_boxes() {
		remove_meta_box( 'mymetabox_revslider_0', 'page', 'normal' );
		remove_meta_box( 'mymetabox_revslider_0', 'post', 'normal' );
		remove_meta_box( 'mymetabox_revslider_0', 'jb_slider', 'normal' );
	}

	add_action( 'do_meta_boxes', 'jobboard_remove_revslider_meta_boxes' );


	//Add all registered user to author list
	function jobboard_add_users_to_dropdown( $query_args, $r ) {
		$query_args['who'] = '';
		return $query_args;
	}
	add_filter( 'wp_dropdown_users_args', 'jobboard_add_users_to_dropdown', 10, 2 );
}


/*------------------------------------------------------------------*/
/*	Simple Math Question for Form Human Verification	*/
/*------------------------------------------------------------------*/

if ( !class_exists('MathQuestion') ) {

	class MathQuestion {

		private $mathOperators = array('-', '+');
		private $answerHash = '';
		private $operator = '';
		private $integerOne = 0;
		private $integerTwo = 0;

		public function __construct() {
			$this->integerOne = rand(1, 9);
			$this->integerTwo = rand(1, 9);
			$this->operator = $this->mathOperators[rand(0, 1)];
			$this->calculateAnswer();
		}

		public function calculateAnswer() {
			if($this->operator == '-') {
				$this->answerHash = md5($this->integerOne - $this->integerTwo);
			} else {
				$this->answerHash = md5($this->integerOne + $this->integerTwo);
			}
		}

		public function getQuestion() {
			return $this->integerOne.' '.$this->operator.' '.$this->integerTwo;
		}

		public function getAnswerHash() {
			return $this->answerHash;
		}
	}//endCLass

}//endif;
