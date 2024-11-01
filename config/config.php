<?php
return array(
    'admin' => array(
        'menu' => include (__DIR__ . '/admin-menu.php'),
        'options' => include (__DIR__ . '/admin-options.php'),
    ),
    'inline_theme' => array(
        'Webcodin\WCPOpenWeather\Theme\DefaultTheme' => '/theme/default/wcp-open-weather-theme.php',
        'Webcodin\WCPOpenWeather\Theme\MetroTheme' => '/theme/metro/wcp-open-weather-theme.php',
    ),
    'image' => array(
        'sizes' => array (
            'wcp_weather_image_preview' => array(
                'name' => 'WCP image Preview',
                'width' => 300,
                'height' => 200,
                'crop' => TRUE,
            )            
        ),
    ),
);


