<?php
    namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;
    
    $item = !empty($params['item']) ? $params['item'] : NULL;
    $index = !empty($params['index']) ? $params['index'] : NULL;
    $count = !empty($params['count']) ? $params['count'] : NULL;
    if (!empty($item)) :
        $windDeg = $item->getWindDeg();
?>  
<tr class="wcp-openweather-forecast-item wp-open-weather-forecast-item wp-open-weather-block wcp-openweather-primary-background <?php echo ($index % 2 != 0) ? ' wcp-openweather-forecast-item-light' : '';?>">
    <td class="wcp-openweather-forecast-item-align"><span class="wcp-openweather-forecast-item-day"><?php _e( strtolower(date('D', $item->getDay())), 'wcp-openweather' );?></span> <span class="wcp-openweather-forecast-item-date"><?php _e( strtolower(date('M', $item->getDay())), 'wcp-openweather' );?> <?php echo date('j', $item->getDay());?></span></td>
    <td class="wcp-openweather-forecast-item-icon"><div class="wcp-openweather-forecast-day-icon"><?php echo Theme::instance()->renderIcon( $item, $item->hideWeatherConditions ); ?></div></td>
    <td><?php echo $item->getTemperature()->day;?>/<?php echo $item->getTemperature()->night;?><sup class="wcp-openweather-forecast-day-deg">&deg;</sup><?php echo $item->getTempUnitShort();?></td>
    <td><?php echo $item->getWindSpeed();?><?php echo !empty($windDeg) ? ', '.$windDeg : '';?></td>
    <td class="wcp-openweather-forecast-item-hidden-xs"><?php echo $item->getHumidity();?></td>
    <td class="wcp-openweather-forecast-item-last"><?php echo $item->getPressure();?></td>
</tr>                                   
<?php
    endif;