<?php

/**
 * Template Name: Recruitment Consultant
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
	<div class="row team">
		<div class="container">
			<article id="page-<?php the_ID(); ?>">
					<?php
						while( have_posts() ){
							the_post();

							the_content();

						}//endwhile;
					?>
			</article>
			<?php
				if( jobboard_option('enable_testimonial') ){
					get_template_part( 'template-parts/homepage', 'testimonials' );
				}//endif;
			?>
		</div><!-- /.container -->
	</div>
</div><!-- /#content -->

<?php
get_footer();