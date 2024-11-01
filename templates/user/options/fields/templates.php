<?php 
    $args = $params;
    $label = !empty($args->fields['fields'][$args->field]['label']) ? $args->fields['fields'][$args->field]['label'] : '';
    $class = !empty($args->fields['fields'][$args->field]['class']) ? $args->fields['fields'][$args->field]['class'] : ''; 
    $note = !empty($args->fields['fields'][$args->field]['note']) ? $args->fields['fields'][$args->field]['note'] : '';    
    
    $list = $args->fieldSet[$args->fields['fields'][$args->field]['fieldSet']];
    
    $value = esc_attr($args->data[$args->field]);
    
    $label = __( $label, 'wcp-openweather' );
    $note = __( $note, 'wcp-openweather' );            
?>
<label class="wcp-openweather-settings-label" for="<?php echo "{$args->key}[{$args->field}]"; ?>"><?php echo $label;?></label>
<?php if (is_admin()) :?>
<select<?php echo !empty($class) ? ' class="'.$class.'"': '';?> id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>" >
    <?php 
        foreach( $list as $k => $v ):
            $selected = !empty($value) && $value == $k;
            $v = __( $v, 'wcp-openweather' );        
    ?>
            <option <?php selected( $selected );?> value="<?php echo $k; ?>"><?php echo $v;?></option>
    <?php 
        endforeach; 
    ?>
</select>
<?php else: ?>
<input<?php echo !empty($class) ? ' class="'.$class.'"': '';?> type="text" name="<?php echo "{$args->key}[{$args->field}]"; ?>" value="<?php echo $value;?>">                
<?php endif; ?>
<?php if (!empty($note)): ?><p class="wp-open-weather-description"><?php echo $note;?></p><?php endif;?>