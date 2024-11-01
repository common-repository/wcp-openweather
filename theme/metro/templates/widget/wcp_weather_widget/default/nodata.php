<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $plugin = RPw()->getSettings()->getPluginSettings(); 
    $message = !empty($plugin['noDataMessage']) ? $plugin['noDataMessage'] : __('Ooops! Nothing was found!', 'wcp-openweather-theme');
    
    $api = RPw()->getSettings()->getAPISettings();
    $message = !empty($api['appid']) ? $message : '<i>Please add free or paid OpenWeatherMap API key in the plugin settings!</i>';    
?>
<div class="wcp-openweather-nodata-wrapper wp-open-weather-nodata">
    <span class="wcp-openweather-nodata">
        <?php echo $message; ?>
    </span>
</div> 

