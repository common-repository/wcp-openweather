<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $data = $params;
    $template = RPw()->getSettings()->getCurrentTemplatePath();
?>
<div class="wcp-openweather-forecast-wrapper">
    <div class="wcp-openweather-forecast-header wp-open-weather-forecast-header">        
        <?php 
            foreach ($data->getAll() as $key => $item) :
                echo Theme::instance()->getTemplate("widget/{$template}/forecast-header-item", $item);  
            endforeach;
        ?>        
    </div>

    <div class="wcp-openweather-forecast-content wp-open-weather-forecast">        
        <?php 
            foreach ($data->getAll() as $key => $item) :
                $item->hideWeatherConditions = $data->hideWeatherConditions;
                echo Theme::instance()->getTemplate("widget/{$template}/forecast-item", $item);  
            endforeach;
        ?>
    </div>
</div>
