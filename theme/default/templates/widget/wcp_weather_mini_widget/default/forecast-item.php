<?php
    namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;
    
    $item = !empty($params['item']) ? $params['item'] : NULL;
    $index = !empty($params['index']) ? $params['index'] : NULL;
    $count = !empty($params['count']) ? $params['count'] : NULL;
    if (!empty($item)) :
?>  
<tr class="wcp-openweather-forecast-item wp-open-weather-forecast-item wp-open-weather-block wcp-openweather-primary-background <?php echo ($index % 2 != 0) ? ' wcp-openweather-forecast-item-light' : '';?>">
    <td class="wcp-openweather-forecast-item-align"><span class="wcp-openweather-forecast-item-day"><?php _e( strtolower(date('D', $item->getDay())), 'wcp-openweather' );?></span> <span class="wcp-openweather-forecast-item-date"><?php echo date('m/d', $item->getDay());?></span></td>
    <td class="wcp-openweather-forecast-item-icon"><div class="wcp-openweather-forecast-day-icon"><?php echo Theme::instance()->renderIcon( $item, $item->hideWeatherConditions ); ?></div></td>
    <td class="wcp-openweather-forecast-item-last"><?php echo $item->getTemperature()->day;?>/<?php echo $item->getTemperature()->night;?><sup class="wcp-openweather-forecast-day-deg">&deg;</sup><?php echo $item->getTempUnitShort();?></td>
</tr>                                   
<?php
    endif;