<?php
return array(
    'global-settings' => array(
        'sections' => array(
            'location' => array(
                'label' => __('Location', 'wcp-openweather'),
            ),            
            'units' => array(
                'label' => __('Units', 'wcp-openweather'),
                'class' => 'wcp-openweather-settings-units',
            ),
            'options' => array(
                'label' => __('Display Options', 'wcp-openweather'),
                'class' => 'wcp-openweather-settings-options',
            ),
        ),
        'fields' => array(
            'uniqueId' => array(
                'label' => 'Unique ID',            
                'type' => 'hidden',                        
                'default' => '55780f7e18fca',
                'section' => 'location',
                'class' => 'widefat',
                'note' => '',
            ),      
            'city' => array(
                'label' => __('City Name', 'wcp-openweather'),
                'type' => 'city',                        
                'default' => '',
                'section' => 'location',
                'class' => 'widefat rpw-gm-city',
                'wrapper_class' => '',
                'note' => __('You can find you city name on <a href="http://www.openweathermap.com/" title="http://www.openweathermap.com/" target="_blank">www.openweathermap.com</a>.', 'wcp-openweather'),
            ),      
            'city_data' => array(
                'label' => 'City Data',            
                'type' => 'hidden',                        
                'default' => '',
                'section' => 'location',
                'class' => 'widefat rpw-gm-city-data',
                'note' => '',
            ),      
            'tempUnit' => array(
                'type' => 'select',
                'label' => __('Temperature', 'wcp-openweather'),
                'fieldSet' => 'temp',
                'default' => 'c',
                'section' => 'units',
                'class' => 'widefat regular-select',
            ),
            'windSpeedUnit' => array(
                'type' => 'select',
                'label' => __('Wind Speed', 'wcp-openweather'),
                'fieldSet' => 'windSpeed',
                'default' => 'ms',
                'section' => 'units',
                'class' => 'widefat regular-select',
            ),
            'pressureUnit' => array(
                'type' => 'select',
                'label' => __('Pressure', 'wcp-openweather'),
                'fieldSet' => 'pressure',
                'default' => 'mmHg',
                'section' => 'units',
                'class' => 'widefat regular-select',
            ),      
            'template' => array(
                'type' => 'templates',
                'label' => __('Template', 'wcp-openweather'),
                'fieldSet' => 'shortcodeTemplates',
                'default' => 'default',
                'section' => 'options',
                'class' => 'widefat regular-select',
            ),            
            'showCurrentWeather' => array(
                'type' => 'checkbox',
                'label' => __('Show current weather', 'wcp-openweather'),
                'default' => 1,
                'section' => 'options',
                'class' => '',
            ),              
            'showForecastWeather' => array(
                'type' => 'checkbox',
                'label' => __('Show 5 day forecast', 'wcp-openweather'),
                'default' => '',
                'section' => 'options',
                'class' => '',
            ),  
        ),
    ),
    'plugin-settings' => array(
        'sections' => array(
            'options' => array(
                'label' => __('General', 'wcp-openweather'),
            ),
            'user_options' => array(
                'label' => __('User Options', 'wcp-openweather'),
            ),            
            'other_options' => array(
                'label' => __('Other', 'wcp-openweather'),
            ),
        ),   
        'fields' => array(    
            'lang' => array(
                'type' => 'lang',
                'label' => __('Language', 'wcp-openweather'),
                'fieldSet' => 'lang',
                'default' => '',
                'section' => 'options',
                'class' => 'widefat regular-select',
                'note' => '',
            ),                   
            'theme' => array(
                'type' => 'select',
                'label' => __('Current Theme', 'wcp-openweather'),
                'fieldSet' => 'theme',
                'default' => 'default',
                'section' => 'options',
                'class' => 'widefat regular-select',
                'note' => '',
            ),  
            'refreshPeriod' => array(
                'type' => 'select',
                'label' => __('Refresh Time', 'wcp-openweather'),
                'fieldSet' => 'refreshPeriod',
                'default' => '0',
                'section' => 'options',
                'class' => 'widefat regular-select',
            ),            
            'hideWeatherConditions' => array(
                'label' => __('Hide Description of the Weather Conditions', 'wcp-openweather'),
                'type' => 'checkbox',                        
                'default' => '',
                'section' => 'other_options',
                'class' => '',
            ),            
            'noDataMessage' => array(
                'label' => __('"No Data" Message', 'wcp-openweather'),
                'type' => 'text',                        
                'default' => '',
                'section' => 'other_options',
                'class' => 'widefat',
                'note' => '',       
            ),      
            'enableGoogleMapsApi' => array(
                'label' => __('Enable "Google Maps API"', 'wcp-openweather'),
                'type' => 'checkbox',                        
                'default' => '1',
                'section' => 'other_options',
                'class' => '',
            ),                        
            'enableUserSettings' => array(
                'label' => __('Enable User Options', 'wcp-openweather'),
                'type' => 'checkbox',                        
                'default' => '',
                'section' => 'user_options',
                'class' => '',
            ),
            'expireUserSettings' => array(
                'label' => __('Expire User Options (days)', 'wcp-openweather'),
                'type' => 'number',                        
                'default' => '7',
                'section' => 'user_options',
                'class' => 'widefat',
                'note' => '',       
                'atts' => array(
                    'min' => 0,
                ),                                
            ),
        ),
    ),
    'api-settings' => array(
        'sections' => array(
            'api_options' => array(
                'label' => __('Options', 'wcp-openweather'),
            ),
        ),           
        'fields' => array(        
            'appid' => array(
                'label' => __('API key', 'wcp-openweather'),            
                'type' => 'text',                        
                'default' => '',
                'section' => 'api_options',
                'class' => 'widefat',
                'note' =>  __('How to get API key you can see <a href="http://openweathermap.org/appid" title="http://openweathermap.org/appid" target="_blank">here</a>.', 'wcp-openweather'),
            ),
            'googleappid' => array(
                'label' => __('Google API key', 'wcp-openweather'),            
                'type' => 'text',                        
                'default' => '',
                'section' => 'api_options',
                'class' => 'widefat',
                'note' =>  __('How to get Google API key you can see <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" title="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a>.', 'wcp-openweather'),
            ),
        ),        
    ),
);