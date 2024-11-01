<?php
    namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;

    $settings = $params;
    $plugin = RPw()->getSettings()->getPluginSettings();        
    $template = RPw()->getSettings()->getCurrentTemplatePath();
    
    $data = RPw()->getWeatherById($settings['id']);
    $weather = !empty($data['weather']) ? $data['weather'] : NULL;
    $forecast = !empty($data['forecast']) ? $data['forecast'] : NULL;

    $hasData = !empty($weather) || !empty($forecast);

    if (!empty($weather)) {
        $city = $weather->getCity()->getDisplayName();
    } elseif (!empty($forecast)) {
        $city = $forecast->getCity()->getDisplayName();
    } else {
        $city = $settings['city'];
    }
    
    $city = stripcslashes($city);

    $currentDate = RPw()->getDate( '%b %e - %a' ) ;
?>
<div id="<?php echo $settings['id']; ?>" class="wcp-openweather-default-widget wcp-openweather-default-mini wp-open-weather wpw-widget wcp-openweather-primary-background wcp-openweather-primary-color">
    <div class="wcp-openweather-header">
        <div class="wcp-openweather-header-wrapper">
            <div class="wcp-openweather-container">
                <div class="wcp-openweather-options-wrapper">
                    <?php 
                        if (!empty($settings['enableUserSettings'])) : 
                            echo RPw()->getTemplate('user/user-options', $params); 
                        endif;
                    ?> 
                    <div class="wcp-openweather-refresh wp-open-weather-refresh">
                        <a class="wcp-openweather-refresh-icon wp-open-weather-refresh-now wcp-openweather-primary-color" data-id="<?php echo $settings['id'];?>" data-tag="<?php echo $settings['tag'];?>" data-template="<?php echo $settings['template'];?>" href="javascript:void(0);" onclick="return false;"><span class="wcp-ow-icon-refresh wcp-openweather-primary-color"></span></a>
                    </div>                    
                </div>
                <div class="wcp-openweather-day-wrapper">
                    <span class="wcp-openweather-day wcp-openweather-primary-color">
                        <?php echo $currentDate; ?>
                    </span>
                </div>                
            </div>
        </div>
    </div>
    <div class="wcp-openweather-content wp-open-weather-data">
        <?php 
            if ( !$hasData ) : 
                echo Theme::instance()->getTemplate("widget/{$template}/nodata");
            else: 
        ?>
        <div class="wcp-openweather-container">
            <div class="wcp-openweather-city-wrapper">
                <span class="wcp-openweather-city"><?php echo $city;?></span>
            </div>   
            <?php 
                if ( !empty($weather) ) :
                    $weather->hideWeatherConditions = $settings['hideWeatherConditions'];
                    echo Theme::instance()->getTemplate("widget/{$template}/now", $weather);
                endif;
            ?>    
        </div>
        <?php endif; ?> 
        
        <?php 
            if (!empty($forecast)) :
                $forecast->hideWeatherConditions = $settings['hideWeatherConditions'];
                echo Theme::instance()->getTemplate("widget/{$template}/forecast", $forecast);
            endif;                
        ?>                
    </div>
</div>
