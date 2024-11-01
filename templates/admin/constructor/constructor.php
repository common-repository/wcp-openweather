<?php
    namespace Webcodin\WCPOpenWeather\Plugin;
    
    $settings = RPw()->getSettings();
    $id = uniqid();
    $settings->setCurrentId($id);
?>
<div class="" style='display:none'>
    <a class='inline' id="rpw-constructor-box" href="#rpw_inline_content">Options</a>
    <div style='display:none'>
        <div id='rpw_inline_content' class="wcp-openweather-settings-popup">
            <?php 
                echo RPw()->getTemplate('admin/constructor/layout', $settings);
            ?>
        </div>
    </div>
    <script type="text/javascript">
        initAutocomplete();
    </script>
</div>
