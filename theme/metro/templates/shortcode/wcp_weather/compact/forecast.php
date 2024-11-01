<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $data = $params;
    $template = RPw()->getSettings()->getCurrentTemplatePath();
?>
<div class="wcp-openweather-forecast-wrapper wp-open-weather-forecast">
    
    <div class="wcp-openweather-forecast-header wp-open-weather-forecast-header">
        <div class="wcp-openweather-container">
            <?php 
                foreach ($data->getAll() as $key => $item) :
                    echo Theme::instance()->getTemplate("shortcode/{$template}/forecast-header-item", $item);  
                endforeach;
            ?>
        </div>
    </div>

    <div class="wcp-openweather-forecast-content wp-open-weather-forecast">
        <div class="wcp-openweather-container">
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
        </div>
    </div>    

</div>
