<?php

// Frontend Submission Settings Menu

$frontend_submission_settings = apply_filters( 'jboard_theme_options-frontend_submission_settings',
    array(
        'title'		=> __( 'Frontend Submission', 'jobboard' ),
        'name'		=> 'frontend_submission_settings',
        'icon'		=> 'font-awesome:fa-ticket',
        'controls'	=> array(
            array(
                'type'		=> 'section',
                'title'		=> __( 'Page Settings', 'jobboard' ),
                'name'		=> 'page_settings',
                'fields'	=> array(

                    array(
                        'type'	=> 'select',
                        'name'	=> 'dashboard_page',
                        'label'	=> __( 'Account Dashboard Page', 'jobboard' ),
                        'items'	=> array(
                            'data' => array(
                                array(
                                    'source'	=> 'function',
                                    'value'  	=> 'jobboard_get_dashboard_page',
                                ),
                            ),
                        ),
                        'default'	=> '{{first}}'
                    ),

                        array(
                            'type'	=> 'select',
                            'name'	=> 'account_settings_page',
                            'label'	=> __( 'Account Settings Page', 'jobboard' ),
                            'items'	=> array(
                                'data' => array(
                                    array(
                                        'source'	=> 'function',
                                        'value'  	=> 'jobboard_get_account_settings_page',
                                    ),
                                ),
                            ),
                            'default'	=> '{{first}}'
                        ),

                    array(
                        'type'	=> 'select',
                        'name'	=> 'post_job_page',
                        'label'	=> __( 'Post a Job Page', 'jobboard' ),
                        'items'	=> array(
                            'data' => array(
                                array(
                                    'source'	=> 'function',
                                    'value'  	=> 'jobboard_get_post_job_page',
                                ),
                            ),
                        ),
                        'default'	=> '{{first}}',
                    ),
                    array(
                        'type'	=> 'select',
                        'name'	=> 'post_company_page',
                        'label'	=> __( 'Add Company Page', 'jobboard' ),
                        'items'	=> array(
                            'data' => array(
                                array(
                                    'source'	=> 'function',
                                    'value'  	=> 'jobboard_get_company_page',
                                ),
                            ),
                        ),
                        'default'	=> '{{first}}',
                    ),
                    array(
                        'type'	=> 'select',
                        'name'	=> 'post_resume_page',
                        'label'	=> __( 'Post a Resume Page', 'jobboard' ),
                        'items'	=> array(
                            'data' => array(
                                array(
                                    'source'	=> 'function',
                                    'value'  	=> 'jobboard_get_post_resume_page',
                                ),
                            ),
                        ),
                        'default'	=> '{{first}}',
                    ),
                    array(
                        'type'	=> 'select',
                        'name'	=> 'login_page',
                        'label'	=> __( 'Login Page', 'jobboard' ),
                        'items'	=> array(
                            'data' => array(
                                array(
                                    'source'	=> 'function',
                                    'value'  	=> 'jobboard_get_login_page',
                                ),
                            ),
                        ),
                        'default'	=> '{{first}}',
                    ),
                    array(
                        'type'	=> 'select',
                        'name'	=> 'register_page',
                        'label'	=> __( 'Register Page', 'jobboard' ),
                        'items'	=> array(
                            'data' => array(
                                array(
                                    'source'	=> 'function',
                                    'value'  	=> 'jobboard_get_register_page',
                                ),
                            ),
                        ),
                        'default'	=> '{{first}}',
                    ),

          array(
                        'type'			=> 'toggle',
                        'name'			=> 'users_can_register_front',
                        'label'			=> __( 'Registration Frontend', 'jobboard' ),
                        'description'	=> __( 'Activate to allowed registration from register page.', 'jobboard' ),
                    ),

          array(
                        'type'			=> 'toggle',
                        'name'			=> 'auto_publish_job',
                        'label'			=> __( 'Auto Publish Job Post', 'jobboard' ),
                        'description'	=> __( 'Activate to make job submission auto published otherwhise it needs admin approval.', 'jobboard' ),
                    ),

          array(
                        'type'			=> 'toggle',
                        'name'			=> 'auto_publish_resume',
                        'label'			=> __( 'Auto Publish Resume Submission', 'jobboard' ),
                        'description'	=> __( 'Activate to make resume submission auto published otherwhise it needs admin approval.', 'jobboard' ),
                    ),

          array(
                        'type'			=> 'toggle',
                        'name'			=> 'auto_publish_company',
                        'label'			=> __( 'Auto Publish Company Submission', 'jobboard' ),
                        'description'	=> __( 'Activate to make company submission auto published otherwhise it needs admin approval.', 'jobboard' ),
                    ),

          array(
                        'type'			=> 'toggle',
                        'name'			=> 'resume_view_guest',
                        'label'			=> __( 'Single Resume View', 'jobboard' ),
                        'description'	=> __( 'Enable guest or job seeker to view single resume page.', 'jobboard' ),
                    ),


                ),
            ),

            array(
                'type'	=> 'section',
                'title'	=> __( 'Package Settings', 'jobboard' ),
                'name'	=> 'jobboard_package_settings',
                'fields'=> array(
                    array(
                        'type'			=> 'toggle',
                        'name'			=> 'enable_package_job',
                        'label'			=> __( 'Enable Job Package', 'jobboard' ),
                        'description'	=> __( 'Activate to enable job package. This will override auto publish always on if enabled.', 'jobboard' ),
                    ),

                    array(
                        'type'			=> 'toggle',
                        'name'			=> 'enable_package_resume',
                        'label'			=> __( 'Enable Resume Package', 'jobboard' ),
                        'description'	=> __( 'Activate to enable resume package. This will override auto publish always on if enabled.', 'jobboard' ),
                    ),

                    array(
                        'type'			=> 'toggle',
                        'name'			=> 'enable_package_resume_view',
                        'label'			=> __( 'Enable Resume View Package', 'jobboard' ),
                        'description'	=> __( 'Activate to enable resume view package. This option does limiting job lister to view resumes.', 'jobboard' ),
                    ),

                ),
            ),

            array(
                'type'	=> 'section',
                'title'	=> __( 'Payments', 'jobboard' ),
                'name'	=> 'jobboard_job_payment',
                'fields'=> array(


                    array(
                        'type'		=> 'toggle',
                        'name'		=> 'payment_sandbox_mode',
                        'label'		=> __( 'Enable Demo/Sanbox Mode', 'jobboard' ),
                        'description'	=> __( 'PayPal Sandbox mode.', 'jobboard' ),
                    ),

                    array(
                        'type'		=> 'textbox',
                        'name'		=> 'paypal_email',
                        'label'		=> __( 'Paypal Email', 'jobboard' ),
                        'validation'=> 'email',
                    ),

                    array(
                        'type'			=> 'toggle',
                        'name'			=> 'cost_featured',
                        'label'			=> __( 'Charge for Featured', 'jobboard' ),
                        'description'	=> __( 'Activate to charge user for faeturing post job or free.', 'jobboard' ),
                    ),

                    array(
                        'type'		=> 'textbox',
                        'name'		=> 'cost_per_feature',
                        'label'		=> __( 'Cost per Featured Job', 'jobboard' ),
                        'validation'=> 'numeric',

                        'dependency'	=> array(
                            'field'		=> 'cost_featured',
                            'function'	=> 'vp_dep_boolean',
                        ),
                    ),

                    array(
                        'type'			=> 'toggle',
                        'name'			=> 'activate_payment',
                        'label'			=> __( 'Charge for Submit', 'jobboard' ),
                        'description'	=> __( 'Activate to charge user for post each job.', 'jobboard' ),
                    ),

                    array(
                        'type'		=> 'select',
                        'name'		=> 'payment_currency',
                        'label'		=> __( 'Payment Currency', 'jobboard' ),
                        'items'		=> array(
                            'data' => array(
                                array(
                                    'source'	=> 'function',
                                    'value'  	=> 'jobboard_get_payment_currency',
                                ),
                            ),
                        ),
                        'default'	=> 'USD',

                        'dependency'	=> array(
                            'field'		=> 'activate_payment',
                            'function'	=> 'vp_dep_boolean',
                        ),
                    ),

                    array(
                        'type'		=> 'textbox',
                        'name'		=> 'currency_symbol',
                        'label'		=> __( 'Currency Symbol', 'jobboard' ),
                        'default'	=> '$',

                        'dependency'	=> array(
                            'field'		=> 'activate_payment',
                            'function'	=> 'vp_dep_boolean',
                        ),
                    ),

                    array(
                        'type'		=> 'textbox',
                        'name'		=> 'cost_per_post',
                        'label'		=> __( 'Cost per Job Posted', 'jobboard' ),
                        'validation'=> 'numeric',

                        'dependency'	=> array(
                            'field'		=> 'activate_payment',
                            'function'	=> 'vp_dep_boolean',
                        ),
                    ),

                ),
            ),
        ),
    )
);
