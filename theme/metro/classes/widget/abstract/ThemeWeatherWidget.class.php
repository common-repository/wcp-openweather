<?php
namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;

use Webcodin\WCPOpenWeather\Plugin\WeatherWidgetAbstract;

class ThemeWeatherWidget extends WeatherWidgetAbstract {
    
    public function form( $instance ) {    
        parent::form( $instance );
        
        $fields = RPw()->getCurrentTheme()->getSettings()->getFields('rpw-theme-metro-settings');
        $settings = RPw()->getCurrentTheme()->getSettings()->getSettings('rpw-theme-metro-settings');
        
        $text_color = isset($instance['text_color']) ? $instance['text_color'] : (!empty($settings['text_color']) ? $settings['text_color'] : $fields['fields']['text_color']['default']);  
        //$background_image = isset($instance['background_image']) ? $instance['background_image'] : (!empty($settings['widgetImage']) ? $settings['widgetImage'] : $fields['fields']['widgetImage']['default']);
        $background_image = isset($instance['background_image']) ? $instance['background_image'] : (!empty($settings['widgetImage']) ? $settings['widgetImage'] : '');
        $background_color = isset($instance['background_color']) ? $instance['background_color'] : (!empty($settings['background_color']) ? $settings['background_color'] : $fields['fields']['background_color']['default']);  
        $background_opacity = isset($instance['background_opacity']) ? $instance['background_opacity'] : (!empty($settings['background_opacity']) ? $settings['background_opacity'] : $fields['fields']['background_opacity']['default']);  
        
        $this->renderBackgroundImageField($background_image);
        $this->renderTextColorField($text_color);
        $this->renderBackgroundColorField($background_color);
        $this->renderBackgroundOpacityField($background_opacity);
    }
    
    public function update( $new_instance, $old_instance ) {    
        $instance = parent::update($new_instance, $old_instance);
        $instance['background_image'] = (!empty($new_instance['background_image'])) ? strip_tags( $new_instance['background_image'] ) : '';
        $instance['text_color'] = (!empty($new_instance['text_color'])) ? $new_instance['text_color'] : '';
        $instance['background_color'] = (!empty($new_instance['background_color'])) ? $new_instance['background_color'] : '';
        $instance['background_opacity'] = (!empty($new_instance['background_opacity'])) ? $new_instance['background_opacity'] : '0';
        
        return $instance;
    }
    
    public function renderBackgroundImageField ($value) {
        $image = RPw()->getImage($value);
        if (empty($image)) {
            $image = RPw()->getAssetUrl( 'images/noimage.png' );
        }        
    ?>
        <div class="wcp-openweather-settings-field wcp-openweather-settings-field-widget" >
            <label for="<?php echo $this->get_field_name( 'background_image' ); ?>"><?php echo __( 'Image', 'wcp-openweather-theme' ) . ':'; ?></label>
            <div class="wcp-openweather-settings-image-addon agp-upload-image-container">
                <div class="wcp-openweather-settings-image-addon-container">
                    <input name="<?php echo $this->get_field_name( 'background_image' ); ?>" id="<?php echo $this->get_field_id( 'background_image' ); ?>" class="widefat agp-upload-image" type="hidden" value="<?php echo $value; ?>" />
                    <a style="<?php echo empty($value) ? 'display: none' : '';?>" class="wcp-openweather-theme-btn-delete agp-upload-image-reset-button" href="javascript:void(0);" title="<?php _e('Delete Image', 'wcp-openweather-theme');?>"><span class="dashicons dashicons-trash"></span></a>
                    <div class="wcp-openweather-theme-img-screenshot">
                        <img class="agp-upload-image-preview" src="<?php echo $image;?>"/>
                    </div>
                    <div class="wcp-openweather-theme-action">
                        <a class="agp-upload-image-button button button-primary" href="javascript:void(0);" title="<?php _e('Upload Image', 'wcp-openweather-theme');?>"><?php _e('Upload Image', 'wcp-openweather-theme');?></a> 
                    </div>
                </div>
            </div>
        </div>
    <?php    
    }        
    
    public function renderTextColorField ($value) {
    ?>
        <div class="wcp-openweather-settings-field wcp-openweather-settings-field-widget" >
            <label for="<?php echo $this->get_field_name( 'text_color' ); ?>"><?php echo __( 'Text Color', 'wcp-openweather-theme' ) . ':'; ?></label>
            <div class="wcp-openweather-settings-field-input">
                <input class="widefat rpw-widget-color-picker" id="<?php echo $this->get_field_id( 'text_color' ); ?>" name="<?php echo $this->get_field_name( 'text_color' ); ?>" type="text" value="<?php echo $value; ?>">
            </div>
            <script type='text/javascript'>
                jQuery('.widgets-sortables .rpw-widget-color-picker').wpColorPicker();                                        
            </script>                          
        </div>
    <?php        
    }

    public function renderBackgroundColorField ($value) {
    ?>
        <div class="wcp-openweather-settings-field wcp-openweather-settings-field-widget" >
            <label for="<?php echo $this->get_field_name( 'background_color' ); ?>"><?php echo __( 'Background Color', 'wcp-openweather-theme' ) . ':'; ?></label>
            <div class="wcp-openweather-settings-field-input">
                <input class="widefat rpw-widget-color-picker" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" type="text" value="<?php echo $value; ?>">  
            </div>
            <script type='text/javascript'>
                jQuery('.widgets-sortables .rpw-widget-color-picker').wpColorPicker();                                        
            </script>                          
        </div>
    <?php        
    }    
    

    public function renderBackgroundOpacityField ($value) {
    ?>
        <div class="wcp-openweather-settings-field wcp-openweather-settings-field-widget" >
            <label for="<?php echo $this->get_field_name( 'background_opacity' ); ?>"><?php echo __( 'Background Opacity, %', 'wcp-openweather-theme' ) . ':'; ?></label>
            <div class="wcp-openweather-settings-field-input">
            <input min="0" max="100" class="widefat" id="<?php echo $this->get_field_id( 'background_opacity' ); ?>" name="<?php echo $this->get_field_name( 'background_opacity' ); ?>" type="number" value="<?php echo $value; ?>">  
            </div>
        </div>
    <?php        
    }        
    
}

    