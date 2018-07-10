<?php

/**
 * Template Name: Why choose Us Empoloyers
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
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
		<div id="find-step">
			<div class="step-1 card">
				<div class="head-step">
					<div class="circular-bar only-icon">
						<div id="circular-bar-chart" data-percent="100" data-plugin-options="{'barColor': '#0088CC'}">
							<i class="fa fa-search"></i>
						</div>
					</div>
				</div>
				<div class="content-step">
					<div class="title-step">1. Define Search</div>
					<p> We meet with you to conduct an in-depth needs assessment. We get to know your team and culture so we can scope out the 'ideal candidate.'</p>
				</div>
			</div>
			<div class="step-2 card">
				<div class="head-step">
					<div class="circular-bar only-icon">
						<div id="circular-bar-chart">
							<i class="fa fa-thumbs-o-up"></i>
						</div>
					</div>
				</div>
				<div class="content-step">
					<div class="title-step">2. Source & Qualify</div>
					<p> We search far and wide to find you the best talent. We meet with every potential candidate to ensure they have the skills required and will fit your culture.</p>
				</div>
			</div>
			<div class="step-3 card">
				<div class="head-step">
					<div class="circular-bar only-icon">
						<div id="circular-bar-chart">
							<i class="fa fa-comments-o"></i>
						</div>
					</div>
				</div>
				<div class="content-step">
					<div class="title-step">3. Client Interviews</div>
					<p> We present a shortlist of the top candidates and support the scheduling of interviews. We communicate with you through each step of the process.</p>
				</div>
			</div>
			<div class="step-4 card">
				<div class="head-step">
					<div class="circular-bar only-icon">
						<div id="circular-bar-chart">
							<i class="fa fa-check-square-o"></i>
						</div>
					</div>
				</div>
				<div class="content-step">
					<div class="title-step">4. Select</div>
					<p> We consult with you to evaluate the finalists and select a candidate. We are here to help you negotiate and secure an accepted offer.</p>
				</div>
			</div>
			<div class="step-5 card">
				<div class="head-step">
					<div class="circular-bar only-icon">
						<div id="circular-bar-chart">
							<i class="fa fa-cogs"></i>
						</div>
					</div>
				</div>
				<div class="content-step">
					<div class="title-step">5. Onboard</div>
					<p> Our service doesn’t end when we find you the right person. We support the onboarding of a new hire and always check in to ensure you are happy.</p>
				</div>	
			</div>
		</div>

		<div class="clearfix"></div>
		
		<div id="action-search">
			<div class="content">
				<h2 class="">Get started on your talent search today</h2>
				<a href="" class="btn btn-primary">CONNECT NOW</a>
			</div>
		</div>

		<?php
				if( jobboard_option('enable_testimonial') ){
					get_template_part( 'template-parts/homepage', 'testimonials' );
				}//endif;
		?>
	

	</div><!-- /.container -->
</div><!-- /#content -->
<?php
get_footer();