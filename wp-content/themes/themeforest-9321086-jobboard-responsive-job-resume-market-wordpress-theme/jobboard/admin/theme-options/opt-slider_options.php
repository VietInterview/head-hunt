<?php

//Slider Settings

$slider_options = apply_filters( 'jboard_theme_options-slider_options',
  array(
    'title'	=> __( 'Slider Options', 'jobboard' ),
    'name'	=> 'slider_options',
    'icon'	=> 'font-awesome:fa-picture-o',
    'menus'	=> array(

        // Default Slider
        array(
            'title'		=> __( 'Default', 'jobboard' ),
            'name'		=> 'slider_options_default',
            'icon'		=> 'font-awesome:fa-picture-o',
            'controls'	=> array(
                array(
                    'type'			=> 'select',
                    'name'			=> 'select_slider',
                    'label'			=> __( 'Select Slider', 'jobboard' ),
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
                ),

                array(
                    'type'	=> 'select',
                    'name'	=> 'slider_entrance_animation',
                    'label'	=> __( 'Slider Entrance Animation', 'jobboard' ),
                    'items'	=> array(
                        'data'	=> array(
                            array(
                                'source'	=> 'function',
                                'value'		=> 'jobboard_get_entrance_slider_animation',
                            ),
                        ),
                    ),
                    'default'	=> 'fadeIn',
                ),

                array(
                    'type'	=> 'select',
                    'name'	=> 'slider_exit_animation',
                    'label'	=> __( 'Slider Exit Animation', 'jobboard' ),
                    'items'	=> array(
                        'data'	=> array(
                            array(
                                'source'	=> 'function',
                                'value'		=> 'jobboard_get_exit_slider_animation',
                            ),
                        ),
                    ),
                    'default'	=> 'fadeOut',
                ),

                array(
                    'type'		=> 'toggle',
                    'name'		=> 'slider_auto_slide',
                    'label'		=> __( 'Auto Slide', 'jobboard' ),
                    'default'	=> '1',
                ),

                array(
                    'type'			=> 'textbox',
                    'name'			=> 'slider_delay',
                    'label'			=> __( 'Slide Delay', 'jobboard' ),
                    'dependency'	=> array(
                        'function'	=> 'vp_dep_boolean',
                        'field'		=> 'slider_auto_slide',
                    ),
                    'validation'	=> 'numeric|required',
                    'default'		=> '3000',
                    'description'	=> __( 'Insert the slide delay in miliseconds.', 'jobboard' ),
                ),
            ),
        ),

        // FlexSlider
        array(
            'title'		=> __( 'Flexslider', 'jobboard' ),
            'name'		=> 'slider_options_flexslider',
            'icon'		=> 'font-awesome:fa-picture-o',
            'controls'	=> array(
                array(
                    'type'			=> 'select',
                    'name'			=> 'select_flexslider',
                    'label'			=> __( 'Select Slider', 'jobboard' ),
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
                ),
                array(
                    'type'			=> 'select',
                    'name'			=> 'flexslider_animation',
                    'label'			=> __( 'Select Slider', 'jobboard' ),
                    'validation'	=> 'required',
                    'items'			=> array(
                        array(
                            'value'	=> 'slide',
                            'label'	=> __( 'Slide', 'jobboard' ),
                        ),
                        array(
                            'value'	=> 'fade',
                            'label'	=> __( 'Fade', 'jobboard' ),
                        ),
                    ),
                    'default'	=> 'slide',
                ),
                array(
                    'type'		=> 'toggle',
                    'name'		=> 'flexslider_auto_slide',
                    'label'		=> __( 'Auto Slide', 'jobboard' ),
                    'default'	=> '1',
                ),
                array(
                    'type'			=> 'textbox',
                    'name'			=> 'flexslider_delay',
                    'label'			=> __( 'Slide Delay', 'jobboard' ),
                    'dependency'	=> array(
                        'function'	=> 'vp_dep_boolean',
                        'field'		=> 'flexslider_auto_slide',
                    ),
                    'validation'	=> 'numeric|required',
                    'default'		=> '7000',
                    'description'	=> __( 'Insert the slide delay in miliseconds.', 'jobboard' ),
                ),
            ),
        ),
        // RevSlider
        array(
            'title'		=> __( 'Revolution Slider', 'jobboard' ),
            'name'		=> 'slider_options_revslider',
            'icon'		=> 'font-awesome:fa-picture-o',
            'controls'	=> array(
                array(
                    'type'			=> 'select',
                    'name'			=> 'select_revslider',
                    'label'			=> __( 'Select Slider', 'jobboard' ),
                    'validation'	=> 'required',
                    'items'			=> array(
                        'data'	=> array(
                            array(
                                'source'	=> 'function',
                                'value'		=> 'jobboard_get_revslider',
                            ),
                        ),
                    ),
                    'default'	=> '{{first}}',
                ),
            ),
        ),

    ),
  )
);
