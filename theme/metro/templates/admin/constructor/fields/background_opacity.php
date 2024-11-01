<?php 
    $args = $params;
    $args->field = 'background_opacity';
    
    $label = !empty($args->fields['fields'][$args->field]['label']) ? $args->fields['fields'][$args->field]['label'] : '';
    $class = !empty($args->fields['fields'][$args->field]['class']) ? $args->fields['fields'][$args->field]['class'] : ''; 
    $note = !empty($args->fields['fields'][$args->field]['note']) ? $args->fields['fields'][$args->field]['note'] : '';    
    
    $value = esc_attr($args->data[$args->field]);
    
    $label = __( $label, 'wcp-openweather-theme' );
    $note = __( $note, 'wcp-openweather-theme' );    
?>
<div class="wcp-openweather-settings-field wp-open-weather-field">
    <label class="wcp-openweather-settings-label" for="<?php echo "{$args->key}[{$args->field}]"; ?>"><?php echo $label;?></label>
    <div class="wcp-openweather-settings-field-input">
    <input min="0" max="100" <?php echo !empty($class) ? ' class="'.$class.'"': '';?> type="number" id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>" value="<?php echo $value;?>">       </div>         
    <?php if (!empty($note)): ?><p class="wp-open-weather-description"><?php echo $note;?></p><?php endif;?>    
</div>
