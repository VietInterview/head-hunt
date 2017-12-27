<?php
/**
 * Default 404 Not Found Page.
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 2.5
 */

get_header();


$img = jobboard_option('notfound_image');
$ttl = jobboard_option('notfound_title');
$cnt = jobboard_option('notfound_content');
$clr = jobboard_option('notfound_title_color');
$is_search = jobboard_option('enable_notfound_searchform');
$is_button = jobboard_option('enable_notfound_buttons');
?>
<div id="page-title-wrapper">
	<div class="container">
		<h1 class="page-title"><?php _e( 'Page Not Found', 'jobboard' ); ?></h1>
	</div><!-- /.container -->
</div><!-- /#page-title -->

<div id="content" <?php post_class(); ?>>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
				<article class="not-found-page">
					<?php if ( !empty($img) ) : ?>
					<img src="<?php echo esc_url($img); ?>" class="img-responsive text-center" />
					<?php else: ?>
				  <h1 class="text-center"><i class="fa fa-frown-o fa-5x" aria-hidden="true" style="color:<?php echo $clr; ?>"></i></h1>
					<?php endif; ?>
          <h1 class="text-center" style="color:<?php echo $clr; ?>"><?php echo !empty($ttl) ? $ttl : 'Uups, Sorry!'; ?></h1>
          <p class="lead text-center">
						<?php echo !empty($cnt) ? $cnt : __( 'We can\'t seem to find the page you\'re looking for.<br> or you do not have access to this page.', 'jobboard' ); ?></p>
					<?php if ( $is_search != '0' ) : ?>
					<div class="text-center">
						<em><?php _e( 'try to searching something here', 'jobboard' ) ?></em>
						<?php get_search_form(); ?>
						<em class="not-found-or"><?php _e( 'or', 'jobboard' ); ?></em>
					</div>
					<?php endif; ?>
					<p class="text-center">
						<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo home_url('/'); ?>" class="btn btn-register"><i class="fa fa-home"></i> <?php _e('Go Home','jobboard') ?></a>
						<a href="<?php echo jobboard_get_permalink('dashboard'); ?>" class="btn btn-register"><i class="fa fa-tachometer"></i> <?php _e('Dashboard','jobboard') ?></a>
						<?php elseif ( $is_button != '0' ) : ?>
						<a href="<?php echo jobboard_get_permalink('register'); ?>" class="btn btn-register"><i class="fa fa-user"></i> <?php _e('Join Now','jobboard') ?></a>
						<br>
						<small><?php _e('Already member?','jobboard'); ?> <a href="<?php echo jobboard_get_permalink('login'); ?>"><?php _e('Login','jobboard') ?></a>.</small>
						<?php endif; ?>
					</p>
				</article>
			</div>
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /#content -->
<?php
get_footer();