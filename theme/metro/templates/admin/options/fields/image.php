<?php 
    namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;
    
    $args = $params;
    $label = !empty($args->fields['fields'][$args->field]['label']) ? $args->fields['fields'][$args->field]['label'] : '';
    $class = !empty($args->fields['fields'][$args->field]['class']) ? $args->fields['fields'][$args->field]['class'] : ''; 
    $note = !empty($args->fields['fields'][$args->field]['note']) ? $args->fields['fields'][$args->field]['note'] : '';
    $atts = !empty($args->fields['fields'][$args->field]['atts']) ? $args->fields['fields'][$args->field]['atts'] : '';
    if (is_array($atts)) {
        $atts_s = '';
        foreach ($atts as $key => $value) {
            $atts_s .= $key . '="' . $value . '"';
        }
        $atts = $atts_s;
    }
    
    $value = esc_attr($args->data[$args->field]);
    
    $label = __( $label, 'wcp-openweather-theme' );
    $note = __( $note, 'wcp-openweather-theme' );    
    
    
    $image = RPw()->getImage($value);
    if (empty($image)) {
        $image = RPw()->getAssetUrl( 'images/noimage.png' );
    }
?>
<tr>
    <th scope="row"><?php echo $label;?></th>
    <td class="agp-upload-image-container">
        <input type="hidden" <?php echo $atts;?><?php echo !empty($class) ? ' class="'.$class.'"': '';?> id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>" value="<?php echo $value;?>">   
        <div class="wcp-openweather-settings-image-addon">
            <div class="wcp-openweather-settings-image-addon-container">
                <a style="<?php echo empty($value) ? 'display: none' : '';?>" class="wcp-openweather-theme-btn-delete agp-upload-image-reset-button" href="javascript:void(0);" title="<?php _e('Delete Image', 'wcp-openweather-theme');?>"><span class="dashicons dashicons-trash"></span></a> 
                <div class="wcp-openweather-theme-img-screenshot">
                    <img class="agp-upload-image-preview" src="<?php echo $image;?>"/>
                </div>    
                <div class="wcp-openweather-theme-action">
                    <a class="agp-upload-image-button button button-primary" href="javascript:void(0);" title="<?php _e('Upload Image', 'wcp-openweather-theme');?>"><?php _e('Upload Image', 'wcp-openweather-theme');?></a>            
                </div>
            </div>
        </div>
        <?php if (!empty($note)): ?><p class="description"><?php echo $note;?></p><?php endif;?> 
    </td>
</tr>    
