<?php
    namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;
    
    $data = $params;
    $template = RPw()->getSettings()->getCurrentTemplatePath();
?>
<div class="wcp-openweather-forecast-wrapper wp-open-weather-forecast">
    <table class="wcp-openweather-forecast-tbl" cellspacing="0" cellpadding="0">
        <thead>
            <tr class="wcp-openweather-forecast-header">
                <th class="wcp-openweather-primary-color"><?php _e('Day', 'wcp-openweather-theme'); ?></th>
                <th class="wcp-openweather-primary-color"><?php _e('Cond.', 'wcp-openweather-theme'); ?></th>
                <th class="wcp-openweather-primary-color wcp-openweather-forecast-item-last"><?php _e('Temp.', 'wcp-openweather-theme'); ?></th>
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
                    echo Theme::instance()->getTemplate("widget/{$template}/forecast-item", $atts);  
                    $atts['index']++;
                endforeach;
            ?>
        </tbody>
    </table>  
</div>
