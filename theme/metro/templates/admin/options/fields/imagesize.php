<?php 
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

    $value = $args->data[$args->field];
    
    $label = __( $label, 'wcp-openweather-theme' );
    $note = __( $note, 'wcp-openweather-theme' );    
?>
<tr>
    <th scope="row"><?php echo $label;?></th>
    <td class="wcp-field-imagesize">
        <label for="<?php echo "{$args->key}[{$args->field}][width]"; ?>"><?php _e( 'Width', 'wcp-openweather-theme' ); ?></label>
        <input min="0" step="1" type="number" class="small-text" name="<?php echo "{$args->key}[{$args->field}][width]"; ?>" value="<?php echo $value['width'];?>"  />                        
        <label for="<?php echo "{$args->key}[{$args->field}][height]"; ?>"><?php _e( 'Height', 'wcp-openweather-theme' ); ?></label>                        
        <input min="0" step="1" type="number" class="small-text" name="<?php echo "{$args->key}[{$args->field}][height]"; ?>" value="<?php echo $value['height'];?>"  />
        <div class="wcp-field-settings-row">
            <input type="checkbox" value="1" name="<?php echo "{$args->key}[{$args->field}][crop]"; ?>" <?php echo checked( 1, (isset($value['crop'])) ? 1 : '' , false ); ?> >
            <label for="<?php echo "{$args->key}[{$args->field}][crop]"; ?>"><?php _e( 'Crop thumbnail to exact dimensions', 'wcp-openweather-theme' ); ?></label>                      
        </div>
        <?php if (!empty($note)): ?><p class="description"><?php echo $note;?></p><?php endif;?>        
    </td>
</tr>    
