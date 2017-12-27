<?php
/**
 * Template Part Name : Homepage Blog
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
					<h3><i class="fa fa-file"></i><?php _e( 'Latest Blogs', 'jobboard' ); ?></h3>
				</div>

                <?php
                    global $more;
                    $posts = new WP_Query( array('post_type' => 'post','posts_per_page' => 8) );
                    if( $posts->have_posts() ){
                        while( $posts->have_posts() ){
                            $posts->the_post();
                            $more = 0;
                        ?>
                           <div class="job-listing-row">
                             <div class="job-company-logo">
                               <?php if( has_post_thumbnail() ) the_post_thumbnail( 'jobboard-company-logo-thumbnail' ); ?>
                             </div>
                             <div class="job-listing-name">
                               <h4><a href="<?php esc_url(the_permalink()) ?>"><?php the_title(); ?></a></h4>
                               <p class="job-listing-summary">
                                 <i class="fa fa-pencil"></i>&nbsp;<?php echo esc_attr( get_the_author_meta( 'display_name' ) ); ?>&nbsp;
                                 <i class="fa fa-calendar"></i>&nbsp;<?php echo get_the_date( get_option('date-format') );  ?>
                               </p>
                            </div>
                            <div class="job-listing-type">
                                <i class="fa fa-comment"></i>&nbsp;<?php comments_number( '0', '1', '%' ) ?>&nbsp;<?php _e( 'Comments', 'jobboard' ); ?>&nbsp;&nbsp;
                                <i class="fa fa-sign-in"></i>&nbsp;
                                <a href="<?php esc_url(the_permalink()) ?>" title="<?php _e( 'Read more...', 'jobboard' ); ?>"><?php _e( 'Read more...', 'jobboard' ); ?></a>
                            </div>
                           </div>
                        <?php
                        }//endwhile;

                        wp_reset_postdata();
                    }//endif;
                ?>
          </div><!-- .col-lg-8 -->

          <?php get_sidebar('home'); ?>
      </div>
  </div>
</div><!-- #jobs-listing -->
