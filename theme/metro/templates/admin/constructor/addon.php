<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $args = $params;
    $args->fields = RPw()->getCurrentTheme()->getSettings()->getFields('rpw-theme-metro-settings');    
    $args->data = RPw()->getCurrentTheme()->getSettings()->getSettings('rpw-theme-metro-settings');
?>
<div class="wcp-openweather-settings-section wp-open-weather-section wcp-openweather-settings-addon wcp-openweather-settings-theme-addon">
    <span class="wcp-openweather-settings-section-title"><?php _e('Theme Settings', 'wcp-openweather');?></span>    
    <?php echo RPw()->getCurrentTheme()->getTemplate('admin/constructor/fields/shortcodeImage', $args); ?>
    <div class="wcp-openweather-settings-column wcp-openweather-settings-last">
        <?php echo RPw()->getCurrentTheme()->getTemplate('admin/constructor/fields/text_color', $args); ?>
        <?php echo RPw()->getCurrentTheme()->getTemplate('admin/constructor/fields/background_color', $args); ?>
        <?php echo RPw()->getCurrentTheme()->getTemplate('admin/constructor/fields/background_opacity', $args); ?>
    </div>    
</div>

