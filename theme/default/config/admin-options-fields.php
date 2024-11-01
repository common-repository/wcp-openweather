<?php
return array(
    'rpw-theme-default-settings' => array(
        'sections' => array(
            'global' => array(
                'label' => __('Global settings', 'wcp-openweather-theme'),
            ),            
        ),
        'fields' => array(
            'background_color' => array(
                'type' => 'colorpicker',
                'label' => __('Background Color', 'wcp-openweather-theme'),
                'default' => '',
                'section' => 'global',
                'class' => '',
                'note' => '',
                'atts' => array(
                ),                                
            ),
            'text_color' => array(
                'type' => 'colorpicker',
                'label' => __('Text Color', 'wcp-openweather-theme'),
                'default' => '',
                'section' => 'global',
                'class' => '',
                'note' => '',
                'atts' => array(
                ),                                
            ),                    
        ),
    ),
);