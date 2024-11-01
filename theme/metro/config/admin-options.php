<?php
return array(
    'page' => 'wcp-theme',
    'title' => array('Webcodin\WCPOpenWeather\Theme\MetroTheme\Theme', 'getThemeName'),
    'tabs' => include (__DIR__ . '/admin-options-tabs.php'),
    'fields' => include (__DIR__ . '/admin-options-fields.php'),
    'fieldSet' => include (__DIR__ . '/admin-options-fieldset.php'),
);