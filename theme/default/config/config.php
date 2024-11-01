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
    )
);


