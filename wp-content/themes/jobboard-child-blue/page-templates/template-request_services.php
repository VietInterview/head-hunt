<?php
/**
 * Template Name: Request Services
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 *
 */

$math_contact = new MathQuestion();

get_header(); ?>

<div id="page-title-wrapper">
	<div class="container">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</div><!-- /.container -->
</div><!-- /#page-title -->
<div id="content">
	<div class="container">
	<?php
		while( have_posts() ){
			the_post();
	?>
		<article id="contact-page-<?php echo get_the_id(); ?>">
		<?php the_content(); ?>
		</article><!-- /.#contact-page-<?php echo get_the_id(); ?> -->
	<?php
		}//endwhile;
		wp_reset_postdata();
	?>
		<form id="contact-form" action="<?php echo esc_url( admin_url('admin-ajax.php') ); ?>" method="post">
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
						<label for="contact_website"><?php _e( 'Website', 'jobboard' ); ?></label>
						<input type="text" name="contact_website" id="contact_website" class="form-control" />
					</div><!-- /.form-group -->
				</div><!-- /.col-md-4 -->
				<div class="col-md-8">
					<div class="form-group">
						<label for="contact_subject"><?php _e( 'Subject', 'jobboard' ); ?></label>
						<input type="text" name="contact_subject" id="contact_subject" class="form-control" />
					</div><!-- /.form-group -->
				</div><!-- /.col-md-8 -->
			</div><!-- /.row -->
			<div class="form-group">
				<label for="contact_message"><?php _e( 'Message', 'jobboard' ); ?></label>
				<textarea name="contact_message" rows="7" class="form-control" required="required" ></textarea>
			</div><!-- /.form-group -->
			<div class="row">
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon" id="the-question"><?php echo sprintf( __( 'What is %s =', 'jobboard' ), $math_contact->getQuestion()); ?></span>
						<input class="form-control" type="text" name="human_answer" id="human_answer" required="required" placeholder="answer?" aria-describedby="the-question" />
					</div><!-- /.input-group -->
				</div>
				<div class="col-md-8">
					<input type="hidden" name="hash_answer" value="<?php echo $math_contact->getAnswerHash(); ?>" />
					<input type="hidden" name="action" value="jobboard_send_contact_form" />
					<button type="submit" name="contact_submit" value="1" class="btn btn-send-contact-form" data-loading-text="<?php _e( 'Sending...', 'jobboard' ); ?>"><?php _e( 'Send', 'jobboard' ); ?></button>
				</div>
			</div><!-- /.row -->

			<div class="contact-form-status alert alert-success alert-dismissable" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only"><?php _e( 'Close', 'jobboard' ); ?></span></button>
				<?php _e( '<strong>Thank you!</strong> Your message was sent successfully', 'jobboard' ); ?>
			</div>
			<div class="contact-form-human alert alert-danger alert-dismissable" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only"><?php _e( 'Close', 'jobboard' ); ?></span></button>
				<?php _e( 'Human Check: Your answer incorrect!', 'jobboard' ); ?>
			</div>
		</form>
	</div><!-- /.container -->
</div><!-- /#content -->
</script>
<?php get_footer(); ?>
