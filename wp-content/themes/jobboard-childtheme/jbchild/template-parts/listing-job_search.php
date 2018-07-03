<?php
/**
 * Template Part Name : Search Result Job Listing
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 *
 */
?>
<div id="jobs-listing" class="related-job-listing featured-job">
	<div class="container">
		<div class="jobs-listing-title">
			<h3>
				<i class="fa fa-briefcase"></i>
				<?php _e( 'Jobs Search Result', 'jobboard' ); ?>
			</h3>
		</div>
		<div class="jobs-search-wrapper">
			<div id="all_jobs">
				<?php
					//Protect against arbitrary paged values
					$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

					$job_args['post_type'] = 'job';

					if( isset($_GET['submit']) && is_page_template( 'page-templates/template-job_search.php' ) ){

						//Search Keyword
						if( isset($_GET['keyword']) && $_GET['keyword'] != '' ){
							$job_args['s'] = $_GET['keyword'];
						}

						/** Job Meta Search Result **/
						$sal = array(
							'min'	=> isset($_GET['sallary_min'])?$_GET['sallary_min']:'',
							'max'	=> isset($_GET['sallary_max'])?$_GET['sallary_max']:'',
						);
						$exp = array(
							'min'	=> isset($_GET['experience_min'])?$_GET['experience_min']:'',
							'max'	=> isset($_GET['experience_max'])?$_GET['experience_max']:'',
						);
						$job_meta = 1;

						//Job Salary Field
						if( $sal['min'] != '' || $sal['max'] != '' ){
							$job_meta += 1;
							$sal_query = array(
								'key'		=> '_jboard_job_sallary',
								'value'		=> array( $sal['min'], $sal['max'] ),
								'type'		=> 'numeric',
								'compare'	=> 'BETWEEN',
							);
						}else{
							$sal_query = null;
						}

						//Job Experience Field
						if( $exp['min'] != '' || $exp['max'] != '' ){
							$job_meta += 1;
							$exp_query = array(
								'key'		=> '_jboard_job_experiences',
								'value'		=> array( $exp['min'], $exp['max'] ),
								'type'		=> 'numeric',
								'compare'	=> 'BETWEEN',
							);
						}else{
							$exp_query = null;
						}

						if( $job_meta > 2 ){
							$meta_relation = array( 'relation' => 'AND', );
						}else{
							$meta_relation = null;
						}

						if( $sal_query != null || $exp_query != null ){

							$job_args['meta_query']	= array(
								$meta_relation,
								$sal_query,
								$exp_query,
							);
						}

						/** Job Terms Search Result **/

						$job_term = 1;

						//Job Category Field
						if( isset( $_GET['job_category']) && $_GET['job_category'] != '' ){
							$job_term += 1;
							$job_category_query = array(
								'taxonomy'	=> 'job_category',
								'field'		=> 'slug',
								'terms'		=> sanitize_title($_GET['job_category']),
							);
						}else{
							$job_category_query = null;
						}

						//Job Tyle Field
						if( isset( $_GET['job_type']) && $_GET['job_type'] != '' ){
							$job_term += 1;
							$job_type_query = array(
								'taxonomy'	=> 'job_type',
								'field'		=> 'slug',
								'terms'		=> sanitize_title($_GET['job_type']),
							);
						}else{
							$job_type_query = null;
						}

						//Location Field
						if( isset( $_GET['location']) && $_GET['location'] != '' ){
							$job_term += 1;
							$job_location_query = array(
								'taxonomy'	=> 'job_region',
								'field'		=> 'slug',
								'terms'		=> sanitize_title($_GET['location']),
							);
						}else{
							$job_location_query = null;
						}

						if( $job_term > 2 ){
							$term_relation = array( 'relation' => 'AND', );
						}else{
							$term_relation = null;
						}

						$job_args['tax_query']	= array(
							$term_relation,
							$job_category_query,
							$job_type_query,
							$job_location_query,
						);

					}

					$job_args['posts_per_page'] = 10;
					$job_args['paged'] = $paged;

					$jobs = new WP_Query($job_args);

					if( $jobs->have_posts() ){
						while( $jobs-> have_posts() ){
							$jobs->the_post();
						?>
						<div class="job-listing-row clearfix">
							<div class="job-company-logo">
							<?php
								$comp_id = get_post_meta( get_the_id(), '_jboard_job_company', true );
								echo get_the_post_thumbnail( $comp_id , 'jobboard-related-company-logo-thumbnail' );
							?>
							</div><!-- /.job-company-logo -->
							<div class="job-listing-name">
								<h4><?php echo esc_attr( get_the_title() ); ?></h4>
								<p class="job-listing-summary"><?php echo get_post_meta( get_the_id(), '_jboard_job_summary', true ); ?></p>
							</div><!-- /.job-listing-name -->
							<div class="job-listing-region">
								<i class="fa fa-fw fa-map-marker"></i>
								<?php
									$job_taxs = get_the_terms( get_the_id(), 'job_region' );
									if($job_taxs){
										foreach( $job_taxs as $job_tax ){
											echo esc_attr( $job_tax->name );
										}
									}
								?>
							</div><!-- /.job-listing-region -->
							<div class="job-listing-type hidden-sm hidden-xs">
								<i class="fa fa-fw fa-user"></i>
								<?php
									$job_taxs = get_the_terms( get_the_id(), 'job_type' );
									if($job_taxs){
										foreach( $job_taxs as $job_tax ){
											echo esc_attr( $job_tax->name );
										}
									}
								?>
							</div><!-- /.job-listing-type -->
							<div class="job-listing-view">
								<a href="<?php echo esc_url( get_permalink(get_the_id()) ); ?>" class="btn btn-view-job"><?php _e( 'View Job', 'jobboard' ) ?></a>
							</div><!-- /.job-listing-view -->
						</div><!-- /#job-listing-<?php echo esc_attr( get_the_id() ); ?> -->
					<?php
						} //endwhile;

						$big = 999999999; // need an unlikely integer

						echo '<div class="dashboard-pagination">';

						echo paginate_links( array(
							'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format'	=> '?paged=%#%',
							'current'	=> max( 1, get_query_var('paged') ),
							'total'		=> $jobs->max_num_pages,
							'prev_text'	=> __( 'Previous', 'jobboard' ),
							'next_text' => __( 'Next', 'jobboard' ),
						) );

			            echo '</div><!-- /.dashboard-pagination -->';
						wp_reset_postdata();
					}else{
						jobboard_not_found( 'job_search' );
					}//endif;
					?>
				</div><!-- /#all_jobs -->
		</div><!-- /.jobs-listing-wrapper -->
	</div><!-- /.container -->
</div><!-- /#jobs-listings -->
