<?php
namespace Webcodin\WCPOpenWeather\Plugin;

class WeatherWidgetAbstract extends \WP_Widget {
    
    private $widgetTag = '';
    
    private $widgetTemplates;
    
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct($id_base, $name, $widget_options = array(), $control_options = array()) {
        $this->widgetTag = $id_base;
        $this->setWidgetTemplates( RPw()->getCurrentTheme()->getSettings()->getFieldSet("{$this->getWidgetTag()}_templates"));
        parent::__construct($id_base, $name, $widget_options, $control_options);
	}
    
	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if (!empty( $instance['title'])) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        
        $atts = $instance;
        $atts['id'] = 'wcp-' . $this->id;
        $atts['enableUserSettings'] = !empty($instance['enableUserSettings']) ? 1 : 0;
        $atts['hideWeatherConditions'] = !empty($instance['hideWeatherConditions']) ? 1 : 0;
        if (empty($atts['city_data'])) {
            $atts['city_data'] = '';
        }
        
        $atts['template'] = !empty($atts['template']) && array_key_exists($atts['template'], $this->widgetTemplates) ? $atts['template'] : 'default';
        
        echo RPw()->getCurrentTheme()->doWidget($atts, $this->getWidgetTag(), $atts['template']);
        
        echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
        $defaults = RPw()->getSettings()->getWeatherSettings();
        $templateList = $this->getWidgetTemplates();
        
		$title = !empty($instance['title']) ? $instance['title'] : '';
        $template = !empty($instance['template']) ? $instance['template'] : '';
        $city = !empty($instance['city']) ? $instance['city'] : $defaults['city'];
        $city_data = !empty($instance['city_data']) ? $instance['city_data'] : $defaults['city_data'];
        $showCurrentWeather = empty($instance) && !empty($defaults['showCurrentWeather']) || !empty($instance['showCurrentWeather']) ? 1 : 0;
        $showForecastWeather = empty($instance) && !empty($defaults['showForecastWeather']) || !empty($instance['showForecastWeather']) ? 1 : 0;
        $tempUnit = !empty($instance['tempUnit']) ? $instance['tempUnit'] : '';        
        $windSpeedUnit = !empty($instance['windSpeedUnit']) ? $instance['windSpeedUnit'] : '';  
        $pressureUnit = !empty($instance['pressureUnit']) ? $instance['pressureUnit'] : '';  
        $enableUserSettings = !empty($instance['enableUserSettings']) ? 1 : 0;        
        $hideWeatherConditions = !empty($instance['hideWeatherConditions']) ? 1 : 0;        
        $uniqueId = !empty($instance['uniqueId']) ? $instance['uniqueId'] : $defaults['uniqueId'];        
        
        $isSingleTemplate = !empty($templateList) && is_array($templateList) && count($templateList) == 1;
    ?>
        <p><?php $this->renderTitleField($title); ?></p>
        <p><?php $this->renderCityField($city); ?></p>
        <p><?php $this->renderCityDataField($city_data); ?></p>
        <p><?php $this->renderTempUnitField($tempUnit); ?></p>        
        <p><?php $this->renderWindSpeedUnitField($windSpeedUnit); ?></p>   
        <p><?php $this->renderPressureUnitField($pressureUnit); ?></p>           
        <p><?php $this->renderShowCurrentWeatherField($showCurrentWeather); ?></p>
        <p><?php $this->renderShowForecastWeatherField($showForecastWeather); ?></p>
        <p><?php $this->renderEnableUserSettingsField($enableUserSettings); ?></p>        
        <p><?php $this->renderHideWeatherConditionsField($hideWeatherConditions); ?></p>                
        <p<?php echo ($isSingleTemplate) ? ' style="display: none;"' : '';?>>
            <?php $this->renderTemplateField($template); ?>
        </p>
        
        <?php $this->renderUniqueIdField($uniqueId); ?>
        <?php $this->initAutocomplete(); ?>
    <?php    
	}
    
    
	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
        
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags( $new_instance['title'] ) : '';
        $instance['template'] = (!empty($new_instance['template'])) ? strip_tags( $new_instance['template'] ) : 'default';
        $instance['city'] = (!empty($new_instance['city'])) ? strip_tags( $new_instance['city'] ) : '';
        $instance['city_data'] = (!empty($new_instance['city_data'])) ? strip_tags( $new_instance['city_data'] ) : '';
        $instance['showCurrentWeather'] = (!empty($new_instance['showCurrentWeather'])) ? 1 : 0;        
        $instance['showForecastWeather'] = (!empty($new_instance['showForecastWeather'])) ? 1 : 0;        
        $instance['tempUnit'] = (!empty($new_instance['tempUnit'])) ? strip_tags( $new_instance['tempUnit'] ) : '';
        $instance['windSpeedUnit'] = (!empty($new_instance['windSpeedUnit'])) ? strip_tags( $new_instance['windSpeedUnit'] ) : '';
        $instance['pressureUnit'] = (!empty($new_instance['pressureUnit'])) ? strip_tags( $new_instance['pressureUnit'] ) : '';
        $instance['enableUserSettings'] = (!empty($new_instance['enableUserSettings'])) ? 1 : 0;                
        $instance['hideWeatherConditions'] = (!empty($new_instance['hideWeatherConditions'])) ? 1 : 0;                        
        $instance['uniqueId'] = uniqid();
        
		return $instance;
	}    
    
    public function renderTitleField ($title) {
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo __( 'Title', 'wcp-openweather' ) . ':'; ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">    
    <?php    
    }    
    
    public function renderTemplateField ($template) {
        $templateList = $this->getWidgetTemplates();
        $template = !empty($template) ? $template : 'default';
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>"><?php echo __( 'Template', 'wcp-openweather' ) . ':'; ?></label> 
        
        <select id="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>" class="template-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'template' ) ); ?>">
        <?php 
            foreach ( $templateList as $key => $item ) : 
            //$item = __( $item, 'wcp-openweather' );
        ?>
            <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $template, $key ); ?>><?php echo $item; ?></option>
        <?php endforeach; ?>
        </select>        
    <?php    
    }    
    
    public function renderShowCurrentWeatherField ($showCurrentWeather) {
        $showCurrentWeather = !empty($showCurrentWeather) ? 1 : 0;        
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'showCurrentWeather' ); ?>" name="<?php echo $this->get_field_name( 'showCurrentWeather' ); ?>" <?php checked( $showCurrentWeather ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'showCurrentWeather' ) ); ?>"><?php _e( 'Show current weather', 'wcp-openweather' ); ?></label>         
    <?php    
    }    
    
    public function renderShowForecastWeatherField ($showForecastWeather) {
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'showForecastWeather' ); ?>" name="<?php echo $this->get_field_name( 'showForecastWeather' ); ?>" <?php checked( $showForecastWeather ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'showForecastWeather' ) ); ?>"><?php _e( 'Show 5 day forecast', 'wcp-openweather' ); ?></label>         
    <?php    
    }        
    
    public function renderCityField ($city) {
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'city' ) ); ?>"><?php echo __( 'City Name', 'wcp-openweather' ) . ':'; ?></label> 
		<input class="widefat rpw-gm-city" id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" type="text" value="<?php echo esc_attr( $city ); ?>">    
        <span class="description"><?php _e('You can find you city name on <a href="http://www.openweathermap.com/" title="http://www.openweathermap.com/" target="_blank">www.openweathermap.com</a>.', 'wcp-openweather'); ?></span>
    <?php    
    }        
    
    public function renderCityDataField ($city_data) {
    ?>
        <input class="widefat rpw-gm-city-data" id="<?php echo $this->get_field_id( 'city_data' ); ?>" name="<?php echo $this->get_field_name( 'city_data' ); ?>" type="hidden" value="<?php echo esc_attr( $city_data ); ?>">    
    <?php    
    }            
    
    public function renderTempUnitField ($tempUnit) {
        $tempList = RPw()->getSettings()->getFieldSet('temp');
        $fields = RPw()->getSettings()->getWeatherSettings();
        $default = $fields['tempUnit'];
        $tempUnit = !empty($tempUnit) ? $tempUnit : $default;
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'tempUnit' ) ); ?>"><?php echo __( 'Temperature', 'wcp-openweather' ) . ':'; ?></label> 
        
        <select id="<?php echo esc_attr( $this->get_field_id( 'tempUnit' ) ); ?>" class="temperature-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'tempUnit' ) ); ?>">
        <?php 
            foreach ( $tempList as $key => $item ) : 
            $item = __( $item, 'wcp-openweather' );
        ?>
            <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $tempUnit, $key ); ?>><?php echo $item; ?></option>
        <?php endforeach; ?>
        </select>        
    <?php    
    }            
    
    public function renderWindSpeedUnitField ($windSpeedUnit) {
        $windSpeedUnitList = RPw()->getSettings()->getFieldSet('windSpeed');
        $fields = RPw()->getSettings()->getWeatherSettings();
        $default = $fields['windSpeedUnit'];
        $windSpeedUnit = !empty($windSpeedUnit) ? $windSpeedUnit : $default;        
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'windSpeedUnit' ) ); ?>"><?php echo __( 'Wind Speed', 'wcp-openweather' ) . ':'; ?></label> 
        
        <select id="<?php echo esc_attr( $this->get_field_id( 'windSpeedUnit' ) ); ?>" class="windspeed-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'windSpeedUnit' ) ); ?>">
        <?php 
            foreach ( $windSpeedUnitList as $key => $item ) : 
            $item = __( $item, 'wcp-openweather' );
        ?>
            <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $windSpeedUnit, $key ); ?>><?php echo $item; ?></option>
        <?php endforeach; ?>
        </select>        
    <?php    
    }                
    
    public function renderPressureUnitField ($pressureUnit) {
        $pressureUnitList = RPw()->getSettings()->getFieldSet('pressure');
        $fields = RPw()->getSettings()->getWeatherSettings();
        $default = $fields['pressureUnit'];
        $pressureUnit = !empty($pressureUnit) ? $pressureUnit : $default;                
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'pressureUnit' ) ); ?>"><?php echo __( 'Pressure', 'wcp-openweather' ) . ':'; ?></label> 
        
        <select id="<?php echo esc_attr( $this->get_field_id( 'pressureUnit' ) ); ?>" class="pressure-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'pressureUnit' ) ); ?>">
        <?php 
            foreach ( $pressureUnitList as $key => $item ) : 
            $item = __( $item, 'wcp-openweather' );    
        ?>
            <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $pressureUnit, $key ); ?>><?php echo $item; ?></option>
        <?php endforeach; ?>
        </select>        
    <?php    
    }                    
    
    public function renderEnableUserSettingsField ($enableUserSettings) {
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'enableUserSettings' ); ?>" name="<?php echo $this->get_field_name( 'enableUserSettings' ); ?>" <?php checked( $enableUserSettings ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'enableUserSettings' ) ); ?>"><?php _e( 'Enable user options', 'wcp-openweather' ); ?></label>         
    <?php    
    }     

    public function renderHideWeatherConditionsField ($hideWeatherConditions) {
    ?>
        <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'hideWeatherConditions' ); ?>" name="<?php echo $this->get_field_name( 'hideWeatherConditions' ); ?>" <?php checked( $hideWeatherConditions ); ?>>                
        <label for="<?php echo esc_attr( $this->get_field_id( 'hideWeatherConditions' ) ); ?>"><?php _e( 'Hide description of the weather conditions', 'wcp-openweather' ); ?></label>         
    <?php    
    }         
    
    public function renderUniqueIdField ($uniqueId) {
    ?>
		<input class="widefat" id="<?php echo $this->get_field_id( 'uniqueId' ); ?>" name="<?php echo $this->get_field_name( 'uniqueId' ); ?>" type="hidden" value="<?php echo esc_attr( $uniqueId ); ?>">    
    <?php    
    }    

    public function getWidgetTemplates() {
        return $this->widgetTemplates;
    }

    public function setWidgetTemplates($widgetTemplates) {
        $this->widgetTemplates = $widgetTemplates;
        return $this;
    }
    
    public function getWidgetTag() {
        return $this->widgetTag;
    }

    public function setWidgetTag($widgetTag) {
        $this->widgetTag = $widgetTag;
        return $this;
    }
        
    public function initAutocomplete() {
    ?>
        <script type="text/javascript">
            initAutocomplete();
        </script>
    <?php        
    }    
}

