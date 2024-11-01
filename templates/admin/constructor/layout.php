<?php 
    namespace Webcodin\WCPOpenWeather\Plugin;
    
    $args = new \stdClass();
    $args->settings = $params;
    $args->id = $args->settings->getCurrentId();    
    $args->key = 'global-settings';
    $args->fieldSet = $args->settings->getFieldSet();
    $args->fields = $args->settings->getFields($args->key);
    $args->data = $args->settings->getWeatherSettings();
?>
<span class="wcp-openweather-settings-title"><?php _e('WCP OpenWeather Shortcode','wcp-openweather'); ?></span>
<div class="wcp-constructor-wrapper">
    
    <div class="wcp-constructor-params">
        <form id="wcp-openweather-constructor-params" class="wcp-openweather-settings-form" method="post" action="">
            <input type="hidden" name="global-settings[id]" value="<?php echo $args->id;?>">
            <?php RPw()->getCurrentTheme()->getThemeConstructorBeforeRender($args); ?>
            <div class="wcp-openweather-settings-container">
                <?php echo RPw()->getTemplate('user/options/render-page', $args); ?>
                <?php RPw()->getCurrentTheme()->getThemeConstructorAddon($args); ?>                
            </div>
        </form>
    </div>
    
    <div class="wcp-constructor-controls wcp-openweather-settings-actions">
        <a class="wcp-constructor-apply wcp-openweather-settings-btn" href="javascript:void(0);" title="<?php _e('Add','wcp-openweather'); ?>"><?php _e('Add','wcp-openweather'); ?></a>
    </div>         
</div>


