<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $item = !empty($params['item']) ? $params['item'] : NULL;
    $index = !empty($params['index']) ? $params['index'] : NULL;
    $count = !empty($params['count']) ? $params['count'] : NULL;
    if (!empty($item)) :
        $windDeg = $item->getWindDeg();
?>  
<tr class="wcp-openweather-forecast-item wp-open-weather-forecast-item wp-open-weather-block wcp-openweather-primary-background <?php echo ($index % 2 != 0) ? ' wcp-openweather-forecast-item-light' : '';?>">
    <td class="wcp-openweather-forecast-item-align wcp-openweather-primary-color"><span class="wcp-openweather-forecast-item-day"><?php _e( strtolower(date('D', $item->getDay())), 'wcp-openweather' );?></span> <span class="wcp-openweather-forecast-item-date"><?php _e( strtolower(date('M', $item->getDay())), 'wcp-openweather' );?> <?php echo date('j', $item->getDay());?></span></td>
    <td class="wcp-openweather-forecast-item-icon wcp-openweather-primary-color"><div class="wcp-openweather-forecast-day-icon"><?php echo Theme::instance()->renderIcon( $item, $item->hideWeatherConditions ); ?></div></td>
    <td class="wcp-openweather-primary-color"><span class="wcp-openweather-forecast-day-temp"><?php echo $item->getTemperature()->day;?><sup class="wcp-openweather-forecast-day-deg">&deg;</sup><?php echo $item->getTempUnitShort();?> <span class="wcp-openweather-hidden-xs">/</span><span class="wcp-openweather-forecast-day-temp-last"><?php echo $item->getTemperature()->night;?><sup class="wcp-openweather-forecast-day-deg">&deg;</sup><?php echo $item->getTempUnitShort();?></span></td>
    <td class="wcp-openweather-primary-color"><?php echo $item->getWindSpeed();?><?php echo !empty($windDeg) ? ', '.$windDeg : '';?></td>
    <td class="wcp-openweather-forecast-item-hidden-xs wcp-openweather-primary-color"><?php echo $item->getHumidity();?></td>
    <td class="wcp-openweather-forecast-item-last wcp-openweather-primary-color"><?php echo $item->getPressure();?></td>
</tr>                                   
<?php
    endif;