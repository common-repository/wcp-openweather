<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $item = !empty($params['item']) ? $params['item'] : NULL;
    $index = !empty($params['index']) ? $params['index'] : NULL;
    $count = !empty($params['count']) ? $params['count'] : NULL;
    if (!empty($item)) :
        $windDeg = $item->getWindDeg();
?>  
<div class="wcp-openweather-forecast-item wp-open-weather-forecast-item wp-open-weather-block">
    <div class="wcp-openweather-forecast-day-temperature">
        <div class="wcp-openweather-forecast-day-icon">
            <?php echo Theme::instance()->renderIcon( $item, $item->hideWeatherConditions ); ?>
        </div>
        <span class="wcp-openweather-forecast-day-value wcp-openweather-primary-color"><?php echo $item->getTemperature()->day;?>/<?php echo $item->getTemperature()->night;?><sup class="wcp-openweather-forecast-day-deg">&deg;</sup><?php echo $item->getTempUnitShort();?></span>
    </div>        
</div>
<?php
    endif;