<?php
return array(
    'admin' => array(
        'menu' => include (__DIR__ . '/admin-menu.php'),
        'options' => include (__DIR__ . '/admin-options.php'),
    ),
    'excludeUserOptions' => array(
        'wcp_weather' => array(),
        'wcp_weather_widget' => array(),
        'wcp_weather_mini_widget' => array('pressureUnit', 'windSpeedUnit'),
    ),
    'iconClass' => array(
        // day
        '01d' => 'sun',                     //clear sky
        '02d' => 'cloud-sun',               //few clouds
        '03d' => 'cloud',                   //scattered clouds 
        '04d' => 'clouds',                  //broken clouds 
        '09d' => 'cloud-rain',              //shower rain 
        '10d' => 'cloud-rain-sun',          //rain
        '11d' => 'cloud-rain-lightning',    //thunderstorm 
        '13d' => 'snow',                    //snow
        '50d' => 'fog',                     //mist 
        // night
        '01n' => 'sun',                     //clear sky
        '02n' => 'cloud-sun',               //few clouds
        '03n' => 'cloud',                   //scattered clouds 
        '04n' => 'clouds',                  //broken clouds 
        '09n' => 'cloud-rain',              //shower rain 
        '10n' => 'cloud-rain-sun',          //rain
        '11n' => 'cloud-rain-lightning',    //thunderstorm 
        '13n' => 'snow',                    //snow
        '50n' => 'fog',                     //mist 
    ),    
);


