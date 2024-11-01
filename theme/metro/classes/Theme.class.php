<?php
namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;

use Webcodin\WCPOpenWeather\Plugin\ThemeEntity;

class Theme extends ThemeEntity {

    /**
     * The single instance of the class 
     * 
     * @var object 
     */
    protected static $_instance = null;    
    
	/**
	 * Main Instance
	 *
     * @return object
	 */
	public static function instance($active = FALSE) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self($active);
		}
		return self::$_instance;
	}    
    
	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
    }        
    
    public function __construct($active = FALSE) {
        parent::__construct($active, dirname(dirname(__FILE__)));
        $this->setId('metro');
        $this->setName(__('Metro Theme', 'wcp-openweather-theme-' . $this->getUniqueId()));
        $this->setIsDefaultTheme(FALSE);
        $this->setSettingsKey('rpw-theme-metro-settings');
        add_action( 'init', array($this, 'loadTranslation' ));        
    }
    
    public function init() {
        parent::init();
        
        if ($this->getActive()) {
            
            $noerr = load_plugin_textdomain('wcp-openweather-theme', FALSE, basename( $this->getBaseDir()) . '/languages');
            if (!$noerr) {
                load_plugin_textdomain('wcp-openweather-theme', FALSE, basename( dirname(dirname($this->getBaseDir())) ) . '/theme/' . $this->getId() . '/languages');                
            }
            
            add_action( 'admin_menu', array( $this, 'adminMenu' ), 999 );             
            add_shortcode( 'wcp_weather', array($this, 'doShortcode') ); 
            add_action( 'widgets_init', array($this, 'initWidgets' ) ); 
        }   
    }
    
    public function enqueueScripts () {
        parent::enqueueScripts();
        wp_enqueue_style( 'dripicons-css', $this->getAssetUrl('css/dripicons.css') );    
    }                
    
    public function loadTranslation() {
        $domain = 'wcp-openweather-theme-' . $this->getUniqueId();
        $locale = apply_filters( 'plugin_locale', get_locale(), 'wcp-openweather-theme' );        
        $mofile = $this->getBaseDir() . '/languages/wcp-openweather-theme-' . $locale . '.mo';
        load_textdomain( $domain, $mofile );        
    }
    
    public static function getThemeName () {
        return self::$_instance->getName();
    }

    public function getName() {
        return __(parent::getName(), 'wcp-openweather-theme-' . $this->getUniqueId());
    }        
    
    public function initWidgets() {
        register_widget(__NAMESPACE__ . '\Weather');
        register_widget(__NAMESPACE__ . '\WeatherMini');
    }        

    public function renderIcon ($item, $hideWeatherConditions = FALSE) {
        
        $config = $this->getSettings()->getConfig();
        
        if (!empty($config->iconClass)) {
            $icon = $item->getWeatherIcon();
            if (!empty($config->iconClass->$icon)) {
                if ($hideWeatherConditions) {
                    return '<div style="font-size: 20px;" class="icon diw-' . $config->iconClass->$icon . '"></div>';    
                } else {
                    return '<div style="font-size: 20px;" class="icon diw-' . $config->iconClass->$icon . '" title="' . $item->getWeatherDescription() . '"></div>';    
                }
            }
        } 
        
        return parent::renderIcon($item, $hideWeatherConditions);
    }

    public function getThemeImageSizes() {
        $result = array();
        $settings = $this->getSettings()->getSettings('rpw-theme-metro-settings');
        
        if (!empty($settings['wcp_weather_widget_image_size'])) {
            $result['wcp_weather_widget_image_size'] = $settings['wcp_weather_widget_image_size'];
        }
        
        if (!empty($settings['wcp_weather_shortcode_image_size'])) {
            $result['wcp_weather_shortcode_image_size'] = $settings['wcp_weather_shortcode_image_size'];
        }

        return $result;

    }

    public function getThemeConstructorAddon ( $args = NULL ) {
        echo $this->getTemplate('admin/constructor/addon', $args);
    }
    
    public function getThemeConstructorBeforeRender ( $args = NULL ) {
        echo $this->getTemplate('admin/constructor/before-render', $args);
    }    
    
    public function getLessVariables($atts, $src = NULL) {
        $background_image = '';
        if (!empty($src)) {
            $background_image = isset($atts['background_image']) ? $atts['background_image'] : (isset($atts['themeOptions']["{$src}Image"]) ? $atts['themeOptions']["{$src}Image"] : '');    
            $background_image = RPw()->getImage($background_image, "wcp_weather_{$src}_image_size");
        }
        $background_opacity = isset($atts['background_opacity']) ? $atts['background_opacity'] : (isset($atts['themeOptions']['background_opacity']) ? $atts['themeOptions']['background_opacity'] : 0);
        $background_opacity = round($background_opacity / 100, 2);
        $background_color = isset($atts['background_color']) ? $atts['background_color'] : (isset($atts['themeOptions']['background_color']) ? $atts['themeOptions']['background_color'] : '');
        $text_color = isset($atts['text_color']) ? $atts['text_color'] : (isset($atts['themeOptions']['text_color']) ? $atts['themeOptions']['text_color'] : '');
        
        $result = array(
            'background_image' => "url($background_image)",
            'background_opacity' => $background_opacity,
            'background_color' => $background_color,
            'text_color' => $text_color,
        );
        
        return $result;
    }
}