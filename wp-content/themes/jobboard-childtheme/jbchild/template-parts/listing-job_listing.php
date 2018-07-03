<?php
/**
 * Template Part Name : All Job Listing
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
				<?php
					if( is_page_template( 'page-templates/template-job_search.php' ) ){
						_e( 'Jobs Search Result', 'jobboard' );
					}else{
						_e( 'JOBS', 'jobboard' );
					}

				?>
			</h3>
		</div>
		<div class="jobs-listing-wrapper">
			<div id="job-listing-tabs">
				<ul>
				<?php
					echo '<li><a href="#all_jobs">'.__( 'All', 'jobboard' ).'</a></li>';
					$job_types = get_terms('job_type');
					foreach( $job_types as $job_type ){
						echo '<li><a href="#tab-'.$job_type->term_id.'">'.esc_attr( $job_type->name ).'</a></li>';
					}
				?>
				</ul>
				<div id="loadajax" class="loading-ajax">
				  <i class="fa fa-refresh fa-spin fa-2x"></i>
				</div>
				<div id="all_jobs">
				<?php

                    $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

                    $job_args = array();

                    $job_args['post_type'] = 'job';
                    $job_args['posts_per_page'] = 7;
                    $job_args['paged'] = $paged;

					if( is_page_template( 'page-templates/template-job_search.php' ) ){
						$job_args = array(
							's'				=> $_GET['keyword'],

							'meta_query'	=> array(
								'relation'	=> 'AND',
								array(
									'key'		=> '_jboard_job_sallary',
									'value'		=> array( $_GET['sallary_min'], $_GET['sallary_max'] ),
									'type'		=> 'numeric',
									'compare'	=> 'BETWEEN',
								),
								array(
									'key'		=> '_jboard_job_experiences',
									'value'		=> array( $_GET['experience_min'], $_GET['experience_max'] ),
									'type'		=> 'numeric',
									'compare'	=> 'BETWEEN',
								),
							),

						);

						if( isset( $_GET['location']) && $_GET['location'] != '' ){
							$job_args['tax_query']	= array(
								array(
									'taxonomy'	=> 'job_region',
									'field'		=> 'slug',
									'terms'		=> sanitize_title($_GET['location']),
								),
							);
						}
					}
					$jobs = new WP_Query($job_args);
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
				?>
				</div><!-- /#all_jobs -->
                <?php
                    foreach( $job_types as $job_type ){
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
					$job_args['tax_query'] = array(
						array(
							'taxonomy' => 'job_type',
							'terms' => $job_type->term_id,
						),
					);
					$jobs = new WP_Query($job_args);
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
				?>
				</div><!-- /#<?php echo 'tab-'.esc_attr( $job_type->term_id ); ?> -->
				<?php
					} //endforeach;
				?>
			</div><!-- /#job-listing-tabs -->
		</div><!-- /.jobs-listing-wrapper -->
	</div><!-- /.container -->
</div><!-- /#jobs-listings -->