<?php
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $args = $params;
    $args->field = 'shortcodeImage';
    
    $label = !empty($args->fields['fields'][$args->field]['label']) ? $args->fields['fields'][$args->field]['label'] : '';
    $class = !empty($args->fields['fields'][$args->field]['class']) ? $args->fields['fields'][$args->field]['class'] : ''; 
    $note = !empty($args->fields['fields'][$args->field]['note']) ? $args->fields['fields'][$args->field]['note'] : '';
    
    $value = esc_attr($args->data[$args->field]);
    
    $label = __( $label, 'wcp-openweather-theme' );
    $note = __( $note, 'wcp-openweather-theme' );           
    
    $image = RPw()->getImage($value);
    if (empty($image)) {
        $image = RPw()->getAssetUrl( 'images/noimage.png' );
    }
?>
<div class="wcp-openweather-settings-field wcp-openweather-settings-column wp-open-weather-field">
    <label class="wcp-openweather-settings-label" for="<?php echo "{$args->key}[{$args->field}]"; ?>"><?php echo $label;?></label>    
    <div class="agp-upload-image-container">
        <div class="wcp-openweather-settings-image-addon">
            <div class="wcp-openweather-settings-image-addon-container">
                <input type="hidden" <?php echo !empty($class) ? ' class="'.$class.'"': '';?> id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>" value="<?php echo $value;?>">                         <a style="<?php echo empty($value) ? 'display: none' : '';?>" class="wcp-openweather-theme-btn-delete agp-upload-image-reset-button" href="javascript:void(0);" title="<?php _e('Delete Image', 'wcp-openweather-theme');?>"><span class="dashicons dashicons-trash"></span></a>
                <div class="wcp-openweather-theme-img-screenshot">
                    <img class="agp-upload-image-preview" src="<?php echo $image;?>"/>
                </div>        
                <div class="wcp-openweather-theme-action">
                    <a class="agp-upload-image-button button button-primary" href="javascript:void(0);" title="<?php _e('Upload Image', 'wcp-openweather-theme');?>"><?php _e('Upload Image', 'wcp-openweather-theme');?></a>               
                </div>    
            </div>    
        </div>    
        <?php if (!empty($note)): ?><p class="wp-open-weather-description"><?php echo $note;?></p><?php endif;?>        
    </div> 
</div>