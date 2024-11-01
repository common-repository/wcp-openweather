<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $item = $params;
?>
<span class="wcp-openweather-forecast-day"><?php _e( strtolower(date('D', $item->getDay())), 'wcp-openweather' );?></span> 
