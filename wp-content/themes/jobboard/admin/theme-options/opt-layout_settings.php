<?php

// Layout Settings Menu

$layout_settings = apply_filters( 'jboard_theme_options-layout_settings',
    array(
        'title'	=> __('Layout Settings', 'jobboard'),
        'name'	=> 'layout_settings',
        'icon'	=> 'font-awesome:fa-columns',
        'menus'	=> array(
            // Header Layout Settings
            array(
                'title'		=> __( 'Header', 'jobboard' ),
                'name'		=> 'layout_settings_header',
                'icon'		=> 'font-awesome:fa-gear',
                'controls'	=> array(
                    array(
                        'type'		=> 'section',
                        'name'		=> 'main_header_section',
                        'title'		=> __( 'Main Header', 'jobboard' ),
                        'fields'	=> array(
                            array(
                                'type'	=> 'upload',
                                'name'	=> 'custom_header_logo',
                                'label'	=> __( 'Custom Header Logo', 'jobboard' ),
                            ),
                        ),
                    ),

                    array(
                        'type'	=> 'section',
                        'name'	=> 'top_header_section',
                        'title'	=> __( 'Top Header', 'jobboard' ),
                        'fields'=> array(
                            array(
                                'type'	=> 'toggle',
                                'name'	=> 'enable_admin_menu',
                                'label'	=> __( 'Enable Dashboard Menu', 'jobboard' ),
                                'description'	=> __( 'Enable dashboard administration menu on header.', 'jobboard' ),
                            ),

                            array(
                                'type'	=> 'toggle',
                                'name'	=> 'enable_social_media_url',
                                'label'	=> __( 'Enable Social Media URL', 'jobboard' ),
                                'description'	=> __( 'Enable social media URL on top header.', 'jobboard' ),
                            ),

                            array(
                                'type'	=> 'sorter',
                                'name'	=> 'social_media_sorter',
                                'label'	=> __( 'Social Media Items', 'jobboard' ),
                                'description'	=> __( 'Choose the social media icon that you want to show.', 'jobboard' ),

                                'dependency'	=> array(
                                    'field' 	=> 'enable_social_media_url',
                                    'function' 	=> 'vp_dep_boolean',
                                ),

                                'validation'=> 'minselected[1]',
                                'items'	=> array(
                                    'data'	=> array(
                                        array(
                                            'source'=> 'function',
                                            'value'	=> 'jobboard_get_social_medias',
                                        ),
                                    ),
                                ),
                            ),
                        ),

                    ),
                ),
            ),

            // Footer Layout Settings
            array(
                'title'		=> __( 'Footer', 'jobboard' ),
                'name'		=> 'layout_settings_footer',
                'icon'		=> 'font-awesome:fa-gear',
                'controls'	=> array(
                    array(
                        'type'			=> 'section',
                        'title'			=> __( 'Footer Contact Banner', 'jobboard' ),
                        'name'			=> 'footer_contact_banner',
                        'fields'		=> array(
                            array(
                                'type'			=> 'toggle',
                                'name'			=> 'enable_footer_contact_banner',
                                'label'			=> __( 'Enable Footer Contact Banner', 'jobboard' ),
                            ),

                            array(
                                'type'		=> 'textbox',
                                'name'		=> 'footer_contact_title',
                                'label'		=> __( 'Footer Contact Title', 'jobboard' ),
                                'default'	=> __( 'Hey Friends Any Queries?', 'jobboard' ),
                                'dependency'	=> array(
                                    'field'		=> 'enable_footer_contact_banner',
                                    'function'	=> 'vp_dep_boolean',
                                ),
                            ),
                            array(
                                'type'		=> 'textarea',
                                'name'		=> 'footer_contact_description',
                                'label'		=> __( 'Footer Contact Description', 'jobboard' ),
                                'default'	=> ' At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt',
                                'dependency'	=> array(
                                    'field'		=> 'enable_footer_contact_banner',
                                    'function'	=> 'vp_dep_boolean',
                                ),
                            ),
                            array(
                                'type'		=> 'textbox',
                                'name'		=> 'footer_contact_number',
                                'label'		=> __( 'Footer Contact Number', 'jobboard' ),
                                'default'	=> 'Call: 1 800 000 500',
                                'dependency'	=> array(
                                    'field'		=> 'enable_footer_contact_banner',
                                    'function'	=> 'vp_dep_boolean',
                                ),
                            ),
                        ),
                    ),
                    array(
                        'type'			=> 'section',
                        'title'			=> __( 'Footer Widgets', 'jobboard' ),
                        'name'			=> 'footer_widget_settings',
                        'description'	=> __( 'Footer widget settings', 'jobboard' ),
                        'fields'		=> array(
                            array(
                                'type'				=> 'radioimage',
                                'name'				=> 'footer_widget_area',
                                'label'				=> __( 'Footer Widget Areas', 'jobboard' ),
                                'description'		=> '',
                                'item_max_width'	=> '45',
                                'item_max_height'	=> '45',
                                'default'			=> '4',
                                'items'				=> array(
                                    array(
                                        'value'	=> '0',
                                        'label'	=> __('Footer Widget Off', 'jobboard'),
                                        'img'	=> get_template_directory_uri().'/assets/images/layout-off.png',
                                    ),
                                    array(
                                        'value'	=> '1',
                                        'label'	=> __('One Column', 'jobboard'),
                                        'img'	=> get_template_directory_uri().'/assets/images/footer-widgets-1.png',
                                    ),
                                    array(
                                        'value'	=> '2',
                                        'label'	=> __('Two Columns', 'jobboard'),
                                        'img'	=> get_template_directory_uri().'/assets/images/footer-widgets-2.png',
                                    ),
                                    array(
                                        'value'	=> '3',
                                        'label'	=> __('Three Columns', 'jobboard'),
                                        'img'	=> get_template_directory_uri().'/assets/images/footer-widgets-3.png',
                                    ),
                                    array(
                                        'value'	=> '4',
                                        'label'	=> __('Four Columns', 'jobboard'),
                                        'img'	=> get_template_directory_uri().'/assets/images/footer-widgets-4.png',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'type'		=> 'section',
                        'title'		=> __( 'Footer Widget Column Width', 'jobboard' ),
                        'name'		=> 'footer_widget_column_width',
                        'dependency'=> array(
                            'field' 	=> 'footer_widget_area',
                            'function' 	=> 'vp_dep_boolean',
                        ),

                        'fields'	=> array(
                            array(
                                'type'	=> 'slider',
                                'name'	=> 'footer_column_width_1',
                                'label'	=> __( 'First Column Width', 'jobboard' ),
                                'min'	=> '2',
                                'max'	=> '10',
                                'steps'	=> '1',
                            ),
                            array(
                                'type'	=> 'slider',
                                'name'	=> 'footer_column_width_2',
                                'label'	=> __( 'Second Column Width', 'jobboard' ),
                                'min'	=> '2',
                                'max'	=> '10',
                                'steps'	=> '1',
                                'dependency' => array(
                                    'field'		=> 'footer_widget_area',
                                    'function'	=> 'jobboard_footer_widget1',
                                ),
                            ),
                            array(
                                'type'	=> 'slider',
                                'name'	=> 'footer_column_width_3',
                                'label'	=> __( 'Third Column Width', 'jobboard' ),
                                'min'	=> '2',
                                'max'	=> '10',
                                'steps'	=> '1',
                                'dependency' => array(
                                    'field'		=> 'footer_widget_area',
                                    'function'	=> 'jobboard_footer_widget2',
                                ),
                            ),
                            array(
                                'type'	=> 'slider',
                                'name'	=> 'footer_column_width_4',
                                'label'	=> __( 'Fourth Column Width', 'jobboard' ),
                                'min'	=> '2',
                                'max'	=> '10',
                                'steps'	=> '1',
                                'dependency' => array(
                                    'field'		=> 'footer_widget_area',
                                    'function'	=> 'jobboard_footer_widget3',
                                ),
                            ),
                        ),
                    ),

                    array(
                        'type'		=> 'section',
                        'title'		=> __( 'Custom Footer', 'jobboard' ),
                        'name'		=> 'custom_footer_settings',
                        'fields'	=> array(
                            array(
                                'type'			=> 'toggle',
                                'name'			=> 'enable_custom_footer',
                                'label'			=> __( 'Enable Custom Footer', 'jobboard' ),
                                'description'	=> __( 'Activate to add the custom text below to the theme footer.', 'jobboard' ),
                            ),
                            array(
                                'type'			=> 'textarea',
                                'name'			=> 'custom_footer_text',
                                'label'			=> __( 'Custom Footer Text', 'jobboard' ),
                                'description'	=> __( 'Custom HTML and Text that will appear in the footer of your theme.', 'jobboard' ),
                                'dependency'	=> array(
                                    'field' 	=> 'enable_custom_footer',
                                    'function' 	=> 'vp_dep_boolean',
                                ),
                            ),
                        ),
                    ),

                ),
            ),

					array(
						'title'		=> __( '404 Page', 'jobboard' ),
						'name'		=> 'layout_settings_404',
						'icon'		=> 'font-awesome:fa-gear',
						'controls'	=> array(
							array(
								'type'		=> 'section',
								'name'		=> 'notfound_header_section',
								'title'		=> __( '404 Page Content', 'jobboard' ),
								'fields'	=> array(
									array(
										'type'	=> 'upload',
										'name'	=> 'notfound_image',
										'label'	=> __( 'Page not found image', 'jobboard' ),
									),
									array(
										'type'	=> 'textbox',
										'name'	=> 'notfound_title',
										'default'	=> 'Uuups, Sorry!',
										'label'	=> __( 'Page Title', 'jobboard' ),
									),
									array(
										'type'	=> 'textarea',
										'name'	=> 'notfound_content',
										'default'	=> __( 'We can\'t seem to find the page you\'re looking for. Or you dont have access to this page.<br>or you do not have access to this page.', 'jobboard' ),
										'label'	=> __( 'Page Content', 'jobboard' ),
									),
									array(
										'type'		=> 'color',
										'name'		=> 'notfound_title_color',
										'label'		=> __( 'Title Color', 'jobboard' ),
										'default'	=> '#b22222'
									)
								),
							),
							array(
								'type'		=> 'section',
								'name'		=> 'notfound_opt_section',
								'title'		=> __( '404 Page Options', 'jobboard' ),
								'fields'	=> array(
									array(
										'type'			=> 'toggle',
										'name'			=> 'enable_notfound_searchform',
										'default'		=> '1',
										'label'			=> __( 'Show Search Form', 'jobboard' ),
										'description'	=> __( 'Activate to show search form on 404 page.', 'jobboard' ),
									),
									array(
										'type'			=> 'toggle',
										'name'			=> 'enable_notfound_buttons',
										'default'		=> '1',
										'label'			=> __( 'Show Buttons', 'jobboard' ),
										'description'	=> __( 'Activate to show join or login on 404 page.', 'jobboard' ),
									)
								)
							)
						)
					)
        ),
    )
);
