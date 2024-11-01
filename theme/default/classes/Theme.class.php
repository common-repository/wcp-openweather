<?php
namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;

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
        $this->setId('default');
        $this->setName(__('Default Theme', 'wcp-openweather-theme-' . $this->getUniqueId()));
        $this->setIsDefaultTheme(TRUE);
        $this->setSettingsKey('rpw-theme-default-settings');
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

    public function getLessVariables($atts, $src = NULL) {
        $background = isset($atts['themeOptions']['background_color']) ? $atts['themeOptions']['background_color'] : NULL;
        $color = isset($atts['themeOptions']['text_color']) ? $atts['themeOptions']['text_color'] : NULL;        
        
        $result = array(
            'background' => $background,
            'color' => $color,
        );
        return $result;
    }    
}