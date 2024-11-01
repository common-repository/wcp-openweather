<?php 
    namespace Webcodin\WCPOpenWeather\Plugin;
    
    $args = new \stdClass();
    $args->settings = $params;
    $args->id = $args->settings->getCurrentId();    
    $args->key = 'global-settings';
    $args->fieldSet = $args->settings->getFieldSet();
    $args->fields = $args->settings->getFields($args->key);
    $args->data = RPw()->getSettingsById($args->id);
?>
<span class="wcp-openweather-settings-title"><?php _e('Options','wcp-openweather'); ?></span>
<form class="wcp-openweather-settings-form" method="post" action="">
    <input type="hidden" name="action" value="setUserOptions">
    <input type="hidden" name="id" value="<?php echo $args->id;?>">
    
    <?php echo RPw()->getTemplate('user/options/render-page', $args); ?>
    
    <div class="wcp-openweather-settings-actions">
        <a class="wcp-openweather-settings-btn wcp-openweather-settings-submit" href="javascript:void(0);" ><?php _e('Save & Refresh','wcp-openweather'); ?></a>        
        <a class="wcp-openweather-settings-btn" href="<?php echo add_query_arg(array('reset-settings' => $args->id));?>" ><?php _e('Reset to Default','wcp-openweather'); ?></a>
    </div>
</form>
