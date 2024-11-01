<?php
    namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;
    
    $item = $params;
?>
<span class="wcp-openweather-forecast-day"><?php _e( strtolower(date('D', $item->getDay())), 'wcp-openweather' );?><span class="wcp-openweather-forecast-item-date"><?php echo date('m/d', $item->getDay());?></span></span> 
