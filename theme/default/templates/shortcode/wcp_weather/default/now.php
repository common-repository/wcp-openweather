<?php
    use Webcodin\WCPOpenWeather\Theme\DefaultTheme\Theme;
    
    $data = $params;
    $item = $data->getFirst();
    $windDeg = $item->getWindDeg();
?>
 
<!--<div class="wcp-openweather-now-wrapper">-->
    <td class="wcp-openweather-now-icon-wrapper">
        <div class="wcp-openweather-now-icon">
            <?php echo Theme::instance()->renderIcon( $item, $data->hideWeatherConditions ); ?>
        </div>
    </td>
    <td class="wcp-openweather-now-temperature-wrapper">
        <span class="wcp-openweather-now-value"><?php echo $item->getTemperature();?><sup class="wcp-openweather-now-value-deg">&deg;</sup><?php echo $item->getTempUnitShort();?> </span>
        <?php if (empty($data->hideWeatherConditions)): ?><span class="wcp-openweather-now-status"><?php echo $item->getWeatherDescription();?></span><?php endif;?>                
    </td>
</tr>
<!--</div>-->
<tr>
    <td colspan="3">
        <div class="wcp-openweather-now-details">
            <div class="wcp-openweather-now-details-row">
                <div class="wcp-openweather-now-details-row-content">
                    <span class="wcp-openweather-now-details-title wcp-openweather-primary-color"><?php _e('Wind', 'wcp-openweather-theme'); ?></span>            
                    <span class="wcp-openweather-now-details-value wcp-openweather-primary-color"><?php echo $item->getWindSpeed();?><?php echo !empty($windDeg) ? ', '.$windDeg : '';?></span>
                </div>
            </div>
            <div class="wcp-openweather-now-details-row">
                <div class="wcp-openweather-now-details-row-content">
                    <span class="wcp-openweather-now-details-title wcp-openweather-primary-color"><?php _e('Humidity', 'wcp-openweather-theme'); ?></span>
                    <span class="wcp-openweather-now-details-value wcp-openweather-primary-color"><?php echo $item->getHumidity();?></span>
                </div>
            </div>
            <div class="wcp-openweather-now-details-row">
                <div class="wcp-openweather-now-details-row-content">
                    <span class="wcp-openweather-now-details-title wcp-openweather-primary-color"><?php _e('Pressure', 'wcp-openweather-theme'); ?></span>
                    <span class="wcp-openweather-now-details-value wcp-openweather-primary-color"><?php echo $item->getPressure();?></span>
                </div>
            </div>
        </div>
    </td>

        

