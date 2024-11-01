<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;

    $settings = $params;
    $plugin = RPw()->getSettings()->getPluginSettings();        
    $template = RPw()->getSettings()->getCurrentTemplatePath();
    
    $data = RPw()->getWeatherById($settings['id']);
    $weather = !empty($data['weather']) ? $data['weather'] : NULL;
    $forecast = !empty($data['forecast']) ? $data['forecast'] : NULL;

    $hasData = !empty($weather) || !empty($forecast);

    if (!empty($weather)) {
        $city = $weather->getCity()->getDisplayCityName();
        $country = $weather->getCity()->getDisplayCountryName();
    } elseif (!empty($forecast)) {
        $city = $forecast->getCity()->getDisplayCityName();
        $country = $forecast->getCity()->getDisplayCountryName();
    } else {
        $city = $settings['city'];
        $country = '';
    }
    
    $city = stripcslashes($city);
    $country = stripcslashes($country);

    $currentDate = RPw()->getDate( '%b %e - %a' ) ;
?>
<div id="<?php echo $settings['id']; ?>" class="wcp-openweather-default-metro-widget wcp-openweather-default-mini wp-open-weather wpw-widget wcp-openweather-primary-background wcp-openweather-primary-color">
    <div class="wcp-openweather-default-metro-opacity wcp-openweather-primary-background-color wcp-openweather-primary-background-opacity"></div>
    <div class="wcp-openweather-default-metro-widget-container">
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
                            <div class="wcp-openweather-refresh-spinner wp-open-weather-refresh-spinner">
                                <img src="<?php echo RPw()->getAssetUrl('images/spinner.gif');?>"/>
                            </div>
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
            <div class="wcp-openweather-container">
                <?php 
                    if ( !$hasData ) : 
                        echo Theme::instance()->getTemplate("widget/{$template}/nodata");
                    else: 
                ?>
                
                <div class="wcp-openweather-city-wrapper">
                    <span class="wcp-openweather-city"><?php echo $city;?></span>
                    <span class="wcp-openweather-country"><?php echo $country;?></span>
                </div>   
                <?php 
                    if ( !empty($weather) ) :
                        $weather->hideWeatherConditions = $settings['hideWeatherConditions'];
                        echo Theme::instance()->getTemplate("widget/{$template}/now", $weather);
                    endif;
                ?>   
                
                <?php endif; ?> 

                <?php 
                    if (!empty($forecast)) :
                        $forecast->hideWeatherConditions = $settings['hideWeatherConditions'];
                        echo Theme::instance()->getTemplate("widget/{$template}/forecast", $forecast);
                    endif;                
                ?>                
            </div>
        </div>
    </div>
</div>
