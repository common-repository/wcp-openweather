<?php
    namespace Webcodin\WCPOpenWeather\Plugin;
    
    $settings = RPw()->getSettings();
    $id = $settings->getCurrentId();
?>
<div class="wcp-openweather-options">
    <div class="wcp-openweather-settings-wrapper wp-open-weather-settings">
        <a class="wcp-openweather-settings-icon wcp-openweather-primary-color inline" id="rpw-user-<?php echo $id;?>" href="#inline_content_<?php echo $id;?>"><span class="wcp-ow-icon-cog wcp-openweather-primary-color"></span></a>
        <div class="wcp-openweather-settings">
            <div id='inline_content_<?php echo $id;?>' class="wcp-openweather-settings-popup">
                <?php            
                    echo RPw()->getTemplate('user/options/layout', $settings);
                ?>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                if( /Android|iPhone|iPad|iPod|webOS|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {   
                    jQuery("#rpw-user-<?php echo $id;?>").colorbox({inline:true, width:"96%"});    
                } else {
                    jQuery("#rpw-user-<?php echo $id;?>").colorbox({inline:true, width:"50%"});    
                }
            });
        </script>    
    </div>
</div>