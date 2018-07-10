<?php

/**
 * Template Name: Why choose Us Candidates
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
					<div class="title-step">1. Application Review</div>
					<p> We promise we review every application that we receive with respect and diligence.
						We evaluate your background and determine if it aligns with our current opportunities.</p>
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
					<div class="title-step">2. Interview</div>
					<p> If you are potential fit for one of our clients we will contact you to learn more about you. During an in-person interview we dig even deeper to get to know about your career path and goals.</p>
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
					<div class="title-step">3. Career Insight Report</div>
					<p> All our candidates undertake a free Workstyle &Performance Profile (WPP) to help us get to know your behaviour in the workplace and the kind of culture you would work well in.</p>
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
					<div class="title-step">4. Educate & Advise</div>
					<p> We are here to help you present your best self. We consult with you to improve your resume, prepare for interviews and negotiate your compensation. Consider us your coach.</p>
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
					<div class="title-step">5. Follow Up</div>
					<p> After a placement we don’t just walk away. We will follow up with you to ensure you are happy and that the new role supports your career aspirations.</p>
				</div>	
			</div>
		</div>

		<div class="clearfix"></div>

		<div id="action-FAQs">
			<h2>Never worked with a recruiter before and not sure what to expect?</h2>
			<a href="" class="btn btn-primary">FAQs</a>
		</div>

		<?php
			if( jobboard_option( 'enable_testimonial' ) ){
				get_template_part( 'template-parts/homepage', 'testimonials_alt' );
			}
		?>

		<div id="action-search">
			<div class="content">
				<h2 class="">Ready to land your dream job?</h2>
				<a href="" class="btn btn-primary">SEARCH JOBS</a>
			</div>
		</div>

		

	</div><!-- /.container -->
</div><!-- /#content -->
<?php
get_footer();