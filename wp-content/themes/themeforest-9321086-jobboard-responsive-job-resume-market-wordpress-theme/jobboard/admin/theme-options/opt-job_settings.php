<?php

// Job Settings Menu
$job_settings = apply_filters( 'jboard_theme_options-job_settings',
    array(
        'title'		=> __( 'Job Settings', 'jobboard' ),
        'name'		=> 'job_settings',
        'icon'		=> 'font-awesome:fa-briefcase',
        'controls'	=> array(
            array(
                'type'		=> 'section',
                'title'		=> __( 'Price Format', 'jobboard' ),
                'name'		=> 'price_format',
                'fields'	=> array(
                    array(
                        'type'			=> 'textbox',
                        'name'			=> 'currency_sign',
                        'label'			=> __( 'Currency Sign', 'jobboard' ),
                        'description'	=> __( 'Provide currency sign. For example : "$"', 'jobboard' ),
                        'default'		=> '$',
                    ),
                    array(
                        'type'			=> 'select',
                        'name'			=> 'currency_position',
                        'label'			=> __( 'Currency Sign Position', 'jobboard' ),
                        'description'	=> __( 'Currency sign position. Before or after the nominal.', 'jobboard' ),
                        'default'		=> 'before_nominal',
                        'items'			=> array(
                            array(
                                'value'	=> 'before_nominal',
                                'label'	=> __( 'Before Nominal', 'jobboard' ),
                            ),
                            array(
                                'value'	=> 'after_nominal',
                                'label'	=> __( 'After Nominal', 'jobboard' ),
                            ),
                        ),
                    ),
                    array(
                        'type'			=> 'textbox',
                        'name'			=> 'decimal_point_numbers',
                        'label'			=> __( 'Number of Decimal Points', 'jobboard' ),
                        'description'	=> __( 'Provide the number of decimal points', 'jobboard' ),
                        'default'		=> '0',
                        'validation'	=> 'numeric',
                    ),
                    array(
                        'type'			=> 'textbox',
                        'name'			=> 'decimal_point_separator',
                        'label'			=> __( 'Decimal Point Separator', 'jobboard' ),
                        'description'	=> __( 'Provide the decimal point separator', 'jobboard' ),
                        'default'		=> '.',
                    ),
                    array(
                        'type'			=> 'textbox',
                        'name'			=> 'thousands_separator',
                        'label'			=> __( 'Thousands Separator', 'jobboard' ),
                        'description'	=> __( 'Provide the thousands separator', 'jobboard' ),
                        'default'		=> ',',
                    ),
                ),
            ),

            array(
                'type'		=> 'section',
                'title'		=> __( 'Job Detail Page', 'jobboard' ),
                'name'		=> 'job_detail_page_settings',
                'fields'	=> array(
                    array(
                        'type'		=> 'toggle',
                        'name'		=> 'enable_related_job',
                        'label'		=> __( 'Enable Related Job', 'jobboard' ),
                        'description'	=> __( 'Enable related job section in Job Detail page.', 'jobboard' ),
                    ),
                    array(
                        'type'		=> 'toggle',
                        'name'		=> 'enable_upload_job_button',
                        'label'		=> __( 'Enable Upload Job/Resume Button', 'jobboard' ),
                    ),
                ),
            ),

            // Section 1 Upload Job/Resume
            array(
                'type'		=> 'section',
                'title'		=> __( 'Section 1', 'jobboard' ),
                'name'		=> 'section_1_upload',
                'dependency'=> array(
                    'field'		=> 'enable_upload_job_button',
                    'function'	=> 'vp_dep_boolean',
                ),
                'fields'	=> array(
                    array(
                        'type'		=> 'textbox',
                        'name'		=> 'post_1_title',
                        'label'		=> __( 'Section Title', 'jobboard' ),
                        'default'	=> 'Upload Your Resume',
                    ),
                    array(
                        'type'		=> 'textarea',
                        'name'		=> 'post_1_description',
                        'label'		=> __( 'Section Description', 'jobboard' ),
                        'default'	=> 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias',
                    ),
                    array(
                        'type'		=> 'textbox',
                        'name'		=> 'post_1_button_text',
                        'label'		=> __( 'Section 1 Button Text', 'jobboard' ),
                        'default'	=> 'Upload Your Resume',
                    ),
                    array(
                        'type'		=> 'fontawesome',
                        'name'		=> 'post_1_button_icon',
                        'label'		=> __( 'Section Button Icon', 'jobboard' ),
                        'default'	=> 'fa-upload',
                    ),
                    array(
                        'type'		=> 'color',
                        'name'		=> 'post_1_button_color',
                        'label'		=> __( 'Section Button Color', 'jobboard' ),
                        'default'	=> '#565656',
                    ),
                    array(
                        'type'		=> 'color',
                        'name'		=> 'post_1_button_text_color',
                        'label'		=> __( 'Section Button Text Color', 'jobboard' ),
                        'default'	=> '#FFFFFF',
                    ),
                    array(
                        'type'		=> 'textbox',
                        'name'		=> 'post_1_button_url',
                        'label'		=> __( 'Section Button URL', 'jobboard' ),
                        'validation'=> 'url',
                    ),
                ),
            ),

            // Section 2 Upload Job/Resume
            array(
                'type'		=> 'section',
                'title'		=> __( 'Section 2', 'jobboard' ),
                'name'		=> 'section_2_upload',
                'dependency'=> array(
                    'field'		=> 'enable_upload_job_button',
                    'function'	=> 'vp_dep_boolean',
                ),
                'fields'	=> array(
                    array(
                        'type'		=> 'textbox',
                        'name'		=> 'post_2_title',
                        'label'		=> __( 'Section Title', 'jobboard' ),
                        'default'	=> 'Post Job Now',
                    ),
                    array(
                        'type'		=> 'textarea',
                        'name'		=> 'post_2_description',
                        'label'		=> __( 'Section Description', 'jobboard' ),
                        'default'	=> 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias',
                    ),
                    array(
                        'type'		=> 'textbox',
                        'name'		=> 'post_2_button_text',
                        'label'		=> __( 'Section 1 Button Text', 'jobboard' ),
                        'default'	=> 'Post A Job Now',
                    ),
                    array(
                        'type'		=> 'fontawesome',
                        'name'		=> 'post_2_button_icon',
                        'label'		=> __( 'Section Button Icon', 'jobboard' ),
                    ),
                    array(
                        'type'		=> 'color',
                        'name'		=> 'post_2_button_color',
                        'label'		=> __( 'Section Button Color', 'jobboard' ),
                        'default'	=> '#1abc9c',
                    ),
                    array(
                        'type'		=> 'color',
                        'name'		=> 'post_2_button_text_color',
                        'label'		=> __( 'Section Button Text Color', 'jobboard' ),
                        'default'	=> '#FFFFFF',
                    ),
                    array(
                        'type'		=> 'textbox',
                        'name'		=> 'post_2_button_url',
                        'label'		=> __( 'Section Button URL', 'jobboard' ),
                        'validation'=> 'url',
                    ),
                ),
            ),
        ),
    )
);
