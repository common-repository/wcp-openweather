<?php 
    namespace Webcodin\WCPOpenWeather\Plugin;
    
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
    
    $list = $args->fieldSet[$args->fields['fields'][$args->field]['fieldSet']];
    
    $label = __( $label, 'wcp-openweather' );
    $note = __( $note, 'wcp-openweather' );    
?>
<tr>
    <th scope="row"><?php echo $label;?></th>
    <td>
        <select <?php echo $atts;?><?php echo !empty($class) ? ' class="'.$class.'"': '';?> id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>" >
            <?php 
                foreach( $list as $k => $v ):
                    $selected = !empty($args->data[$args->field]) && $args->data[$args->field] == $k;
                    $v = __( $v, 'wcp-openweather' );  
                    $langExists = empty($k) || RPw()->getCurrentTheme()->isLangExists($k);
                    
                    $partialLang = RPw()->getCurrentTheme()->isPartialLang($k);
                    $isPartialLang = !empty($k) && $partialLang;
                    
                    $color = '';
                    if (!$langExists && $partialLang) {
                        $color = '#ce09e8';
                    } elseif (!$langExists) {
                        $color = 'red';
                    } elseif ($partialLang) {
                        $color = 'blue';
                    }
                    
                    
            ?>
                <option<?php if (!empty($color)) : ?> style="color: <?php echo $color;?>;"<?php endif;?> value="<?php echo $k; ?>"<?php selected( $selected );?>><?php echo $v;?><?php echo $isPartialLang ? " - ({$partialLang}%)" : ''; ?><?php echo !$langExists ? ' - ' .__( 'Not supported in the current theme', 'wcp-openweather' ) : ''; ?></option>
            <?php 
                endforeach; 
            ?>
        </select>
        <?php if (!empty($note)): ?><p class="description"><?php echo $note;?></p><?php endif;?>
    </td>
</tr>    