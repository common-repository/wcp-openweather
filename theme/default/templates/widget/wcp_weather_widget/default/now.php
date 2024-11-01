<?php
    namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;
    
    $data = $params;
    $item = $data->getFirst();
    $windDeg = $item->getWindDeg();
?>
<div class="wcp-openweather-now-wrapper wp-open-weather-now wp-open-weather-block">
    <div class="wcp-openweather-now">
        <div class="wcp-openweather-now-temperature">
            <span class="wcp-openweather-now-value"><?php echo $item->getTemperature();?><sup class="wcp-openweather-now-value-deg">&deg;</sup><?php echo $item->getTempUnitShort();?> </span>
            <div class="wcp-openweather-now-icon">
                <?php echo Theme::instance()->renderIcon( $item, $data->hideWeatherConditions ); ?> 
            </div>
        </div>
        <?php if (empty($data->hideWeatherConditions)): ?><span class="wcp-openweather-now-status"><?php echo $item->getWeatherDescription();?></span><?php endif;?>
    </div>
    <div class="wcp-openweather-now-details">
        <div class="wcp-openweather-now-details-row">
            <span class="wcp-openweather-now-details-title wcp-ow-icon-wind"></span>
            <span class="wcp-openweather-now-details-value"><?php echo $item->getWindSpeed();?><?php echo !empty($windDeg) ? ', '.$windDeg : '';?></span>
        </div>
        <div class="wcp-openweather-now-details-row">
            <span class="wcp-openweather-now-details-title wcp-ow-icon-raindrop"></span>
            <span class="wcp-openweather-now-details-value"><?php echo $item->getHumidity();?></span>
        </div>
        <div class="wcp-openweather-now-details-row">
            <span class="wcp-openweather-now-details-title wcp-ow-icon-arrow-down"><span class="wcp-ow-icon-arrow-down"></span></span>
            <span class="wcp-openweather-now-details-value"><?php echo $item->getPressure();?></span>
        </div>           
    </div>
</div>
