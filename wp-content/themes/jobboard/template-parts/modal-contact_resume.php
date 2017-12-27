<?php
/**
 * Template Part Name : Resume contact modal
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 *
 */

if ( is_user_logged_in() ) {
	$current_user	= wp_get_current_user();
	$current_name	= get_the_author_meta( 'first_name', $current_user->data->ID ) . ' ' . get_the_author_meta( 'last_name', $current_user->data->ID );
	$contact_name	= empty( $current_name ) ? $current_user->data->user_login : $current_name;
	$contact_email	= $current_user->data->user_email;
	$disabled		= 'disabled';
} else {
	$contact_name	= '';
	$contact_email	= '';
	$disabled		= '';
}
?>

<!-- Modal Contact Resume -->
<div class="modal fade" id="contact-resume-modal" tabindex="-1" role="dialog" aria-labelledby="jobboard-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="contact-job-seeker" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e( 'Close', 'jobboard' ); ?></span></button>
					<h4 class="modal-title" id="jobboard_apply_job"><?php _e( 'Contact Job Seeker', 'jobboard' ); ?></h4>
				</div><!-- /.modal-header -->
			
				<div class="modal-body">
					<div class="form-group">
						<label for="contact_name"><?php _e( 'Your Name', 'jobboard' ); ?>*</label>
						<input class="form-control" type="text" name="contact_name" id="contact_name" value="<?php echo $contact_name; ?>" required="required" <?php echo $disabled; ?> />
						<input type="hidden" name="contact_name_hide" value="<?php echo $contact_name; ?>" />
					</div><!-- /.form-group -->
				
					<div class="form-group">
						<label for="contact_email"><?php _e( 'Your Email', 'jobboard' ); ?>*</label>
						<input class="form-control" type="email" name="contact_email" id="contact_email" value="<?php echo $contact_email; ?>" required="required" <?php echo $disabled; ?> />
						<input type="hidden" name="contact_email_hide" value="<?php echo $contact_email; ?>" />
					</div><!-- /.form-group -->
				
					<div class="form-group">
						<label for="contact_message"><?php _e( 'Your Message*', 'jobboard' ); ?></label>
						<textarea name="contact_message" id="contact_message" class="form-control" required="required" rows="8"></textarea>
					</div><!-- /.form-group -->
					
					<div class="contact-form-status alert alert-success alert-dismissable" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only"><?php _e( 'Close', 'jobboard' ); ?></span></button>
						<?php _e( '<strong>Thank you!</strong> Your message was sent successfully', 'jobboard' ); ?>
					</div>
					<input type="hidden" name="job_seeker_email" value="<?php echo get_the_author_meta( 'user_email', $post->post_author ); ?>" />
				</div><!-- /.modal-body -->
			
				<div class="modal-footer">
					<button class="btn btn-send-contact-form" type="submit" name="submit" id="submit" value="1" data-loading-text="<?php _e( 'Sending...', 'jobboard' ); ?>"><?php _e( 'Send', 'jobboard' ); ?></button>
					<input type="hidden" name="job_seeker_id" value="<?php the_author_meta('ID'); ?> " />
					<input type="hidden" name="action" value="jobboard_send_contact_job_seeker" />
				</div><!-- /.modal-footer -->
			</form>
		</div><!-- ./modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->
<!-- /.Modal Contact Resume -->
