<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $data = $params;
    $item = $data->getFirst();
    $windDeg = $item->getWindDeg();
?>
<div class="wcp-openweather-now-wrapper wp-open-weather-now wp-open-weather-block">
    <div class="wcp-openweather-now">
        <div class="wcp-openweather-now-temperature">            
            <div class="wcp-openweather-now-value"><?php echo $item->getTemperature();?><sup class="wcp-openweather-now-value-deg">&deg;</sup><?php echo $item->getTempUnitShort();?> </div>            
        </div>
        <?php if (empty($data->hideWeatherConditions)): ?><div class="wcp-openweather-now-status"><?php echo $item->getWeatherDescription();?></div><?php endif;?>
    </div>    
</div>
