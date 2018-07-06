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
		<div class="row">
			<div class="col-md-8 jobs-listing-title">
				<h3>
					<i class="fa fa-briefcase"></i>
					<?php _e( 'Recent Jobs', 'jobboard' ); ?>
				</h3>
			</div>
			<div class="col-md-4 jobs-listing-select">
				<div class="form-group">
					<select id="job_select" class="job-list select">
						<option value="alljobs" selected><?php _e( 'All Jobs', 'jobboard' ); ?></option>
					<?php $job_types = get_terms('job_type');
					if ( $job_types ) {
					foreach( $job_types as $job_type ) {
						echo '<option value="tab-'.$job_type->term_id.'">'.esc_attr( $job_type->name ).'</option>';
					} } ?>
					</select>
				</div>
			</div>
		</div>

		<div class="jobs-listing-wrapper">
			<div id="job-listing">
				<div id="loadajax" class="loading-ajax">
				  <i class="fa fa-refresh fa-spin fa-2x"></i>
				</div>
				<div id="alljobs" class="select-tab">
					<div class="select-tab-content">
					<?php
                    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) :
					( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );

                    $job_args = array();
                    $job_args['post_type'] = 'job';
                    $job_args['posts_per_page'] = 3; //get_option('posts_per_page')
                    $job_args['paged'] = $paged;

					$jobs = new WP_Query($job_args);
					while( $jobs-> have_posts() ){
						$jobs->the_post();
					?>
					<div class="job-listing-row homepage clearfix">
						<div class="job-company-logo">
						<!-- <?php
							$comp_id = get_post_meta( get_the_id(), '_jboard_job_company', true );
							echo get_the_post_thumbnail( $comp_id , 'jobboard-related-company-logo-thumbnail' );
						?> -->
						<img width="80px" height="20px" src="wp-content/images/logo.png">
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
							<a href="<?php echo esc_url( get_permalink(get_the_id()) ); ?>" class="btn btn-view-job uppercase"><?php _e( 'Apply Now', 'jobboard' ) ?></a>
						</div><!-- /.job-listing-view -->
					</div><!-- /#job-listing-<?php echo esc_attr( get_the_id() ); ?> -->
					<?php
					} //endwhile;

					  $big = 999999999; // need an unlikely integer

					  echo '<div class="dashboard-pagination">';

					  echo paginate_links( array(
						'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'	=> '?paged=%#%',
						'current'	=> $paged,
						'total'		=> $jobs->max_num_pages,
						'prev_text'	=> '<i class="fa fa-caret-left"></i>',
						'next_text' => '<i class="fa fa-caret-right"></i>',
                    ) );

                    echo '</div><!-- /.dashboard-pagination -->';

					wp_reset_postdata();
					?>
					</div>
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
						$('#<?php echo $job_tabid; ?>').slideUp(200, function(){
						  $('#loadajax').show();
						  $(this).load(link + ' #alljobs .select-tab-content', function() {
							$('#loadajax').hide();
							$(this).slideDown(400);
						  });
						});
					});
                  });
                </script>
                <div id="<?php echo $job_tabid; ?>" class="select-tab">
					<div class="select-tab-content">
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
								<a href="<?php echo esc_url( get_permalink(get_the_id()) ); ?>" class="btn btn-view-job uppercase"><?php _e( 'Apply Now', 'jobboard' ) ?></a>
							</div><!-- /.job-listing-view -->
						</div><!-- /#job-listing-<?php echo esc_attr( get_the_id() ); ?> -->
						<?php
						} //endwhile;
						$big = 999999999; // need an unlikely integer
						echo '<div class="dashboard-pagination">';
						echo paginate_links( array(
							'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format'	=> '?paged=%#%',
							'current'	=> $paged,
							'total'		=> $jobs->max_num_pages,
							'prev_text'	=> '<i class="fa fa-caret-left"></i>',
							'next_text' => '<i class="fa fa-caret-right"></i>',
						) );

						echo '</div><!-- /.dashboard-pagination -->';
						wp_reset_postdata();
						?>
					</div>
				</div><!-- /#<?php echo 'tab-'.esc_attr( $job_type->term_id ); ?> -->
				<?php
					} //endforeach;
				?>
			</div><!-- /#job-listing -->
		</div><!-- /.jobs-listing-wrapper -->
	</div><!-- /.container -->
</div><!-- /#jobs-listings -->
