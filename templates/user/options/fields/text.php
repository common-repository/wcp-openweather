<?php 
    $args = $params;
    $label = !empty($args->fields['fields'][$args->field]['label']) ? $args->fields['fields'][$args->field]['label'] : '';
    $class = !empty($args->fields['fields'][$args->field]['class']) ? $args->fields['fields'][$args->field]['class'] : ''; 
    $note = !empty($args->fields['fields'][$args->field]['note']) ? $args->fields['fields'][$args->field]['note'] : '';
    
    $value = esc_attr($args->data[$args->field]);
    
    $label = __( $label, 'wcp-openweather' );
    $note = __( $note, 'wcp-openweather' );        
?>
<label class="wcp-openweather-settings-label" for="<?php echo "{$args->key}[{$args->field}]"; ?>"><?php echo $label;?></label>
<input<?php echo !empty($class) ? ' class="'.$class.'"': '';?> type="text" id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>" value="<?php echo $value;?>">                
<?php if (!empty($note)): ?><p class="wp-open-weather-description"><?php echo $note;?></p><?php endif;?>
