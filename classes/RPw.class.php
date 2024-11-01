<?php
namespace Webcodin\WCPOpenWeather\Plugin;

use Webcodin\WCPOpenWeather\Core\Agp_Module;
use Webcodin\WCPOpenWeather\Core\Agp_Autoloader;

class RPw extends Agp_Module {
    
    /**
     * Current plugin version
     * 
     * @var type 
     */
    private $version = '2.5.0';
    
    /**
     * Api Object
     * 
     * @var OpenWeather
     */
    private $api;

    /**
     * Ajax Object
     * 
     * @var Ajax
     */
    private $ajax;    
    
    /**
     * Settings
     * 
     * @var Settings
     */
    private $settings;
    
    
    /**
     * Themes collection
     * 
     * @var ThemeRepository
     */
    private $themeRepository;
        
    
    /**
     * Current theme entity
     * 
     * @var ThemeEntity
     */
    private $currentTheme;
    
    /**
     * Default Theme Name
     * 
     * @var string
     */
    private $defaultThemeName = 'default';
    
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
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
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
    
    public function __construct() {
        parent::__construct(dirname(dirname(__FILE__)));

        include_once ( $this->getBaseDir() . '/vendor/autoload.php' );     

        $this->settings = Settings::instance( $this );
        $this->_updatePlugin();        
        $this->ajax = Ajax::instance();   
        $this->api = new OpenWeather();
        $this->themeRepository = ThemeRepository::instance();

        add_action( 'init', array($this, 'init' ), 999 );        
        add_action( 'wp_enqueue_scripts', array($this, 'enqueueScripts' ) );    
        add_action( 'admin_enqueue_scripts', array($this, 'enqueueAdminScripts' ));                    
        add_action( 'init', array($this, 'loadTranslation' ));
        add_filter( 'plugin_locale', array($this, 'pluginLocale' ), 10, 2 );
        add_action( 'admin_init', array($this, 'tinyMCEButtons' ) );   

        add_action( 'admin_footer', array( $this, 'createConstructorForm' ) );            
        
        $this->registerThemes();
    }
    
    private function _updatePlugin () {
        
//        delete_option( 'wcp-openweather-version' );        
//        $pluginOption = get_option('plugin-settings');
//        unset($pluginOption['enableGoogleMapsApi']);
//        update_option('plugin-settings', $pluginOption);
        
        $currentVersion = $this->getVersion();
        $version = get_option( 'wcp-openweather-version' );
        if (empty($version)) {
            $version = '1.0.0';
        }
        
        if ( function_exists( 'version_compare' ) && version_compare( $version , $currentVersion) == -1 ) {
            
            if ( version_compare( $version , '2.1.3', '<' ) ) {
                $pluginOption = get_option('plugin-settings');
                
                if ( !empty($pluginOption) && is_array($pluginOption) && !isset($pluginOption['enableGoogleMapsApi'])) {
                    $config = $this->settings->objectToArray( $this->settings->getConfig() );
                    if (isset($config['admin']['options']['fields']['plugin-settings']['fields'])) {
                        $fields = $config['admin']['options']['fields']['plugin-settings']['fields'];
                        if (isset( $fields['enableGoogleMapsApi']['default'] )) {
                            $pluginOption['enableGoogleMapsApi'] = $fields['enableGoogleMapsApi']['default'];
                        }                        
                    }
                }
                
                update_option('plugin-settings', $pluginOption);
            }
            
            
            update_option( 'wcp-openweather-version', $currentVersion );   
            $this->settings->refreshConfig();
        }
    }
    
    public function pluginLocale ($locale, $domain) {
        if ( in_array($domain, array('wcp-openweather', 'wcp-openweather-theme')) ) {
            return $this->getPluginLocale();
        }
        return $locale;
    }    
    
    public function loadTranslation() {
        load_plugin_textdomain('wcp-openweather', FALSE, basename($this->getBaseDir()) .'/languages');
    }
    
    public function enqueueScripts () {
        wp_enqueue_style( 'wp-color-picker' );        
        wp_enqueue_script( 'wp-color-picker' );            
        wp_enqueue_script('colorbox-js', $this->getAssetUrl() . '/libs/colorbox/jquery.colorbox-min.js',array('jquery'));
        wp_enqueue_style('colorbox-css', $this->getAssetUrl() . '/libs/colorbox/colorbox.css');        
        
        wp_enqueue_script( 'iris', $this->getAssetUrl('libs/iris/iris.min.js'), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );

        $pluginSettings = $this->settings->getPluginSettings();        
        wp_enqueue_script( 'rpw-gm-lib', $this->getAssetUrl('js/googlemap.js'), array('jquery') );  
        wp_localize_script( 'rpw-gm-lib', 'rpw_gapi', array( 
            'enabledGoogleMapsApi' => !empty($pluginSettings['enableGoogleMapsApi']),
            'existsGoogleApiKey' => (boolean) $this->getGoogleApiKey(),
            'emptyGoogleApiKeyMessage' => $this->getEmptyGoogleApiKeyMessage(),
        ));  

        if ( !empty($pluginSettings['enableGoogleMapsApi']) && $this->getGoogleApiKey() ) {
            wp_enqueue_script( 'rpw-gm', 'https://maps.googleapis.com/maps/api/js?libraries=places&v=3&language=' . $this->getPluginLang() . '&callback=initMap&key='.$this->getGoogleApiKey(), array('rpw-gm-lib'));            
            wp_enqueue_script( 'rpw', $this->getAssetUrl('js/main.js'), array('jquery', 'rpw-gm', 'rpw-gm-lib', 'iris') );  
        } else {
            wp_enqueue_script( 'rpw', $this->getAssetUrl('js/main.js'), array('jquery', 'iris') );  
        }
        
        wp_localize_script( 'rpw', 'ajax_rpw', array( 
            'base_url' => site_url(),         
            'ajax_url' => admin_url( 'admin-ajax.php' ), 
            'ajax_nonce' => wp_create_nonce('ajax_atf_nonce'),      
        ));  
        
        wp_enqueue_style( 'rpw-css', $this->getAssetUrl('css/style.css') ); 

        wp_enqueue_script('rpw-gm-customize', $this->getAssetUrl('js/customize.js'), array( 'jquery','rpw' ), '', true);
    }        
    
    public function enqueueAdminScripts () {
        wp_enqueue_style( 'wp-color-picker' );        
        wp_enqueue_script( 'wp-color-picker' );          
        wp_enqueue_script('colorbox-js', $this->getAssetUrl() . '/libs/colorbox/jquery.colorbox-min.js',array('jquery'));
        wp_enqueue_style('colorbox-css', $this->getAssetUrl() . '/libs/colorbox/colorbox.css');        

        $pluginSettings = $this->settings->getPluginSettings();        
        wp_enqueue_script( 'rpw-gm-lib', $this->getAssetUrl('js/googlemap.js'), array('jquery') );                                                                 
        wp_localize_script( 'rpw-gm-lib', 'rpw_gapi', array( 
            'enabledGoogleMapsApi' => !empty($pluginSettings['enableGoogleMapsApi']),
            'existsGoogleApiKey' => (boolean) $this->getGoogleApiKey(),
            'emptyGoogleApiKeyMessage' => $this->getEmptyGoogleApiKeyMessage(),
        ));  
        
        if ( !empty($pluginSettings['enableGoogleMapsApi']) && $this->getGoogleApiKey() ) {
            wp_enqueue_script( 'rpw-gm', 'https://maps.googleapis.com/maps/api/js?libraries=places&v=3&language=' . $this->getPluginLang() . '&callback=initMap&key='.$this->getGoogleApiKey(), array('rpw-gm-lib') );            
            wp_enqueue_script( 'rpw', $this->getAssetUrl('js/admin.js'), array('jquery', 'rpw-gm', 'rpw-gm-lib', 'wp-color-picker', 'colorbox-js') );
        } else {
            wp_enqueue_script( 'rpw', $this->getAssetUrl('js/admin.js'), array('jquery', 'wp-color-picker', 'colorbox-js') );                                                             
        }       
        
        wp_enqueue_style( 'rpw-css', $this->getAssetUrl('css/admin.css'));  
        
        wp_localize_script( 'rpw', 'ajax_rpw', array( 
            'base_url' => site_url(),         
            'ajax_url' => admin_url( 'admin-ajax.php' ), 
            'ajax_nonce' => wp_create_nonce('ajax_atf_nonce'),  
            'tinyMCEButtonTitle' => __('Add new WCP OpenWeather shortcode', 'wcp-openweather'),
        ));  
        
        wp_enqueue_script('rpw-gm-customize', $this->getAssetUrl('js/customize.js'), array( 'jquery','rpw' ), '', true);
    }    
    
    public function init () {
        rpw_install_plugin ();
        $pluginSettings = RPw()->getSettings()->getPluginSettings();
        if (isset($pluginSettings['expireUserSettings'])) {
            $this->settings->getUserOptions()->setExpire($pluginSettings['expireUserSettings'] * 86400);
            $this->settings->getUserOptions()->init();
        }
        $this->processRequest();
    }
    
    public function registerThemes () {
        //include inline themes
        $inline_theme = $this->settings->getConfig()->inline_theme;
        foreach ($inline_theme as $namespace => $file) {
            if (file_exists($this->getBaseDir() . $file) && is_file($this->getBaseDir() . $file)) {
                require_once ($this->getBaseDir() . $file);                    
            }
        }


        $pluginSettings = $this->getSettings()->getPluginSettings();        
        $currentThemeId = (!empty($pluginSettings['theme'])) ? $pluginSettings['theme'] : $this->defaultThemeName;                
        
        //register all themes
        $classMap = Agp_Autoloader::instance()->getClassMap();
        if (!empty($classMap['namespaces']) && is_array($classMap['namespaces'])) {
            foreach ($classMap['namespaces'] as $key => $value) {
                $themeClass = $key . '\Theme';
                if (class_exists($themeClass)) {
                    $obj = $themeClass::instance();
                    if ($obj->getId() == $currentThemeId) {
                        $obj->setActive(TRUE);    
                        $this->currentTheme = $obj;
                    }
                    $obj->init();
                    $this->themeRepository->add($obj);
                }
            }
            $this->themeRepository->moveDefaultToFirst();
        }

        if (empty($this->currentTheme)) {
            $this->currentTheme = $this->themeRepository->findById( $this->defaultThemeName );    
            $this->currentTheme->setActive(TRUE);
            $this->currentTheme->init();
        }
        
        if (!empty($pluginSettings['theme'])) {
            if ($pluginSettings['theme'] != $currentThemeId) {
                $options = get_option( 'plugin-settings' );                
                $options['theme'] = $currentThemeId;
                update_option('plugin-settings', $options);
                $this->settings->refreshConfig();
            }
        }
    }
    
    public function processRequest() {
        if (!is_admin()) {
            
            if ( !empty($_REQUEST['reset-settings'])) {
                $id = trim($_REQUEST['reset-settings']);
                $this->settings->getUserOptions()->reset($id);    
                $this->api->getSession()->reset($id);
                wp_redirect(remove_query_arg('reset-settings'));
                exit();
            }
        }
    }
    
    public function createConstructorForm() {
        echo RPw()->getTemplate('admin/constructor/constructor', array());
    }    
    
    public function tinyMCEButtons () {
        if ( current_user_can('edit_posts') && current_user_can('edit_pages')) {
            if ( get_user_option('rich_editing') == 'true' ) {
               add_filter( 'mce_buttons', array($this, 'tinyMCERegisterButtons'));                
               add_filter( 'mce_external_plugins', array($this, 'tinyMCEAddPlugin') );
            }        
        }        
    }
    
    public function tinyMCERegisterButtons( $buttons ) {
       array_push( $buttons, "|", "wcp_openweather" );
       return $buttons;
    }    
    
    public function tinyMCEAddPlugin( $plugin_array ) {
        $plugin_array['wcp_openweather'] = $this->getAssetUrl() . '/js/wcp-openweather.js';
        return $plugin_array;        
    }            
    
    public function getSettingsById ($id = 'default-weather-id', $atts = NULL ) {
        $userOptions = $this->settings->getUserOptions()->get($id);        
        $pluginSettings = $this->settings->getPluginSettings();
        
        if (!isset($atts) && !empty($userOptions)) {
            return $userOptions;
        }
        
        $atts = $this->settings->upperSettings($atts);
        $plugin = $this->settings->getPluginSettings();
        
        $defaults = $this->settings->getWeatherSettings() ;
        $defaults = $this->settings->upperSettings($defaults);
        $defaults['id'] = $id;
        
        if (isset($atts) && is_array($atts)) {
            if (!empty($atts['uniqueId'])) {
                $defaults['uniqueId'] = $atts['uniqueId'];        
            }
            
            if (!isset($atts['city_data']) && !empty($atts['city'])) {
                $atts['city_data'] = '';
            }
        }
        
        $enableUserSettings = 0;
        if (isset($atts['enableUserSettings'])) {
            $enableUserSettings = $atts['enableUserSettings'];
        } else {
            if (!empty($plugin['enableUserSettings'])) : 
                $enableUserSettings = 1;
            endif;                            
        }
        
        $hideWeatherConditions = 0;
        if (isset($atts['hideWeatherConditions'])) {
            $hideWeatherConditions = $atts['hideWeatherConditions'];
        } else {
            if (!empty($plugin['hideWeatherConditions'])) : 
                $hideWeatherConditions = 1;
            endif;                            
        }        
        
        if (empty($userOptions['uniqueId']) 
            || $userOptions['uniqueId'] != $defaults['uniqueId']
            || empty($enableUserSettings) && isset($atts)
        ) {
            $this->settings->getUserOptions()->reset($id);
            $this->api->getSession()->reset($id);
            $userOptions = NULL;
        }
        
        if (!empty($userOptions)) {
            $atts = $userOptions;
        } else {
            if (!empty($atts) && is_array($atts)) {
                $atts = array_merge( $defaults, $atts );    
            } else {
                $atts = $defaults;
            }            
        }     
        
        $atts['enableUserSettings'] = $enableUserSettings;        
        $atts['hideWeatherConditions'] = $hideWeatherConditions;        
        
        if (empty($atts['template'])) {
            $atts['template'] = 'default';
        }
        
        if (empty($pluginSettings['enableGoogleMapsApi']) ) {
            $atts['city_data'] = '';    
        }
        
        $atts = apply_filters( 'wcp_get_settings', $atts, $id );
        
        $this->settings->getUserOptions()->set($id, $atts);                        
            
        return $atts;
    }
    
    public function getWeatherById($id) {
        $result = array();
        $api = $this->settings->getAPISettings();
        $settings = $this->getSettingsById($id);
        $lang = $this->getPluginLang();

        if (!empty($settings['city']) && !empty($settings['city_data'])) {

            parse_str(html_entity_decode(esc_attr($settings['city_data']), ENT_QUOTES), $city_data);

            if (!empty($city_data['lat']) && !empty($city_data['lng'])) {
                $this->api->addRequestParam('lat', $city_data['lat']);
                $this->api->addRequestParam('lon', $city_data['lng']);
            } else {
                $city = stripslashes(str_replace('  ',' ', str_replace(', ', ',', $city_data['full_name'])));
                $city = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($city));                    
                $this->api->addRequestParam('id', $city);
            }
        } elseif (!empty($settings['city']) && empty($settings['city_data'])) {
            $city = stripslashes(str_replace('  ',' ', str_replace(', ', ',', $settings['city'])));
            $city = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($city));

            if (is_numeric($city)) {
                $this->api->addRequestParam('id', $city);                        
            } else {
                $this->api->addRequestParam('q', $city);                            
            }
        } else {
            $gi_lat = GeoIp::instance()->getLat();
            $gi_lon = GeoIp::instance()->getLon();

            if (!empty($gi_lat) && !empty($gi_lon)) {
                $this->api->addRequestParam('lat', $gi_lat);
                $this->api->addRequestParam('lon', $gi_lon);                    
            } else {
                return;
            }
        } 

        if (!empty($api['appid'])) {
            $this->api->addRequestParam('APPID', $api['appid']);
        }
        if (!empty($lang)) {
            $this->api->addRequestParam('lang', $lang);
        }    

        $this->api->setCurrentSessionId($id);

        if (!empty($settings['showCurrentWeather'])) {
            $weather = $this->api->getWeather();
            if (!empty($weather) && $weather->getCount() > 0) {
                $weather->applySettings($settings);
                $weather->applyThemeUrl($this->getCurrentTheme()->getAssetUrl());
                if (!empty($city_data)) {
                    $weather->getCity()->setExtendedInfo($city_data);    
                }
                $result['weather'] = $weather;
            }          
        }        

        if (!empty($settings['showForecastWeather'])) {
            $forecast = $this->api->getDailyForecast(5);
            if (!empty($forecast) && $forecast->getCount() > 0) {
                $forecast->applySettings($settings);
                $forecast->applyThemeUrl($this->getCurrentTheme()->getAssetUrl());
                if (!empty($city_data)) {
                    $forecast->getCity()->setExtendedInfo($city_data);    
                }                    
                $result['forecast'] = $forecast;
            }          
        } 
        
        return $result;
    }
    
    public function getPluginLocale () {
        $plugin = $this->settings->getPluginSettings();
        $lang = !empty($plugin['lang']) ? $plugin['lang'] : get_locale();
        $languages = $this->settings->getFieldSet('languages');
        
        if (!empty($languages) && !empty($lang)) {
            if (array_key_exists($lang, $languages)) {
                return $lang;    
            } else {
                foreach ($languages as $k => $v ) {
                    $plang = $this->getPluginLang($k);
                    if ($lang == $plang) {
                        return $k;
                    }
                }
            }            
        }
        
        return get_locale();
    }
    
    public function getGoogleApiKey () {
        $settings = $this->settings->getAPISettings();        
        return !empty($settings['googleappid']) ? $settings['googleappid'] : NULL;
    }
    
    public function getPluginLang ($lang = NULL) {
        if (empty($lang)) {
            $lang = $this->getPluginLocale();    
        }
        $lang = explode('_', $lang);
        $lang = $lang[0];
        return $lang;
    }
    
    public function getDate($format = '', $date = NULL) {
        $locale = get_locale();
        if (!isset($date)) {
            $date = time() + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
        }
        
        setlocale(LC_TIME, "{$this->getPluginLocale()}.UTF-8");
        $result = strftime($format, $date);
        setlocale(LC_TIME, $locale);
        
        return $result;
        
    }
    
    public function getLanguages () {
        return $this->settings->getLanguages();
    }
    
    public function getImage($key, $size = '') {
        $result = '';
        if (!empty($key)) {
            if (is_numeric($key)) {
                if (empty($size)) {
                    $size = 'wcp_weather_image_preview';
                }
                $image = wp_get_attachment_image_src($key, $size);
                if (!empty($image[0])) {
                    $result = $image[0];
                }  
            } else {
                if (empty($size)) {
                    $arr = explode('.', $key);
                    if (count($arr) > 1) {
                        $arr[count($arr) - 2] = $arr[count($arr) - 2] . '-preview';
                        $key = implode('.', $arr);
                    } else {
                        $key = $key . '-preview';
                    }
                }
                $result = RPw()->getCurrentTheme()->getAssetUrl( $key );    
            }
        }
        return $result;
    }

    public function getEmptyGoogleApiKeyMessage() {
        return __( 'Google API key is required. Please, enter valid Google API Key in the "API" tab.', 'wcp-openweather');
    }
    
    public function getApi() {
        return $this->api;
    }

    public function getAjax() {
        return $this->ajax;
    }

    public function getSettings() {
        return $this->settings;
    }

    public function getThemeRepository() {
        return $this->themeRepository;
    }

    public function getCurrentTheme() {
        return $this->currentTheme;
    }

    public function getDefaultThemeName() {
        return $this->defaultThemeName;
    }
    
    public function getVersion() {
        return $this->version;
    }
}