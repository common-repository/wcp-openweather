<?php
    namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;
    
    $item = $params;
?>
<div class="wcp-openweather-forecast-item wp-open-weather-forecast-item wp-open-weather-block">
    <div class="wcp-openweather-forecast-day-temperature">
        <div class="wcp-openweather-forecast-day-icon">
            <?php echo Theme::instance()->renderIcon( $item, $item->hideWeatherConditions ); ?>
        </div>
        <span class="wcp-openweather-forecast-day-value"><?php echo $item->getTemperature()->day;?>/<?php echo $item->getTemperature()->night;?><sup class="wcp-openweather-forecast-day-deg">&deg;</sup><?php echo $item->getTempUnitShort();?></span>
    </div>        
</div>
