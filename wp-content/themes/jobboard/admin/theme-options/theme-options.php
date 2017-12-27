<?php
/**
 * Job Board Theme Options Panels.
 *
 * @package WordPress
 * @subpackage Job_Board
 * @since Job Board 1.0
 */
?><?php

if ( !function_exists( 'jobboard_homepage_settings_menu' ) ) :
function jobboard_homepage_settings_menu(){

return array(
    		'title'	=> __( 'Homepage Settings', 'jobboard' ),
    		'name'	=> 'homepage_settings',
    		'icon'	=> 'font-awesome:fa-home',
    		'menus'	=> array(

    			// Homepage Slider Settings
    			array(
    				'title'		=> __( 'Image Slider', 'jobboard' ),
    				'name'		=> 'homepage_slider_settings',
    				'icon'		=> 'font-awesome:fa-picture-o',
    				'controls'	=> array(
    					array(
							'type'		=> 'section',
							'title'		=> __( 'Homepage Slider', 'jobboard' ),
							'name'		=> 'homepage_slider',
							'fields'	=> array(
								array(
									'type'		=> 'toggle',
									'name'		=> 'enable_homepage_slider',
									'label'		=> __( 'Enable Homepage Slider', 'jobboard' ),
									'default'	=> '1',
								),
							),
						),

						array(
							'type'		=> 'section',
							'title'		=> __( 'Slider Settings', 'jobboard' ),
							'name'		=> 'slider_settings',
							'dependency'=> array(
								'field'		=> 'enable_homepage_slider',
								'function'	=> 'vp_dep_boolean',
							),
							'fields'	=> array(
								array(
									'type'			=> 'select',
									'name'			=> 'select_slider_options',
									'label'			=> __( 'Select Slider', 'jobboard' ),
									'validation'	=> 'required',
									'items'			=> array(
										array(
											'value'	=> 'jobboard_slider_default',
											'label'	=> __( 'Default Slider', 'jobboard' ),
										),
										array(
											'value'	=> 'jobboard_flexslider',
											'label'	=> __( 'Flexslider', 'jobboard' ),
										),
										array(
											'value'	=> 'jobboard_revslider',
											'label'	=> __( 'Revolution Slider', 'jobboard' ),
										),
									),
								),

								array(
									'type'		=> 'toggle',
									'name'		=> 'enable_slider_caption',
									'label'		=> __( 'Enable Slider Caption', 'jobboard' ),
									'default'	=> '1',
								),
							),
						),

						array(
							'type'		=> 'section',
							'title'		=> __( 'Slider Caption', 'jobboard' ),
							'name'		=> 'homepage_slider_caption',
							'dependency'=> array(
								'field'		=> 'enable_slider_caption',
								'function'	=> 'vp_dep_boolean',
							),
							'fields'	=> array(
								array(
									'type'		=> 'textbox',
									'name'		=> 'find_job_title',
									'label'		=> __( '"Find a Job" title', 'jobboard' ),
									'default'	=> __( 'Easiest way to find your dream job', 'jobboard' ),
									'validation'=> 'required',
								),
								array(
									'type'		=> 'textarea',
									'name'		=> 'find_job_desc',
									'label'		=> __( '"Find a Job" description', 'jobboard' ),
									'default'	=> __( 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'jobboard' ),
									'validation'=> 'required',
								),
								array(
									'type'		=> 'textbox',
									'name'		=> 'find_job_button',
									'label'		=> __( '"Find a Job" button', 'jobboard' ),
									'default'	=> __( 'Find a Job', 'jobboard' ),
									'validation'=> 'required',
								),
								array(
									'type'		=> 'textbox',
									'name'		=> 'find_job_button_url',
									'label'		=> __( '"Find a Job" button URL', 'jobboard' ),
									'validation'=> 'url',
								),

								array(
									'type'		=> 'textbox',
									'name'		=> 'post_job_title',
									'label'		=> __( '"Post a Job" title', 'jobboard' ),
									'default'	=> __( 'Hire Skilled People, best of them', 'jobboard' ),
									'validation'=> 'required',
								),
								array(
									'type'		=> 'textarea',
									'name'		=> 'post_job_desc',
									'label'		=> __( '"Post a Job" description', 'jobboard' ),
									'default'	=> __( 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'jobboard' ),
									'validation'=> 'required',
								),
								array(
									'type'		=> 'textbox',
									'name'		=> 'post_job_button',
									'label'		=> __( '"Post a Job" button', 'jobboard' ),
									'default'	=> __( 'Post a Job', 'jobboard' ),
									'validation'=> 'required',
								),
								array(
									'type'		=> 'textbox',
									'name'		=> 'post_job_button_url',
									'label'		=> __( '"Post a Job" button URL', 'jobboard' ),
									'validation'=> 'url',
								),
							),
						),
					),

    			),

    			// Search Form Settings
    			array(
    				'title'		=> __( 'Search Form', 'jobboard' ),
    				'name'		=> 'homepage_search_form_settings',
    				'icon'		=> 'font-awesome:fa-search',
    				'controls'	=> array(
    					array(
							'type'		=> 'section',
							'title'		=> __( 'Job Search Settings', 'jobboard' ),
							'name'		=> 'job_search_settings',
							'fields'	=> array(
								array(
									'type'	=> 'select',
									'name'	=> 'search_result_page',
									'label'	=> __( 'Job Search Result Page', 'jobboard' ),
									'items'	=> array(
										'data' => array(
											array(
												'source'	=> 'function',
												'value'  	=> 'jobboard_get_search_page',
											),
										),
									),
									'default'	=> '{{first}}'
								),
								array(
									'type'			=> 'textbox',
									'name'			=> 'keyword_placeholder',
									'label'			=> __( 'Keyword Placeholder', 'jobboard' ),
									'default'		=> __( 'Keywords (IT Engineer, Shop Manager, Hr Manager...)', 'jobboard' ),
									'description'	=> __( 'Enter your placeholder text for <strong>"Keyword"</strong> field on Job Search Form.', 'jobboard' ),
								),
								array(
									'type'			=> 'radiobutton',
									'name'			=> 'location_input_type',
									'label'			=> __( 'Location Input', 'jobboard' ),
									'description'	=> __( 'Select the "Location" field input type.', 'jobboard' ),
									'default'		=> 'input_text',
									'items'			=> array(
										array(
											'value'	=> 'input_text',
											'label'	=> __( 'Text Box', 'jobboard' ),
										),
										array(
											'value'	=> 'input_select',
											'label'	=> __( 'Select Box', 'jobboard' ),
										),
									),

								),
								array(
									'type'			=> 'textbox',
									'name'			=> 'location_placeholder',
									'label'			=> __( 'Location Placeholder', 'jobboard' ),
									'default'		=> __( 'New York, Hong Kong, New Delhi, Berlin etc.', 'jobboard' ),
									'description'	=> __( 'Enter your placeholder text for <strong>"Location"</strong> field on Job Search Form.', 'jobboard' ),
									'dependency'	=> array(
										'field'		=> 'location_input_type',
										'function'	=> 'jobboard_location_input_type',
									),
								),
								array(
									'type'			=> 'codeeditor',
									'name'			=> 'experience_parameters',
									'label'			=> __( 'Experience Numbers', 'jobboard' ),
									'description'	=> __( 'Enter the list number of experience to show on Job Search Form.', 'jobboard' ),
									'default'		=> "1;1\n2;2\n3;3\n4;4\n5;5\n6;6\n7;7\n8;8\n9;9\n10;10",
								),
								array(
									'type'			=> 'notebox',
									'name'			=> 'job_search_info',
									'label'			=> __( 'Information', 'jobboard' ),
									'description'	=> __( 'Each list number separated by new line, each number line contained value and text separated by comma. (see the default value for example)', 'jobboard' ),
									'status'		=> 'info',
								),
								array(
									'type'			=> 'codeeditor',
									'name'			=> 'salary_parameters',
									'label'			=> __( 'Salary Numbers', 'jobboard' ),
									'description'	=> __( 'Enter the list number of salary to show on Job Search Form.', 'jobboard' ),
									'default'		=> "10000;10K\n20000;20K\n50000;50K\n75000;75K\n100000;100K\n150000;150K\n200000;200K\n250000;250K\n300000;300K\n400000;400K\n500000;500K",
								),
								array(
									'type'		=> 'toggle',
									'name'		=> 'enable_advance_search',
									'label'		=> __( 'Enable Advanced Search', 'jobboard' ),
									'default'	=> '0',
								),
							),
						),

    					array(
							'type'		=> 'section',
							'title'		=> __( 'Resume Search Settings', 'jobboard' ),
							'name'		=> 'resume_search_settings',
							'fields'	=> array(
                                array(
									'type'	=> 'select',
									'name'	=> 'search_resume_page',
									'label'	=> __( 'Resume Search Result Page', 'jobboard' ),
									'items'	=> array(
										'data' => array(
											array(
												'source'	=> 'function',
												'value'  	=> 'jobboard_get_search_resume_page',
											),
										),
									),
									'default'	=> '{{first}}'
								),
								array(
									'type'			=> 'radiobutton',
									'name'			=> 'resume_location_input_type',
									'label'			=> __( 'Location Input', 'jobboard' ),
									'description'	=> __( 'Select the "Location" field input type.', 'jobboard' ),
									'default'		=> 'input_text',
									'items'			=> array(
										array(
											'value'	=> 'input_text',
											'label'	=> __( 'Text Box', 'jobboard' ),
										),
										array(
											'value'	=> 'input_select',
											'label'	=> __( 'Select Box', 'jobboard' ),
										),
									),

								),
								array(
									'type'			=> 'textbox',
									'name'			=> 'resume_location_placeholder',
									'label'			=> __( 'Location Placeholder', 'jobboard' ),
									'default'		=> __( 'New York, Los Angeles, Chicago, etc.', 'jobboard' ),
									'description'	=> __( 'Enter your placeholder text for <strong>"Location"</strong> field on Job Search Form.', 'jobboard' ),
									'dependency'	=> array(
										'field'		=> 'resume_location_input_type',
										'function'	=> 'jobboard_location_input_type',
									),
								),
							),
						),
    				),
    			),

                // Job Status Settings
    			array(
    				'title'		=> __( 'Recent Jobs', 'jobboard' ),
    				'name'		=> 'homepage_recent_job_settings',
    				'icon'		=> 'font-awesome:fa-briefcase',
    				'controls'	=> array(

						array(
							'type'		=> 'section',
							'name'		=> 'recent_job_settings',
							'title'		=> __( 'Recent Jobs Settings', 'jobboard' ),
							'fields'	=> array(
                                array(
									'type'		  => 'toggle',
									'name'		  => 'enable_recent_job',
									'label'		  => __( 'Enable Recent Jobs Section', 'jobboard' ),
                                    'description' => __('If disabled content section will show default latest blog post.', 'jobboard'),
									'default'	  => '1',
								),
                                array(
                                    'type'        => 'slider',
                                    'name'        => 'latest_job_per_page',
                                    'label'       => __( 'Job per Page', 'jobboard' ),
                                    'description' => __( 'Show list jobs per page on each tabs.', 'jobboard' ),
                                    'min'         => '2',
                                    'max'         => '20',
                                    'default'     => '6',
                                    'dependency'	=> array(
										'field'		=> 'enable_recent_job',
										'function'	=> 'vp_dep_boolean',
									),
                                ),
                                array(
                                    'type'        => 'multiselect',
                                    'name'        => 'recent_job_type_tab',
                                    'label'       => __( 'Recent Jobs Tab', 'jobboard' ),
                                    'description' => __( 'Select type of jobs that will be displayed as tabs.', 'jobboard' ),
                                    'validation'  => 'minselected[1]',
                                    'items'       => array(
                                      'data'	=> array(
                                          array(
                                              'source'	=> 'function',
                                              'value'	=> 'jobboard_get_type_job',
                                          ),
                                      ),
                                    ),
                                    'default'       => '{{all}}',
                                    'dependency'	=> array(
										'field'		=> 'enable_recent_job',
										'function'	=> 'vp_dep_boolean',
									),
                                ),

                              ),
                          ),
                      ),

                ),

    			// Job Status Settings
    			array(
    				'title'		=> __( 'Job Statistics', 'jobboard' ),
    				'name'		=> 'homepage_job_status_settings',
    				'icon'		=> 'font-awesome:fa-tasks',
    				'controls'	=> array(

						array(
							'type'		=> 'section',
							'name'		=> 'job_status_settings',
							'title'		=> __( 'Job Status Section Settings', 'jobboard' ),
							'fields'	=> array(
								array(
									'type'		=> 'toggle',
									'name'		=> 'enable_job_status',
									'label'		=> __( 'Enable Job Status Section', 'jobboard' ),
									'default'	=> '1',
								),
								array(
									'type'		=> 'textbox',
									'name'		=> 'job_status_title',
									'label'		=> __( 'Job Status Section Title', 'jobboard' ),
									'default'	=> __( 'Job Status Updates', 'jobboard' ),
									'validation'=> 'required',
									'dependency'=> array(
										'field'		=> 'enable_job_status',
										'function'	=> 'vp_dep_boolean',
									),
								),
								array(
									'type'			=> 'textarea',
									'name'			=> 'job_status_description',
									'label'			=> __( 'Job Status Section Description', 'jobboard' ),
									'dependency'	=> array(
										'field'		=> 'enable_job_status',
										'function'	=> 'vp_dep_boolean',
									),
								),

							),
						),

    				),
    			),

    			// Job Search Steps
    			array(
    				'title'		=> __( 'How To Find Job', 'jobboard' ),
    				'name'		=> 'homepage_how_to_find',
    				'icon'		=> 'font-awesome:fa-question',
    				'controls'	=> array(
    					array(
    						'type'		=> 'section',
    						'name'		=> 'how_to_find_job',
    						'title'		=> __( 'How to Find Job Settings', 'jobboard' ),
    						'fields'	=> array(
    							array(
									'type'		=> 'toggle',
									'name'		=> 'enable_job_steps',
									'label'		=> __( 'Enable "How To Find Job" section', 'jobboard' ),
									'default'	=> '1',
								),

								array(
									'type'			=> 'textbox',
									'name'			=> 'job_steps_title',
									'label'			=> __( 'Section Title', 'jobboard' ),
									'default'		=> __( 'Easiest Way to Use', 'jobboard' ),
									'validation'	=> 'required',

									'dependency'	=> array(
										'field'		=> 'enable_job_steps',
										'function'	=> 'vp_dep_boolean',
									),
								),

								array(
									'type'			=> 'textarea',
									'name'			=> 'job_steps_description',
									'label'			=> __( 'Section Description', 'jobboard' ),

									'dependency'	=> array(
										'field'		=> 'enable_job_steps',
										'function'	=> 'vp_dep_boolean',
									),
								),
    						),
    					),
    					array(
    						'type'		=> 'section',
    						'name'		=> 'how_to_1',
    						'title'		=> __( 'Step 1', 'jobboard' ),
    						'fields'	=> array(
    							array(
    								'name'		=> 'step_1_label',
    								'type'		=> 'textbox',
    								'label'		=> __( 'Step 1 Label', 'jobboard' ),
    								'default'	=> __( 'First Step', 'jobboard' ),
    							),
    							array(
    								'name'			=> 'step_1_image',
    								'type'			=> 'upload',
    								'label'			=> __( 'Step 1 Image', 'jobboard' ),
    								'description'	=> __( 'Recommended image size are 70px of width and 90px of height.', 'jobboard' ),
    							),
    							array(
    								'name'		=> 'step_1_title',
    								'type'		=> 'textbox',
    								'label'		=> __( 'Step 1 Title', 'jobboard' ),
    								'default'	=> __( 'Register with Us', 'jobboard' ),
    							),
    						),
    						'dependency'	=> array(
								'field'		=> 'enable_job_steps',
								'function'	=> 'vp_dep_boolean',
							),
    					),
    					array(
    						'type'		=> 'section',
    						'name'		=> 'how_to_2',
    						'title'		=> __( 'Step 2', 'jobboard' ),
    						'fields'	=> array(
    							array(
    								'name'		=> 'step_2_label',
    								'type'		=> 'textbox',
    								'label'		=> __( 'Step 2 Label', 'jobboard' ),
    								'default'	=> __( 'Second Step', 'jobboard' ),
    							),
    							array(
    								'name'			=> 'step_2_image',
    								'type'			=> 'upload',
    								'label'			=> __( 'Step 2 Image', 'jobboard' ),
    								'description'	=> __( 'Recommended image size are 70px of width and 90px of height.', 'jobboard' ),
    							),
    							array(
    								'name'		=> 'step_2_title',
    								'type'		=> 'textbox',
    								'label'		=> __( 'Step 2 Title', 'jobboard' ),
    								'default'	=> __( 'Create Your Profile', 'jobboard' ),
    							),
    						),
    						'dependency'	=> array(
								'field'		=> 'enable_job_steps',
								'function'	=> 'vp_dep_boolean',
							),
    					),
    					array(
    						'type'		=> 'section',
    						'name'		=> 'how_to_3',
    						'title'		=> __( 'Step 3', 'jobboard' ),
    						'fields'	=> array(
    							array(
    								'name'		=> 'step_3_label',
    								'type'		=> 'textbox',
    								'label'		=> __( 'Step 3 Label', 'jobboard' ),
    								'default'	=> __( 'Third Step', 'jobboard' ),
    							),
    							array(
    								'name'			=> 'step_3_image',
    								'type'			=> 'upload',
    								'label'			=> __( 'Step 3 Image', 'jobboard' ),
    								'description'	=> __( 'Recommended image size are 70px of width and 90px of height.', 'jobboard' ),
    							),
    							array(
    								'name'		=> 'step_3_title',
    								'type'		=> 'textbox',
    								'label'		=> __( 'Step 3 Title', 'jobboard' ),
    								'default'	=> __( 'Upload your resume', 'jobboard' ),
    							),
    						),
    						'dependency'	=> array(
								'field'		=> 'enable_job_steps',
								'function'	=> 'vp_dep_boolean',
							),
    					),
    					array(
    						'type'		=> 'section',
    						'name'		=> 'how_to_4',
    						'title'		=> __( 'Step 4', 'jobboard' ),
    						'fields'	=> array(
    							array(
    								'name'		=> 'step_4_label',
    								'type'		=> 'textbox',
    								'label'		=> __( 'Step 4 Label', 'jobboard' ),
    								'default'	=> __( 'Now It\'s Our Turn', 'jobboard' ),
    							),
    							array(
    								'name'			=> 'step_4_image',
    								'type'			=> 'upload',
    								'label'			=> __( 'Step 4 Image', 'jobboard' ),
    								'description'	=> __( 'Recommended image size are 70px of width and 90px of height.', 'jobboard' ),
    							),
    							array(
    								'name'		=> 'step_4_title',
    								'type'		=> 'textbox',
    								'label'		=> __( 'Step 4 Title', 'jobboard' ),
    								'default'	=> __( 'Now take a rest', 'jobboard' ),
    							),
    						),
    						'dependency'	=> array(
								'field'		=> 'enable_job_steps',
								'function'	=> 'vp_dep_boolean',
							),
    					),
    				),
    			),

    			// Testimonial Section
    			array(
    				'title'		=> __( 'Testimonial', 'jobboard' ),
    				'name'		=> 'homepage_testimonial',
    				'icon'		=> 'font-awesome:fa-comment',
    				'controls'	=> array(
    					array(
    						'type'		=> 'toggle',
    						'name'		=> 'enable_testimonial',
    						'label'		=> __( 'Enable Testimonial section', 'jobboard' ),
    						'default'	=> '1',
    					),

    					array(
    						'type'			=> 'textbox',
    						'name'			=> 'testimonial_title',
    						'label'			=> __( 'Testimonial Section Title', 'jobboard' ),
    						'default'		=> __( 'What People Say About Us', 'jobboard' ),
    						'validation'	=> 'required',

    						'dependency'	=> array(
    							'field'		=> 'enable_testimonial',
    							'function'	=> 'vp_dep_boolean',
    						),
    					),

    					array(
    						'type'			=> 'textarea',
    						'name'			=> 'testimonial_description',
    						'label'			=> __( 'Testimonial Section Description', 'jobboard' ),

    						'dependency'	=> array(
    							'field'		=> 'enable_testimonial',
    							'function'	=> 'vp_dep_boolean',
    						),
    					),
    				),
    			),

    			// Company Carousel
    			array(
    				'title'		=> __( 'Companies', 'jobboard' ),
    				'name'		=> 'homepage_company',
    				'icon'		=> 'font-awesome:fa-group',
    				'controls'	=> array(
    					array(
    						'type'		=> 'toggle',
    						'name'		=> 'enable_company',
    						'label'		=> __( 'Enable Companies section', 'jobboard' ),
    						'default'	=> '1',
    					),
    					array(
    						'type'			=> 'select',
    						'name'			=> 'company_slider',
    						'label'			=> __( 'Select Image Slider', 'jobboard' ),
    						'description'	=> __( 'Select image slider from Slider Post Type.', 'jobboard' ),
    						'validation'	=> 'required',
							'items'			=> array(
								'data'	=> array(
									array(
										'source'	=> 'function',
										'value'		=> 'jobboard_get_sliders',
									),
								),
							),
							'default'	=> '{{first}}',

							'dependency'	=> array(
    							'field'		=> 'enable_company',
    							'function'	=> 'vp_dep_boolean',
    						),
    					),
    					array(
    						'type'			=> 'textbox',
    						'name'			=> 'company_title',
    						'label'			=> __( 'Companies Section Title', 'jobboard' ),
    						'default'		=> __( 'Companies who have posted jobs', 'jobboard' ),
    						'validation'	=> 'required',

    						'dependency'	=> array(
    							'field'		=> 'enable_company',
    							'function'	=> 'vp_dep_boolean',
    						),
    					),

    					array(
    						'type'			=> 'textarea',
    						'name'			=> 'company_description',
    						'label'			=> __( 'Company Section Description', 'jobboard' ),

    						'dependency'	=> array(
    							'field'		=> 'enable_company',
    							'function'	=> 'vp_dep_boolean',
    						),
    					),
    				),
    			),

    		),
    	);


}
endif; //jobboard_homepage_settings_menu


/** ============= End of style 1 ================== **/


if ( !function_exists( 'jobboard_homepage_settings_menu2' ) ) :
function jobboard_homepage_settings_menu2(){

return array(
    		'title'	=> __( 'Homepage Settings', 'jobboard' ),
    		'name'	=> 'homepage_settings',
    		'icon'	=> 'font-awesome:fa-home',
    		'menus'	=> array(

    			// Company Carousel
    			array(
    				'title'		=> __( 'Companies', 'jobboard' ),
    				'name'		=> 'homepage_company',
    				'icon'		=> 'font-awesome:fa-group',
    				'controls'	=> array(
    					array(
    						'type'		=> 'toggle',
    						'name'		=> 'enable_company',
    						'label'		=> __( 'Enable Companies section', 'jobboard' ),
    						'default'	=> '1',
    					),
    					array(
    						'type'			=> 'select',
    						'name'			=> 'company_slider',
    						'label'			=> __( 'Select Image Slider', 'jobboard' ),
    						'description'	=> __( 'Select image slider from Slider Post Type.', 'jobboard' ),
    						'validation'	=> 'required',
							'items'			=> array(
								'data'	=> array(
									array(
										'source'	=> 'function',
										'value'		=> 'jobboard_get_sliders',
									),
								),
							),
							'default'	=> '{{first}}',

							'dependency'	=> array(
    							'field'		=> 'enable_company',
    							'function'	=> 'vp_dep_boolean',
    						),
    					),
    					array(
    						'type'			=> 'textbox',
    						'name'			=> 'company_title',
    						'label'			=> __( 'Companies Section Title', 'jobboard' ),
    						'default'		=> __( 'Companies who have posted jobs', 'jobboard' ),
    						'validation'	=> 'required',

    						'dependency'	=> array(
    							'field'		=> 'enable_company',
    							'function'	=> 'vp_dep_boolean',
    						),
    					),

    					array(
    						'type'			=> 'textarea',
    						'name'			=> 'company_description',
    						'label'			=> __( 'Company Section Description', 'jobboard' ),

    						'dependency'	=> array(
    							'field'		=> 'enable_company',
    							'function'	=> 'vp_dep_boolean',
    						),
    					),
    				),
    			),

    		),
    	);


}
endif; //jobboard_homepage_settings_menu2

/** ============= End of style 2 ================== **/


// $layout = jobboard_minimalthemes_layout();

$minimalthemes_settings = get_option('minimalthemes_setting');
$layout = $minimalthemes_settings['layout'];


if($layout == 'graduatee'){
	// $homepage_settings = jobboard_homepage_settings_menu2();
  $homepage_settings = jobboard_homepage_settings_menu();
} else {
	$homepage_settings = jobboard_homepage_settings_menu();
}

include_once( 'opt-slider_options.php' );
include_once( 'opt-layout_settings.php' );
include_once( 'opt-job_settings.php' );
include_once( 'opt-styling_settings.php' );
include_once( 'opt-frontend_submission_settings.php' );
include_once( 'opt-contact_settings.php' );

$_menus = apply_filters( 'jboard_theme_options-menus',
    array(
        $homepage_settings,
        $slider_options,
        $layout_settings,
        $job_settings,
        $styling_settings,
        $frontend_submission_settings,
        $contact_settings,
    )
);

return array(
	'title'	=> __('Job Board Options Panel', 'jobboard'),
    'logo'	=> get_template_directory_uri().'/assets/images/theme-options-logo.png',
    'menus'	=> $_menus,
);
