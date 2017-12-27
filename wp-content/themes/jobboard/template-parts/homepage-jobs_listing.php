<?php
/**
 * Template Part Name : Homepage Job Listing
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 *
 */
?>
<div id="jobs-listing" class="in-homepage">
	<div class="container">
		<div class="row">

			<div class="col-lg-8">
				<div class="jobs-listing-title">
					<h3><i class="fa fa-briefcase"></i><?php _e( 'Recent Jobs', 'jobboard' ); ?></h3>
				</div>
				<div class="jobs-listing-wrapper">
					<div id="job-listing-tabs">
						<ul>
						<?php
							echo '<li><a href="#all_jobs">'.__( 'All', 'jobboard' ).'</a></li>';
							$job_types = jobboard_option('recent_job_type_tab');
							foreach( $job_types as $job_type ){
								$job_type = get_term( $job_type, 'job_type' );
								echo '<li><a href="#tab-'.$job_type->term_id.'">'.esc_attr( $job_type->name ).'</a></li>';
							}
						?>
						</ul>

						<div id="loadajax" class="loading-ajax"><i class="fa fa-refresh fa-spin fa-2x"></i></div>

						<div id="all_jobs">
						<?php

							$pagevar = is_front_page() ? 'page' : 'paged';
							$cu_page = ( get_query_var( $pagevar ) ) ? absint( get_query_var( $pagevar ) ) : 1;

							$hjob_args = array();

							$hjob_args['post_type'] = 'job';
							$hjob_args['posts_per_page'] = jobboard_option('latest_job_per_page');
							$hjob_args['paged'] = $cu_page;

							$hjobs = new WP_Query($hjob_args);

							while( $hjobs-> have_posts() ){
								$hjobs->the_post();
						?>
							<a class="job-listing-permalink" href="<?php echo esc_url( get_permalink() ); ?>">
								<div class="job-listing-row clearfix">
									<div class="job-company-logo">
									<?php
										$comp_id = get_post_meta( get_the_id(), '_jboard_job_company', true );
										$company_img = get_the_post_thumbnail( $comp_id, 'jobboard-company-logo-thumbnail' );
										echo $company_img;
									?>
									</div><!-- /.job-company-logo -->
									<div class="job-listing-name">
										<h4>
											<?php if(get_post_meta( get_the_id(), '_jboard_job_status', true ) == 'open'): ?>
											<span class="label label-success">Open</span> 
											<?php elseif(get_post_meta( get_the_id(), '_jboard_job_status', true ) == 'closed'): ?>
											<span class="label label-danger">Closed</span> 
											<?php endif; ?>
											<?php echo esc_attr( get_the_title() ); ?>
										</h4>
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
									<div class="job-listing-type">
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
								</div><!-- /#job-listing-<?php echo get_the_id(); ?> -->
							</a>
						<?php
							}

							echo '<div class="dashboard-pagination">';

							echo paginate_links( array(
								'base'	  	=> get_pagenum_link(1).'%_%',
								'current'	  => $cu_page,
								'total'	  	=> $hjobs->max_num_pages,
								'prev_text' => __( 'Previous', 'jobboard' ),
								'next_text' => __( 'Next', 'jobboard' ),
							) );

							echo '</div><!-- /.dashboard-pagination -->';

							wp_reset_postdata();
						?>
						</div><!-- /#all_jobs -->
						<?php
							foreach( $job_types as $job_type ){
								$job_type = get_term( $job_type, 'job_type' );
								$job_tabid = 'tab-'.$job_type->term_id;
						?>
						<script>
							jQuery(document).ready(function($){
								"use strict";
								$('#<?php echo $job_tabid; ?>').on('click', '.dashboard-pagination a.page-numbers', function(e){
									e.preventDefault();
									var link = $(this).attr('href');
									$('#<?php echo $job_tabid; ?>').slideUp(300, function(){
										$('#loadajax').show();
										$(this).load(link + ' #<?php echo $job_tabid; ?>', function() {
											$('#loadajax').hide();
											$(this).slideDown(800);
										});
									});
								});
							});
						</script>
						<div id="<?php echo $job_tabid; ?>">
						<?php
							$hjob_args['tax_query'] = array(
								array(
									'taxonomy' => 'job_type',
									'terms' => $job_type->term_id,
								),
							);
							$hjobs = new WP_Query($hjob_args);
							while( $hjobs-> have_posts() ){
								$hjobs->the_post();
						?>
							<a class="job-listing-permalink" href="<?php echo esc_url( get_permalink() ); ?>">
								<div class="job-listing-row clearfix">
									<div class="job-company-logo">
									<?php
										$comp_id = get_post_meta( get_the_id(), '_jboard_job_company', true );
										echo get_the_post_thumbnail( $comp_id , 'jobboard-company-logo-thumbnail' );
									?>
									</div><!-- /.job-company-logo -->
									<div class="job-listing-name">
										<h4>
											<?php if(get_post_meta( get_the_id(), '_jboard_job_status', true ) == 'open'): ?>
											<span class="label label-success">Open</span> 
											<?php elseif(get_post_meta( get_the_id(), '_jboard_job_status', true ) == 'closed'): ?>
											<span class="label label-danger">Closed</span> 
											<?php endif; ?>
											<?php echo esc_attr( get_the_title() ); ?>	
										</h4>
										<p class="job-listing-summary"><?php echo get_post_meta( get_the_id(), '_jboard_job_summary', true ); ?></p>
									</div><!-- /.job-listing-name -->
									<div class="job-listing-region">
										<i class="fa fa-fw fa-map-marker"></i>
										<?php
											$job_taxs = get_the_terms( get_the_id(), 'job_region' );
											if($job_taxs){
												foreach( $job_taxs as $job_tax ){
													echo esc_attr( $job_tax->name );
												}//endforeach;
											}//endif;
										?>
									</div><!-- /.job-listing-region -->
									<div class="job-listing-type">
										<i class="fa fa-fw fa-user"></i>
										<?php
											$job_taxs = get_the_terms( get_the_id(), 'job_type' );
											if($job_taxs){
												foreach( $job_taxs as $job_tax ){
													echo esc_attr( $job_tax->name );
												}//endforeach;
											}//endif;
										?>
									</div><!-- /.job-listing-type -->
								</div><!-- /#job-listing-<?php echo get_the_id(); ?> -->
							</a>
						<?php
							}
							echo '<div class="dashboard-pagination">';

							echo paginate_links( array(
								'base'	  	=> get_pagenum_link(1).'%_%',
								'current'	  => $cu_page,
								'total'	  	=> $hjobs->max_num_pages,
								'prev_text' => __( 'Previous', 'jobboard' ),
								'next_text' => __( 'Next', 'jobboard' ),
							) );

							echo '</div><!-- /.dashboard-pagination -->';

              wp_reset_postdata();
						?>
						</div><!-- /#<?php echo esc_attr( $job_type->slug ).'-'.esc_attr( $job_type->term_id ); ?> -->
						<?php
							}
						?>
					</div><!-- /#job-listing-tabs -->
				</div><!-- /.jobs-listing-wrapper -->
			</div><!-- /.col-md-8 -->

			<?php get_sidebar('home'); ?>

		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /#jobs-listings -->