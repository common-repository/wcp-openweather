<?php
$args = $params;
if (!empty($args->fields)):
    $sections = !empty($args->fields['sections']) ? $args->fields['sections'] : array('default' => array());
    $fields = !empty($args->fields['fields']) ? $args->fields['fields'] : NULL;
    
    if (!empty($fields)) :
    
        foreach ($sections as $sk => $sv) : ?>
        <div class="wcp-settings-content">
            <div class="wcp-settings-title"> 
            <?php if (!empty($sv['label'])) :
            ?>        
                <h3>
                    <?php echo __( $sv['label'] , 'wcp-openweather'); ?>
                </h3>
            <?php
            endif;
            ?>
            </div>
            <div class="wcp-settings-inner-table">
            <table class="form-table">
                <tbody>
                <?php        
                    foreach ($fields as $fk => $fv) :
                        if (!empty($fv['section']) && $fv['section'] == $sk || $sk == 'default' ) :
                            if (!empty($fv['type'])) :
                                $args->field = $fk;
                                echo $args->settings->getParentModule()->getTemplate('admin/options/fields/' . $fv['type'] , $args);
                            endif;                    
                        endif;
                    endforeach;                
                ?>
                </tbody>        
            </table>                
            </div>    
        </div>    
            <?php 
        endforeach;        
    endif;
endif;