<?php
    $args = $params;
    $args->field = 'useDefaultSettings';
    
    $label = __( 'Use default plugin settings', 'wcp-openweather-theme');
    
?>
<div class="wcp-openweather-settings-section wp-open-weather-section wcp-openweather-settings-addon wcp-openweather-settings-options">
    <div class="wcp-openweather-settings-field wp-open-weather-field">
        <input class="wcp-openweather-settings-use-defaults" type="checkbox" id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>">                
        <label class="wcp-openweather-settings-label" for="<?php echo "{$args->key}[{$args->field}]"; ?>"><?php echo $label;?></label>        
    </div>
</div>

