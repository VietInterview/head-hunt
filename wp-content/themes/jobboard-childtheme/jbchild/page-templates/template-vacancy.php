<?php

/**
 * Template Name: Vacancy
 *
 *
 */
 
get_header(); ?>

<div id="page-title-wrapper">
	<div class="container">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</div><!-- /.container -->
</div><!-- /#page-title -->

<div id="content" <?php post_class(); ?>>
	<div class="container">
		<article id="page-<?php the_ID(); ?>">
		<?php
			while( have_posts() ){
				the_post();

				the_content();

			}//endwhile;
		?>
		</article>
		<form id="contact-form" class="vacancy-form" action="<?php echo esc_url( admin_url('admin-ajax.php') ); ?>" method="post">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="contact_name"><?php _e( 'Name', 'jobboard' ); ?></label>
						<input type="text" name="contact_name" id="contact_name" class="form-control" required="required" />
					</div><!-- /.form-group -->
				</div><!-- /.col-md-4 -->
				<div class="col-md-4">
					<div class="form-group">
						<label for="contact_email"><?php _e( 'Email', 'jobboard' ); ?></label>
						<input type="email" name="contact_email" id="contact_email" class="form-control" required="required" />
					</div><!-- /.form-group -->
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="contact_telp"><?php _e( 'Telephone', 'jobboard' ); ?></label>
						<input type="text" name="contact_telp" id="contact_telp" class="form-control" />
					</div><!-- /.form-group -->
				</div>
			</div><!-- /.row -->

			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="contact_company_name"><?php _e( 'Company Name', 'jobboard' ); ?></label>
						<input type="text" name="contact_company_name" id="contact_company_name" class="form-control" />
					</div><!-- /.form-group -->
				</div><!-- /.col-md-4 -->
				<div class="col-md-4">
					<div class="form-group">
						<label for="contact_location"><?php _e( 'Location', 'jobboard' ); ?></label>
						<input type="text" name="contact_location" id="contact_location" class="form-control" />
					</div><!-- /.form-group -->
				</div><!-- /.col-md-4 -->
				<div class="col-md-4">
					<div class="form-group">
						<label for="contact_subject"><?php _e( 'Job Function', 'jobboard' ); ?></label>
						<input type="text" name="contact_subject" id="contact_subject" class="form-control" />
					</div><!-- /.form-group -->
				</div><!-- /.col-md-8 -->
			</div><!-- /.row -->
			<div class="form-group">
				<label for="resume_file"><?php _e( 'Upload job description', 'jobboard' ); ?></label>
				<?php
					if( isset($_GET['action']) && $_GET['action'] == 'edit' ){
						$file = get_post_meta( $resume_id, 'job_description_file', true );
                        if(!empty($file)){
				?>
						<div class="alert alert-success job_description_file">
		                  <input type="hidden" name="resume_file_status" id="job_description_file_status" value="" />
		                  <button type="button" class="close"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only"><?php _e( 'Delete', 'jobboard' ); ?></span></button>
		                  <a href="<?php echo $file; ?>" title="<?php _e( 'View Job description File', 'jobboard' ); ?>" target="_blank">
		                  <strong><?php echo basename($file); ?></strong>
		                  </a>
		                </div>
		        <?php
                        }//!empty
					}//endif;
				?>
				<input class="" type="file" name="resume_file" id="resume_file" accept="image/*,application/pdf,application/msword" />
			</div><!-- /.form-group -->
			<div class="form-group">
				<label for="contact_message"><?php _e( 'Message', 'jobboard' ); ?></label>
				<textarea name="contact_message" rows="7" class="form-control" required="required" ></textarea>
			</div><!-- /.form-group -->
			<div>
				<input type="hidden" name="action" value="jobboard_send_contact_form" />
				<button type="submit" name="contact_submit" value="1" class="btn btn-send-contact-form" data-loading-text="<?php _e( 'Sending...', 'jobboard' ); ?>"><?php _e( 'Send', 'jobboard' ); ?></button>
			</div><!-- /.row -->

			<div class="contact-form-status alert alert-success alert-dismissable" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only"><?php _e( 'Close', 'jobboard' ); ?></span></button>
				<?php _e( '<strong>Thank you!</strong> Your message was sent successfully', 'jobboard' ); ?>
			</div>
		</form>
	</div><!-- /.container -->
</div><!-- /#content -->

<?php
get_footer();