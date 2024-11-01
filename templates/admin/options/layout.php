<?php 
    namespace Webcodin\WCPOpenWeather\Plugin;
    
    $args = new \stdClass();
    $args->settings = $params;
    $args->key = isset( $_GET['tab'] ) ? $_GET['tab'] : 'global-settings';
    $args->tabs = $args->settings->getTabs();
    $args->fieldSet = $args->settings->getFieldSet();
    $args->data = $args->settings->getSettings($args->key);
    $args->fields = $args->settings->getFields($args->key);
    $title = !empty($args->settings->getConfig()->admin->options->title) ? $args->settings->getConfig()->admin->options->title : '';
?>
<?php if (!empty($title)) :?>
<div class="wcp-openweather-headline">
    <table>
        <tr>
            <td class="wcp-openweather-headline-icon">                                                                                          
                <img src="<?php echo RPw()->getAssetUrl( 'images/icons/icon-128x128.png' ); ?>" alt="" width="128" height="128" />    
            </td>
            <td class="wcp-openweather-headline-info">
                <h1><?php _e($title,'wcp-openweather'); ?></h1>
                <p><?php _e('WCP OpenWeather plugin allows you to add various widgets and shortcodes with current weather or forecast for your city and supports several themes.', 'wcp-openweather');?></p>
                <p><?php _e('If you really like our plugin, please <a class="scfp-plugin-headline-rate" title="Rate Our Plugin" target="blank" href="https://wordpress.org/support/view/plugin-reviews/wcp-openweather?filter=5#postform">rate us</a>!', 'wcp-openweather');?></p>
            </td>
            <?php echo RPw()->getTemplate('admin/options/layout-headline-links', $args); ?>
        </tr>
    </table>
</div>
<?php endif;?>

<div class="wrap wcp-openweather-form-wrap">
    <?php 
        screen_icon();
        settings_errors();
        
        echo $args->settings->getParentModule()->getTemplate('admin/options/render-tabs', $args);
    ?>
    <form method="post" action="options.php">
        <?php wp_nonce_field( 'update-options' ); ?>
        <?php settings_fields( $args->key ); ?>
        
        <?php echo $args->settings->getParentModule()->getTemplate('admin/options/render-page', $args); ?>
        
        <p class="submit">
            <input id="submit" class="button button-primary" type="submit" value="<?php _e('Save Changes','wcp-openweather'); ?>" name="submit">
            <a class="button button-primary" href="?page=<?php echo $args->settings->getPage();?>&tab=<?php echo $args->key;?>&reset-settings=true" ><?php _e('Reset to Default','wcp-openweather'); ?></a>
        </p>
    </form>
</div>