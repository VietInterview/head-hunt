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
					<div class="col-md-7">
						<div class="form-group has-feedback">
							<label class="text-label" for="keyword"><?php _e( 'Search', 'jobboard' ); ?></label>
							<input class="form-control" type="text" name="keyword"  id="keyword" placeholder="<?php echo esc_attr( jobboard_option( 'keyword_placeholder' ) ); ?>" required="required" />
							<span class="fa fa-search form-control-feedback"></span>
						</div>
					</div>
					<div class="col-md-5">
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
									echo '<option value="" selected="selected">'.__( 'Any', 'jobboard' ).'</option>';
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
				</div><!-- /.row -->

				<?php

				// Advanced Search setting
				if( '1' == $search_option ) :

				?>

				<!-- Advanced Search Starts -->

				<div id="advance-search-option">



					<!-- Job Category and Job Type Starts -->

					<div class="row">

						<div class="col-md-7">

							<div class="form-group job-filter-dropdown">
								<label class="text-label" for="location"><?php _e( 'Category', 'jobboard' ); ?></label>

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
						</div><!-- /.col-md-7 -->


						<div class="col-md-5">
							<div class="form-group job-filter-dropdown">
								<label class="text-label" for="location"><?php _e( 'Type', 'jobboard' ); ?></label>

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
							$job_types = get_terms('job_type', $args);

							echo '<div class="job-type-select-wrapper">';
								echo '<select id="job-type-dropdown" name="job_type">';

									echo '<option value="" class="select-label">'.__('Select Job Type', 'jobboard').'</option>';

									foreach($job_types as $job_type) :

									echo '<option value="'.$job_type->slug.'">'.$job_type->name.'</option>';

									endforeach;

									echo '</select>';
									echo '</div>';
									?>

									<script>
										jQuery(document).ready(function($){

											"use strict";
											// Homepage job filter
											$('#job-type-dropdown').selectize({

											});
										});
									</script>
									</div><!-- /.form-group -->
								</div><!-- /.col-md-5 -->

							</div><!-- /.row -->
							<!-- Job Category and Job Type Ends -->


				<div class="form-group experience">
					<fieldset>
						<label class="slider-label"><?php _e( 'Experience (Years)', 'jobboard' ); ?></label>
						<select class="init-slider" name="experience_min" id="experience_min">
							<option value="">0</option>
							<?php
								$new_structure = array();
								$exp = explode( "\n", jobboard_option( 'experience_parameters' ) );
								foreach( $exp as $child ){
									$numbers = explode( ';', $child );
									echo '<option value="'.esc_attr( $numbers[0] ).'">'.esc_attr( $numbers[1] ).'</option>';
								}


							?>
						</select>
						<select class="init-slider" name="experience_max" id="experience_max">
							<option value="">0</option>
							<?php
								$new_structure = array();
								$exp = explode( "\n", jobboard_option( 'experience_parameters' ) );
								foreach( $exp as $child ){

									$numbers = explode( ';', $child );
									echo '<option value="'.esc_attr( $numbers[0] ).'">'.esc_attr( $numbers[1] ).'</option>';
								}

							?>
						</select>
					</fieldset>
				</div><!-- /.experience -->
				<div class="form-group sallary">
					<label class="slider-label"><?php printf( __( 'Salary (%s) / per year', 'jobboard' ), jobboard_option( 'currency_sign' ) ); ?></label>
						<select class="init-slider" name="sallary_min" id="sallary_min">
							<option value="">0</option>
							<?php
								$new_structure = array();
								$exp = explode( "\n", jobboard_option( 'salary_parameters' ) );
								foreach( $exp as $child ){

									$numbers = explode( ';', $child );
									echo '<option value="'.esc_attr( $numbers[0] ).'">'.esc_attr( $numbers[1] ).'</option>';
								}

							?>
						</select>
						<select class="init-slider" name="sallary_max" id="sallary_max">
							<option value="">0</option>
							<?php
								$new_structure = array();
								$exp = explode( "\n", jobboard_option( 'salary_parameters' ) );
								foreach( $exp as $child ){

									$numbers = explode( ';', $child );
									echo '<option value="'.esc_attr( $numbers[0] ).'">'.esc_attr( $numbers[1] ).'</option>';
								}

							?>
						</select>
				</div>


				</div><!-- /#advance-search-option -->
				<!-- Andvance Search Ends -->

				<?php

				endif;
				// Advanced Search ends

				?>



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
