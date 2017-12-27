<?php

/**
 * Template Name: Homepage 2
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 *
 */

get_header(); ?>

<?php
	if( jobboard_option('enable_homepage_slider') ){
		get_template_part( 'template-parts/homepage', 'slider' );
	}//endif;
?>

<?php
	get_template_part( 'template-parts/form', 'job_search-2' );
?>

<?php
    if( jobboard_option('enable_recent_job') ){
        get_template_part( 'template-parts/homepage', 'jobs_listing' );
    }else{
        get_template_part( 'template-parts/homepage', 'blog' );
    }
?>

<?php
	if( jobboard_option('enable_job_status') ){
		get_template_part( 'template-parts/homepage', 'job_stats' );
	}//endif;
?>

<?php
	if( jobboard_option('enable_job_steps') ){
		get_template_part( 'template-parts/homepage', 'job_step' );
	}//endif;
?>

<?php
	if( jobboard_option('enable_testimonial') ){
		get_template_part( 'template-parts/homepage', 'testimonials' );
	}//endif;
?>

<?php
	if( jobboard_option('enable_company') ){
		get_template_part( 'template-parts/homepage', 'company' );
	}//endif;
?>

<?php
get_footer();
