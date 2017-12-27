<?php

// Contact Settings

$contact_settings = apply_filters( 'jboard_theme_options-contact_settings',
    array(
        'title'		=> __( 'Contact Settings', 'jobboard' ),
        'name'		=> 'contact_settings',
        'icon'		=> 'font-awesome:fa-envelope',
        'controls'	=> array(

            array(
                'type'  => 'section',
                'title' => __( 'Contact Google Maps', 'jobboard' ),
                'name'  => 'contact_google_api',
                'fields'=> array(
                    array(
                        'type'      => 'textbox',
                        'name'      => 'google_api_key',
                        'label'     => __( 'Google Api Key', 'jobboard' )
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'gmap_latitude',
                        'label'	=> __( 'Google Map Latitude', 'jobboard' ),
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'gmap_longitude',
                        'label'	=> __( 'Google Map Longitude', 'jobboard' ),
                    ),
                )
            ),

            array(
                'type'		=> 'section',
                'title'		=> __( 'Contact Information', 'jobboard' ),
                'name'		=> 'contact_info_settings',
                'fields'	=> array(
                    array(
                        'type'	=> 'textarea',
                        'name'	=> 'contact_info_address',
                        'label'	=> __( 'Address', 'jobboard' ),
                        'default'	=> '5th Avenue Street, 103 Floor, Trump Tower Crosss Road, LA 450001'
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'contact_info_telp',
                        'label'	=> __( 'Telephone Number', 'jobboard' ),
                        'default'	=> '+1 81000 0001',
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'contact_info_email',
                        'label'	=> __( 'Email Address', 'jobboard' ),
                        'validation'	=> 'email',
                    )
                ),
            ),

            array(
                'type'		=> 'section',
                'title'		=> __( 'Social Media', 'jobboard' ),
                'name'		=> 'social_media_settings',
                'fields'	=> array(
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'social_facebook',
                        'label'	=> __( 'Facebook', 'jobboard' ),
                        'validation'	=> 'url',
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'social_twitter',
                        'label'	=> __( 'Twitter', 'jobboard' ),
                        'validation'	=> 'url',
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'social_google-plus',
                        'label'	=> __( 'Google Plus', 'jobboard' ),
                        'validation'	=> 'url',
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'social_youtube',
                        'label'	=> __( 'Youtube', 'jobboard' ),
                        'validation'	=> 'url',
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'social_linkedin',
                        'label'	=> __( 'LinkedIn', 'jobboard' ),
                        'validation'	=> 'url',
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'social_rss',
                        'label'	=> __( 'RSS', 'jobboard' ),
                        'validation'	=> 'url',
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'social_flickr',
                        'label'	=> __( 'Flickr', 'jobboard' ),
                        'validation'	=> 'url',
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'social_vimeo-square',
                        'label'	=> __( 'Vimeo', 'jobboard' ),
                        'validation'	=> 'url',
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'social_dribbble',
                        'label'	=> __( 'Dribbble', 'jobboard' ),
                        'validation'	=> 'url',
                    ),
                    array(
                        'type'	=> 'textbox',
                        'name'	=> 'social_tumblr',
                        'label'	=> __( 'Tumblr', 'jobboard' ),
                        'validation'	=> 'url',
                    ),

                ),
            ),

        ),
    )
);
