<?php
namespace Webcodin\WCPOpenWeather\Plugin;

$args = $params;
$exlude = RPw()->getCurrentTheme()->getExcludeUserOptions($args->settings->getCurrentTag());

if (!empty($args->fields)):
    $sections = !empty($args->fields['sections']) ? $args->fields['sections'] : array('default' => array());
    $fields = !empty($args->fields['fields']) ? $args->fields['fields'] : NULL;
    
    if (!empty($fields)) :
    
        foreach ($sections as $sk => $sv) :
        ?>
            <div class="wcp-openweather-settings-section wp-open-weather-section<?php echo !empty($sv['class']) ? ' '.$sv['class'] : '';?>">
                <?php if (!empty($sv['label'])) : ?>        
                    <span class="wcp-openweather-settings-section-title"><?php echo __( $sv['label'] , 'wcp-openweather'); ?></span>
                <?php endif; ?>                
                <?php        
                    foreach ($fields as $fk => $fv) :
                        if (!empty($fv['section']) && $fv['section'] == $sk || $sk == 'default' ) :
                            if (!empty($fv['type'])) :
                                $args->field = $fk;
                            
                                if ($fv['type'] == 'templates') {
                                    $list = $args->fieldSet[$args->fields['fields'][$args->field]['fieldSet']];
                                    $isSingleTemplate = !empty($list) && is_array($list) && count($list) == 1;
                                } else {
                                    $isSingleTemplate = FALSE;
                                }
                                
                                $hiddenField = in_array($fk, $exlude) 
                                    || $fv['type'] == 'hidden'
                                    || $fv['type'] == 'templates' && !is_admin()
                                    || $fv['type'] == 'templates' && is_admin() && $isSingleTemplate;
                                
                                $content = $args->settings->getParentModule()->getTemplate('user/options/fields/' . $fv['type'] , $args);
                                if (!empty($content)) :
                            ?>
                            <div class="wcp-openweather-settings-field wp-open-weather-field<?php echo !empty($fv['wrapper_class']) ? ' '.$fv['wrapper_class'] : '';?>"<?php echo $hiddenField  ? ' style="display: none;"' : ''; ?>>
                                <?php echo $content; ?>
                            </div>
                            <?php
                                endif;                    
                            endif;                    
                        endif;
                    endforeach;                
                ?>
            </div>
        <?php 
        endforeach;        
    endif;
endif;