<?php
/**
 * Template Part Name : Job Search Form
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 *
 */
?>
<div id="job-search">
	<div class="container">
		<div class="job-search-wrapper">
			<form id="job-search-form" role="form" action="<?php echo esc_url( jobboard_get_permalink( 'job_search' ) ); ?>" method="get">
				<div id="search-text-input" class="row">
					<div class="col-md-4">
						<div class="form-group has-feedback">
							<label class="text-label" for="keyword"><?php _e( 'Search', 'jobboard' ); ?></label>
							<input class="form-control" type="text" name="keyword"  id="keyword" placeholder="<?php echo esc_attr( jobboard_option( 'keyword_placeholder' ) ); ?>" required="required" />
							<span class="fa fa-search form-control-feedback"></span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group has-feedback">
							<label class="text-label" for="location"><?php _e( 'Location', 'jobboard' ); ?></label>
							<?php
								if( jobboard_option( 'location_input_type' ) == 'input_text' ){
							?>
								<input class="form-control" type="text" name="location"  id="location" placeholder="<?php echo esc_attr( jobboard_option( 'location_placeholder' ) ); ?>" />
								<span class="fa fa-map-marker form-control-feedback"></span>
							<?php
								} else {
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
					<div class="col-md-4">
						<div class="form-group job-filter-dropdown">
							<label class="text-label" for="location"><?php _e( 'Category', 'jobboard' ); ?></label>
							<?php
							$args = array(
								'orderby'           => 'name',
								'order'             => 'ASC',
								'hide_empty'        => true,
								'hierarchical'      => true,
								'child_of'          => 0
							);
							$job_categories = get_terms('job_category', $args); ?>
							<div class="job-category-select-wrapper">
								<select id="job-category-dropdown" name="job_category">
									<option value="" class="select-label"><?php _e('Select Job Category', 'jobboard') ?></option>
									<?php foreach($job_categories as $job_category) {
										echo '<option value="'.$job_category->slug.'">'.$job_category->name.'</option>';
									} ?>
								</select>
							</div>
						</div><!-- /.form-group -->
					</div>
				</div><!-- /.row -->

				<div class="row">
					<div class="col-md-4">
						<div class="form-group type">
							<label class="text-label"><?php _e( 'Type', 'jobboard' ); ?></label>
							<?php
							$args = array(
							'orderby'           => 'name',
							'order'             => 'ASC',
							'hide_empty'        => true,
							'hierarchical'      => true,
							'child_of'          => 0
							);
							$job_types = get_terms('job_type', $args); ?>
							<div class="job_type inline">
							<?php foreach($job_types as $job_type) {
								echo '<div class="checkbox">';
								echo '<input type="checkbox" name="job_type[]" id="check-'.$job_type->slug.'" value="'.$job_type->slug.'" class="styled" checked>';
								echo '<label for="check-'.$job_type->slug.'">'.$job_type->name.'</label>';
								echo '</div>';
							} ?>
							</div>
						</div><!-- /.form-group -->
					</div>
					<div class="col-md-6">
						<div class="form-group sallary">
							<label class="slider-label"><?php printf( __( 'Salary (%s) / per month', 'jobboard' ), jobboard_option( 'currency_sign' ) ); ?></label>
							<select class="init-slider" name="sallary_min" id="sallary_min">
								<option value="0">0</option>
								<?php
								$new_structure = array();
								$exp = explode( "\n", jobboard_option( 'salary_parameters' ) );
								foreach( $exp as $child ){
									$numbers = explode( ';', $child );
									echo '<option value="'.esc_attr( $numbers[0] ).'">'.esc_attr( $numbers[1] ).'</option>';
								} ?>
							</select>
							<select class="init-slider" name="sallary_max" id="sallary_max">
								<option value="0">0</option>
								<?php
								$new_structure = array();
								$exp = explode( "\n", jobboard_option( 'salary_parameters' ) );
								foreach( $exp as $child ){
									$numbers = explode( ';', $child );
									echo '<option value="'.esc_attr( $numbers[0] ).'">'.esc_attr( $numbers[1] ).'</option>';
								} ?>
							</select>
						</div>
					</div>
					<div id="search-btn-wrap" class="col-sm-12 col-md-2 text-right">
						<button class="btn btn-default btn-job-search" type="submit" name="submit" value="true"><?php _e('Search', 'jobboard'); ?></button>
					</div>
				</div>

			</form><!-- /#job-search-form -->
		</div><!-- /.job-search-wrapper -->
	</div><!-- /.container -->
</div><!-- /#job-search -->
