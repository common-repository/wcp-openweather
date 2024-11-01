<?php
return array(
    'rpw-theme-metro-settings' => array(
        'sections' => array(
            'global' => array(
                'label' => __('Global settings', 'wcp-openweather-theme'),
            ),            
            'widget' => array(
                'label' => __('Widget settings', 'wcp-openweather-theme'),
            ),
            'shortcode' => array(
                'label' => __('Shortcode settings', 'wcp-openweather-theme'),
            ),            
        ),
        'fields' => array(
            'text_color' => array(
                'type' => 'colorpicker',
                'label' => __('Text Color', 'wcp-openweather-theme'),
                'default' => '#FFFFFF',
                'section' => 'global',
                'class' => '',
                'note' => '',
                'atts' => array(
                ),                                
            ),    
            'background_color' => array(
                'type' => 'colorpicker',
                'label' => __('Background Color', 'wcp-openweather-theme'),
                'default' => '#000000',
                'section' => 'global',
                'class' => '',
                'note' => '',
                'atts' => array(
                ),                                
            ),
            'background_opacity' => array(
                'type' => 'number',
                'label' => __('Background Opacity, %', 'wcp-openweather-theme'),
                'default' => '40',
                'section' => 'global',
                'class' => '',
                'note' => '',
                'atts' => array(
                    'min' => 0,
                    'max' => 100,
                ),                                
            ),            
            'wcp_weather_widget_image_size' => array(
                'label' => __('Image Size', 'wcp-openweather-theme'),
                'type' => 'imagesize',                        
                'default' =>  array(
                    'width' => 600,
                    'height' => 500,
                    'crop' => 1,
                ),
                'section' => 'widget',
                'class' => '',
                'note' => '',
            ),                                    
            'widgetImage' => array(
                'label' => __('Image', 'wcp-openweather-theme'),
                'type' => 'image',                        
                'default' => 'images/default/widget-background.png', 
                'section' => 'widget',
                'class' => 'agp-upload-image',
                'note' => '',
            ),                                                
            'wcp_weather_shortcode_image_size' => array(
                'label' => __('Image Size', 'wcp-openweather-theme'),
                'type' => 'imagesize',                        
                'default' =>  array(
                    'width' => 1200,
                    'height' => 500,
                    'crop' => 1,
                ),
                'section' => 'shortcode',
                'class' => '',
                'note' => '',
            ),  
            'shortcodeImage' => array(
                'label' => __('Image', 'wcp-openweather-theme'),
                'type' => 'image',                        
                'default' => 'images/default/shortcode-background.png', 
                'section' => 'shortcode',
                'class' => 'agp-upload-image',
                'note' => '',
            ),                                                            
        ),
    ),
);