<?php
/**
 * Template Part Name : Job Search Form
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 *
 */



	$search_option = jobboard_option('enable_advance_search');


?>
<div id="job-search">
	<div class="container">
		<div class="job-search-wrapper">
			<h2 class="job-search-title"><?php _e( 'Find a Job', 'jobboard' ); ?></h2>
			<form id="job-search-form" role="form" action="<?php echo esc_url( jobboard_get_permalink( 'job_search' ) ); ?>" method="get">
				<div id="search-text-input" class="row">
					<div class="col-md-3">
						<div class="form-group has-feedback">
							<label class="text-label" for="keyword"><?php _e( 'Search', 'jobboard' ); ?></label>
							<input class="form-control" type="text" name="keyword"  id="keyword" placeholder="<?php echo esc_attr( jobboard_option( 'keyword_placeholder' ) ); ?>" required="required" />
							<span class="fa fa-search form-control-feedback"></span>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group has-feedback">
							<label class="text-label" for="location"><?php _e( 'Location', 'jobboard' ); ?></label>
							<?php
								if( jobboard_option( 'location_input_type' ) == 'input_text' ){
							?>
								<input class="form-control" type="text" name="location"  id="location" placeholder="<?php echo esc_attr( jobboard_option( 'location_placeholder' ) ); ?>" />
								<span class="fa fa-map-marker form-control-feedback"></span>
							<?php
								}else{
							?>
								<select name="location" id="location">
								<?php
									echo '<option value="" selected="selected">'.__( 'Location', 'jobboard' ).'</option>';
									$terms = get_terms( 'job_region' );
									foreach( $terms as $term ){
										echo '<option value="'.esc_attr( $term->slug ).'">'.esc_attr( $term->name ).'</option>';
									}
								?>
								</select>
							<?php
								}
							?>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group job-filter-dropdown">
							<label class="text-label" for="category"><?php _e( 'Category', 'jobboard' ); ?></label>

						<?php

						$args = array(
							'orderby'           => 'name',
							'order'             => 'ASC',
							'hide_empty'        => false,
							'exclude'           => array(),
							'exclude_tree'      => array(),
							'include'           => array(),
							'number'            => '',
							'fields'            => 'all',
							'slug'              => '',
							'name'              => '',
							'parent'            => '',
							'hierarchical'      => true,
							'child_of'          => 0,
							'get'               => '',
							'name__like'        => '',
							'description__like' => '',
							'pad_counts'        => false,
							'offset'            => '',
							'search'            => '',
							'cache_domain'      => 'core'
						);
						$job_categories = get_terms('job_category', $args);

						echo '<div class="job-category-select-wrapper">';
						echo '<select id="job-category-dropdown" name="job_category">';

						echo '<option value="" class="select-label">'.__('Select Job Category', 'jobboard').'</option>';

						foreach($job_categories as $job_category) :

							echo '<option value="'.$job_category->slug.'">'.$job_category->name.'</option>';

						endforeach;

						echo '</select>';
						echo '</div>';

						?>

						<script>
							jQuery(document).ready(function($){

								"use strict";
								// Homepage job filter
								$('#job-category-dropdown').selectize({

								});
							});
						</script>

						</div><!-- /.form-group -->
					</div><!-- /.col-md-3 -->


					<div class="col-md-3">
						<div class="form-group job-filter-dropdown">
							<label class="text-label" for="location"><?php _e( 'Salary', 'jobboard' ); ?></label>

						<?php
						$args = array(
						'orderby'           => 'name',
						'order'             => 'ASC',
						'hide_empty'        => true,
						'exclude'           => array(),
						'exclude_tree'      => array(),
						'include'           => array(),
						'number'            => '',
						'fields'            => 'all',
						'slug'              => '',
						'name'              => '',
						'parent'            => '',
						'hierarchical'      => true,
						'child_of'          => 0,
						'get'               => '',
						'name__like'        => '',
						'description__like' => '',
						'pad_counts'        => false,
						'offset'            => '',
						'search'            => '',
						'cache_domain'      => 'core'
						);
						$salaries = get_terms('salary', $args);

						echo '<div class="salary-select-wrapper">';
							echo '<select id="salary-dropdown" name="salary">';

								echo '<option value="" class="select-label">'.__('Select Salary / per year', 'jobboard').'</option>';

								//foreach($salaries as $salary) :

								echo '<option value="100">'.'200'.'</option>';
								echo '<option value="200">'.'500'.'</option>';
								echo '<option value="300">'.'700'.'</option>';
								echo '<option value="400">'.'1000'.'</option>';
								echo '<option value="500">'.'1200'.'</option>';

								//endforeach;

								echo '</select>';
								echo '</div>';
								?>

								<script>
									jQuery(document).ready(function($){

										"use strict";
										// Homepage salary filter
										$('#salary-dropdown').selectize({

										});
									});
								</script>
								</div><!-- /.form-group -->
							</div><!-- /.col-md-5 -->

						</div><!-- /.row -->
						<!-- Job Category and Job Type Ends -->

				

				</div><!-- /#advance-search-option -->
				<!-- Andvance Search Ends -->


				<div id="search-btn-wrap" class="row">

					<div class="col-md-8">
					</div>

					<div class="col-md-4 search-btn-group">

						<?php

						$btn_class = '';
						if( '0' == $search_option ){
							$btn_class = 'simple-search-btn';
						}

						?>

						<button class="btn btn-default btn-job-search <?php echo $btn_class; ?>" type="submit" name="submit" value="true"><?php echo __('Search', 'jobboard'); ?></button>

						<?php if( '1' == $search_option ) : ?>
							<button class="btn btn-default advance-search-toggle" name="advance-search"><?php echo __('Advanced Search', 'jobboard'); ?></button>
						<?php endif; ?>
					</div><!-- /.col-md-9 -->


				</div><!-- /.row -->

			</form><!-- /#job-search-form -->
		</div><!-- /.job-search-wrapper -->
	</div><!-- /.container -->
</div><!-- /#job-search -->
