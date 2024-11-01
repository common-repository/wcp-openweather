<?php 
    $args = $params;
    $label = !empty($args->fields['fields'][$args->field]['label']) ? $args->fields['fields'][$args->field]['label'] : '';
    $class = !empty($args->fields['fields'][$args->field]['class']) ? $args->fields['fields'][$args->field]['class'] : ''; 
    $note = !empty($args->fields['fields'][$args->field]['note']) ? $args->fields['fields'][$args->field]['note'] : '';    
    
    $list = $args->fieldSet[$args->fields['fields'][$args->field]['fieldSet']];
    
    $label = __( $label, 'wcp-openweather' );
    $note = __( $note, 'wcp-openweather' );            
?>
<label class="wcp-openweather-settings-label" for="<?php echo "{$args->key}[{$args->field}]"; ?>"><?php echo $label;?></label>
<select<?php echo !empty($class) ? ' class="'.$class.'"': '';?> id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>" >
    <?php 
        foreach( $list as $k => $v ):
            $selected = !empty($args->data[$args->field]) && $args->data[$args->field] == $k;
            $v = __( $v, 'wcp-openweather' );        
    ?>
            <option value="<?php echo $k; ?>"<?php selected( $selected );?>><?php echo $v;?></option>
    <?php 
        endforeach; 
    ?>
</select>
<?php if (!empty($note)): ?><p class="wp-open-weather-description"><?php echo $note;?></p><?php endif;?>