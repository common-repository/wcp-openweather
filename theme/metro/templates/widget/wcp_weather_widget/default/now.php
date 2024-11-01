<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $data = $params;
    $item = $data->getFirst();
    $windDeg = $item->getWindDeg();
?>
<div class="wcp-openweather-now-wrapper wp-open-weather-now wp-open-weather-block">
    <div class="wcp-openweather-now">
        <div class="wcp-openweather-now-temperature">
            <div class="wcp-openweather-now-icon">
                <?php echo Theme::instance()->renderIcon( $item, $data->hideWeatherConditions ); ?> 
            </div>
            <div class="wcp-openweather-now-value"><?php echo $item->getTemperature();?><sup class="wcp-openweather-now-value-deg">&deg;</sup><?php echo $item->getTempUnitShort();?> </div>            
        </div>
        <?php if (empty($data->hideWeatherConditions)): ?><div class="wcp-openweather-now-status"><?php echo $item->getWeatherDescription();?></div><?php endif;?>
    </div>
    <div class="wcp-openweather-now-details">
        <div class="wcp-openweather-now-details-col">
            <div class="wcp-openweather-now-details-row">
                <span class="wcp-openweather-now-details-title"><?php _e('Wind', 'wcp-openweather-theme'); ?></span>
                <span class="wcp-openweather-now-details-value"><?php echo $item->getWindSpeed();?><?php echo !empty($windDeg) ? ', '.$windDeg : '';?></span>
            </div>
            <div class="wcp-openweather-now-details-row">
                <span class="wcp-openweather-now-details-title"><?php _e('Pressure', 'wcp-openweather-theme'); ?></span>
                <span class="wcp-openweather-now-details-value"><?php echo $item->getPressure();?></span>
            </div>            
        </div>
        <div class="wcp-openweather-now-details-col">
            <div class="wcp-openweather-now-details-row">
                <span class="wcp-openweather-now-details-title"><?php _e('Humidity', 'wcp-openweather-theme'); ?></span>
                <span class="wcp-openweather-now-details-value"><?php echo $item->getHumidity();?></span>
            </div>
            <div class="wcp-openweather-now-details-row">
                <span class="wcp-openweather-now-details-title"><?php _e('Clouds', 'wcp-openweather-theme'); ?></span>
                <span class="wcp-openweather-now-details-value"><?php echo $item->getClouds();?></span>
            </div>
        </div>
    </div>
</div>
