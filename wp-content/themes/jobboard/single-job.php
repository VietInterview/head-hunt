<?php
/**
 * The main template file for single job listing page
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 */

get_header(); ?>
<?php
while( have_posts() ){
	the_post();
	$job_id = get_the_id();
?>
<div id="job-detail" <?php post_class(); ?>>
	<div class="container">
		<h1 class="job-detail-title">
		<?php echo apply_filters( 'jobboard_job_detail_title', __( 'Job Detail', 'jobboard' ) ); ?>
		</h1>
		<div class="company-job-detail clearfix">
			<div class="company-logo">
			<?php
				$company_id = get_post_meta( $job_id, '_jboard_job_company', true );
				$company_img = has_post_thumbnail( $company_id ) ? get_the_post_thumbnail( $company_id, 'jobboard-job-detail-company' ) : '<h3><strong>'.get_the_title( $company_id ).'</strong></h3>';
				$company_url = get_permalink($company_id);
				echo '<a href="'.esc_url($company_url).'">'.$company_img.'</a>';

			$comp_website 	= get_post_meta( $company_id, '_jboard_company_web_address', true );
			$comp_twitter		= get_post_meta( $company_id, '_jboard_company_social_twitter', true );
			$comp_facebook	= get_post_meta( $company_id, '_jboard_company_social_facebook', true );
			$comp_gplus			= get_post_meta( $company_id, '_jboard_company_social_googleplus', true );
			?>
			</div><!-- /.company-logo -->
			<div class="company-details">
				<?php if ( !empty( $comp_website ) ) : ?>
				<span class="company-website">
					<i class="fa fa-fw fa-chain"></i>
					<a href="<?php echo esc_url( get_post_meta( $company_id, '_jboard_company_web_address', true ) ); ?>" target="_blank"><?php echo __( 'Website', 'jobboard' ); ?></a>
				</span><!-- /.company-website -->
				<?php endif;
				if ( !empty( $comp_twitter ) ) : ?>
				<span class="company-twitter">
					<i class="fa fa-fw fa-twitter"></i>
					<a href="<?php echo esc_url( get_post_meta( $company_id, '_jboard_company_social_twitter', true ) ); ?>" target="_blank"><?php echo __( 'Twitter', 'jobboard' ); ?></a>
				</span><!-- /.company-twitter -->
				<?php endif;
				if ( !empty( $comp_facebook ) ) : ?>
				<span class="company-facebook">
					<i class="fa fa-fw fa-facebook"></i>
					<a href="<?php echo esc_url( get_post_meta( $company_id, '_jboard_company_social_facebook', true ) ); ?>" target="_blank"><?php echo __( 'Facebook', 'jobboard' ); ?></a>
				</span><!-- /.company-facebook -->
				<?php endif;
				if ( !empty( $comp_gplus ) ) : ?>
				<span class="company-google-plus">
					<i class="fa fa-fw fa-google-plus"></i>
					<a href="<?php echo esc_url( get_post_meta( $company_id, '_jboard_company_social_googleplus', true ) ); ?>" target="_blank"><?php echo __( 'Google+', 'jobboard' ); ?></a>
				</span><!-- /.company-google-plus -->
				<?php endif; ?>
			</div><!-- /.company-details -->
		</div><!-- /.company-job-detail -->

		<div class="the-job-details clearfix">
			<div class="the-job-title">
				<h3><?php echo get_the_title(); ?></h3>
				<p><?php echo get_post_meta( $job_id, '_jboard_job_summary', true ); ?></p>
			</div><!-- /.the-job-title -->
			<div class="the-job-company">
				<?php echo get_the_title($company_id); ?>
			</div><!-- /.the-job-company -->
			<div class="the-job-location">
				<i class="fa fa-fw fa-map-marker"></i>
				<?php
					$terms = get_the_terms( $job_id, 'job_region' );
					if($terms) {
					    foreach($terms as $term){
                            echo $term->name.' ';
                        }
					}
				?>
			</div><!-- /.the-job-location -->
			<div class="the-job-type">
				<i class="fa fa-fw fa-user"></i>
				<?php
					$types = get_the_terms( $job_id, 'job_type' );
					if($types) {
                        foreach($types as $type){
                            echo $type->name.' ';
                        }
					}
				?>
			</div><!-- /.the-job-type -->
			<div class="the-job-button">
				<?php jobboard_apply_job_button( $job_id ); ?>
			</div><!-- /.the-job-button -->
		</div><!-- /.the-job-details -->

		<?php

			$job_category = wp_get_post_terms(get_the_id(), 'job_category');

		?>

		<div class="the-job-aditional-details">
			<?php if(!empty($job_category)) { ?>
			<span class="the-job-aditional-title job-cat-links"><?php echo __( 'Category : ', 'jobboard' ); ?>

			<?php

				echo '<a href="'.get_term_link( $job_category[0]->term_id, 'job_category' ).'">'.$job_category[0]->name.'</a>';

			?>

			</span>
			<?php }	?>

			<span class="the-job-aditional-title">

				<?php

					echo __( 'Salary : ', 'jobboard' );

					$job_sallary = get_post_meta( get_the_ID(), '_jboard_job_sallary', true );
					$decimal_point = jobboard_option( 'decimal_point_numbers' );
					$point_separator = jobboard_option( 'decimal_point_separator' );
					$thousand_separator = jobboard_option( 'thousands_separator' );
					$currency_sign = jobboard_option( 'currency_sign' );
					$currency_position = jobboard_option( 'currency_position' );
					$currency_before = ( $currency_position == 'before_nominal' ) ? $currency_sign : '';
					$currency_after = ( $currency_position == 'after_nominal' ) ? $currency_sign : '';

					if ( !empty( $job_sallary ) ) {
						echo $currency_before.number_format( $job_sallary, $decimal_point, $point_separator, $thousand_separator ).$currency_after;
					}

				?>

			</span>

			<span class="the-job-aditional-title"><?php echo __( 'Experience(s) : ', 'jobboard' ).get_post_meta( get_the_ID(), '_jboard_job_experiences', true ).'&nbsp;'._n( 'Year', 'Years', (int) get_post_meta( get_the_ID(), '_jboard_job_experiences' ), 'jobboard' ); ?></span>
		</div><!-- /.the-job-aditional-details -->

		<div id="job-description" class="row">
			<div class="col-md-6">
				<article id="job-overview-<?php echo $job_id; ?>">
					<h1><?php _e( 'Overview', 'jobboard' ); ?></h1>
					<p>
						<?php echo get_post_meta( $job_id, '_jboard_job_overview', true ); ?>
					</p>
				</article><!-- /#job-overview-<?php echo $job_id; ?> -->
			</div><!-- /.col-md-6" -->
			<div class="col-md-6">
				<article id="about-company-<?php echo $job_id; ?>">
					<h1><?php echo __( 'About', 'jobboard' ).'&nbsp;'.esc_attr(get_the_title($company_id)); ?></h1>
					<p>
						<?php echo get_post_meta( $company_id, '_jboard_company_description', true); ?>
					</p>
				</article><!-- /#job-overview-<?php echo $job_id; ?> -->
			</div><!-- /.col-md-6" -->
		</div><!-- /#job-description -->
	</div><!-- /.container -->
</div><!-- /#job-detail -->

<div id="job-content-<?php echo $job_id; ?>" class="the-job-content">
	<div class="container">
		<?php
		if ( isset( $_GET['message'] ) && $_GET['message'] == '10' ) {
			echo '<div class="alert alert-success" role="alert"><strong>';
			echo __('Your job application has been successfully submitted to the company, waiting for a reply from the company via dashboard and your email.', 'jobboard');
			echo '</strong></div>';
		} ?>
		<article><?php the_content(); ?></article>
	</div>
</div><!-- /.the-job-content -->

<?php
	if( jobboard_option( 'enable_related_job' ) ){
		get_template_part( 'template-parts/job_listing', 'related' );
	}//endif;
?>

<?php
	if( jobboard_option( 'enable_upload_job_button' ) ){
		get_template_part( 'template-parts/job_detail', 'upload_post' );
	}//endif;
?>

<?php get_template_part( 'template-parts/modal', 'apply_job' ); ?>

<?php
} //endwhile;
?>
<?php
get_footer();
