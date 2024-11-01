<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $data = $params;
    $template = RPw()->getSettings()->getCurrentTemplatePath();
?>
<div class="wcp-openweather-forecast-wrapper wp-open-weather-forecast">
    <table class="wcp-openweather-forecast-content wcp-openweather-primary-color" cellspacing="0" cellpadding="0">
        <thead>
            <tr class="wcp-openweather-forecast-header">
                <th class="wcp-openweather-forecast-item-align wcp-openweather-primary-color"><?php _e('Day', 'wcp-openweather-theme'); ?></th>
                <th class="wcp-openweather-primary-color"><span><?php _e('Cond.', 'wcp-openweather-theme'); ?></span></th>
                <th class="wcp-openweather-primary-color"><?php _e('Temp.', 'wcp-openweather-theme'); ?></th>
                <th class="wcp-openweather-primary-color"><?php _e('Wind', 'wcp-openweather-theme'); ?></th>
                <th class="wcp-openweather-primary-color wcp-openweather-forecast-item-hidden-xs"><?php _e('Humidity', 'wcp-openweather-theme'); ?></th>
                <th class="wcp-openweather-primary-color"><span class="wcp-openweather-hidden-xs"><?php _e('Pressure', 'wcp-openweather-theme'); ?></span><span class="wcp-openweather-visible-xs"><?php _e('Pres.', 'wcp-openweather-theme'); ?></span></th> 
            </tr>
        </thead>
        <tbody>
            <?php 
                $atts = array(
                    'count' => $data->getCount(),
                    'index' => 0,
                );
                
                foreach ($data->getAll() as $key => $item) :
                    $item->hideWeatherConditions = $data->hideWeatherConditions;
                    $atts['item'] = $item;
                    echo Theme::instance()->getTemplate("shortcode/{$template}/forecast-item", $atts);  
                    $atts['index']++;
                endforeach;
            ?>
        </tbody>
    </table>  
</div>
