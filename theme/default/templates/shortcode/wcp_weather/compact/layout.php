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
    
    $currentDate = RPw()->getDate( '%b %e, %Y - %a' ) ;
?>
<div id="<?php echo $settings['id']; ?>" class="wcp-openweather-default-shortcode wcp-openweather-default-compact wp-open-weather wpw-shortcode wcp-openweather-primary-background wcp-openweather-primary-color">
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
                echo Theme::instance()->getTemplate("shortcode/{$template}/nodata");  
            else:
        ?>
        <div class="wcp-openweather-container">
            <table class="wcp-openweather-content-tbl wcp-openweather-primary-color" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="wcp-openweather-city-wrapper<?php echo (!empty($forecast) && empty($weather)) ? ' wcp-openweather-city-wrapper-forecast' : '';?>">                        
                         <span class="wcp-openweather-city"><?php echo $city;?></span>                                  
                    </td>   
                    <?php 
                        if ( !empty($weather) ) :
                            $weather->hideWeatherConditions = $settings['hideWeatherConditions'];
                            echo Theme::instance()->getTemplate("shortcode/{$template}/now", $weather);
                        endif;
                    ?>  
                </tr>
            </table>
        </div>
        <?php endif; ?> 
        
        <?php 
            if (!empty($forecast)) :
                $forecast->hideWeatherConditions = $settings['hideWeatherConditions'];
                echo Theme::instance()->getTemplate("shortcode/{$template}/forecast", $forecast);
            endif;                
        ?>
    </div>
</div>
