<?php

// Styling Settings Menu
$styling_settings = apply_filters( 'jboard_theme_options-styling_settings',
    array(
        'title'		=> __( 'Styling', 'jobboard' ),
        'name'		=> 'styling_settings',
        'icon'		=> 'font-awesome:fa-magic',
        'controls'	=> array(
            array(
                'type'		=> 'section',
                'title'		=> __( 'Application Status Color', 'jobboard' ),
                'name'		=> 'application_status_color',
                'fields'	=> jobboard_get_application_status_color(),
            ),

            array(
                'type'		=> 'section',
                'title'		=> __( 'Custom CSS', 'jobboard' ),
                'name'		=> 'custom_css_settings',
                'fields'	=> array(
                    array(
                        'name'			=> 'custom_css_box',
                        'type'			=> 'codeeditor',
                        'label'			=> __( 'Custom CSS Box', 'jobboard' ),
                        'description'	=> __( 'Insert your custom css styling here', 'jobboard' ),
                        'mode'			=> 'css',
                    ),
                ),
            ),
        ),
    )
);
