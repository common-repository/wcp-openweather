<?php 
    $args = $params;
    $label = !empty($args->fields['fields'][$args->field]['label']) ? $args->fields['fields'][$args->field]['label'] : '';
    $class = !empty($args->fields['fields'][$args->field]['class']) ? $args->fields['fields'][$args->field]['class'] : ''; 
    $note = !empty($args->fields['fields'][$args->field]['note']) ? $args->fields['fields'][$args->field]['note'] : '';
    
    $value = esc_attr($args->data[$args->field]);
    
    $label = __( $label, 'wcp-openweather' );
    $note = __( $note, 'wcp-openweather' );       
?>
<input<?php echo !empty($class) ? ' class="'.$class.'"': '';?> type="hidden" id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>" value="<?php echo $value;?>">                
