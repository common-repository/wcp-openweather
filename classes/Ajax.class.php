<?php
namespace Webcodin\WCPOpenWeather\Plugin;

use Webcodin\WCPOpenWeather\Core\Agp_AjaxAbstract;

class Ajax extends Agp_AjaxAbstract {
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
    
    /**
     * Refresh Weather Action
     */
    public function weatherRefresh($data) {
        $userOptions = RPw()->getSettings()->getUserOptions()->get($data['id']);        
        RPw()->getSettings()->setCurrentTag(!empty($data['tag']) ? $data['tag'] : '');
        RPw()->getSettings()->setCurrentTemplate(!empty($data['template']) ? $data['template'] : '');
        
        if (!empty($userOptions)) {
            echo RPw()->getCurrentTheme()->doShortcode($userOptions, '', RPw()->getSettings()->getCurrentTag(), RPw()->getSettings()->getCurrentTemplate());    
        } else {
            echo RPw()->getCurrentTheme()->doShortcode(array('id' => $data['id']), '', RPw()->getSettings()->getCurrentTag(), RPw()->getSettings()->getCurrentTemplate());    
        }
    }
    
    /**
     * Refresh Weather Widget Action
     */
    public function weatherWidgetRefresh($data) {
        $userOptions = RPw()->getSettings()->getUserOptions()->get($data['id']);        
        RPw()->getSettings()->setCurrentTag(!empty($data['tag']) ? $data['tag'] : '');
        RPw()->getSettings()->setCurrentTemplate(!empty($data['template']) ? $data['template'] : '');        
        
        if (!empty($userOptions)) {
            echo RPw()->getCurrentTheme()->doWidget($userOptions, RPw()->getSettings()->getCurrentTag(), RPw()->getSettings()->getCurrentTemplate());    
        } else {
            echo RPw()->getCurrentTheme()->doWidget(array('id' => $data['id']), RPw()->getSettings()->getCurrentTag(), RPw()->getSettings()->getCurrentTemplate());    
        }
    }    
    
    public function getWCPShortcode($data) {
        $result = array();
        $pluginSettings = RPw()->getSettings()->getPluginSettings();
        
        $atts = !empty($data['global-settings']) ? $data['global-settings'] : array();
        
        if (!empty($atts)) {
            $keys = RPw()->getSettings()->getSettingsKeys();
            unset($keys['enableusersettings']);
            unset($keys['hideweatherconditions']);
            $atts['id'] = 'wcp_openweather_' . uniqid();
            
            foreach ($keys as $k) {
                if (!array_key_exists($k, $atts)) {
                    $atts[$k] = '';
                }
            }
            
            unset($atts['uniqueId']);
            
            if (empty($pluginSettings['enableGoogleMapsApi']) && isset($atts['city_data']) ) {
               unset($atts['city_data']);    
            }
            
            if (!empty($atts['geoIp'])) {
                if (isset($atts['city_data'])) {
                    unset($atts['city_data']);         
                }
                if (isset($atts['city'])) {
                    unset($atts['city']);         
                }                
            }            

            $s = '';            
            if (!empty($atts['useDefaultSettings'])) {
                $s .= ' id="' . $atts['id'] . '"';                    
            } else {
                foreach ($atts as $key => $value) {

                    if (in_array(strtolower($key), array('shortcodeimage', 'widgetimage'))) {
                        $key = 'background_image';
                    }

                    if (is_string($value)) {
                        $s .= ' ' . $key . '="' . $value . '"';    
                    } else {
                        $s .= ' ' . $key . '=' . $value;    
                    }
                }                
            }

            $result['shortcode'] = '[wcp_weather ' . $s . ']';               
        }
        
        return $result;                    
    }  
    
    public function setUserOptions ($data) {
        $result = array();
        if (!empty($data['id']) && !empty($data['global-settings'])) {
            $atts = !empty($data['global-settings']) ? $data['global-settings'] : array();            
            if (!empty($atts)) {
                $atts['id'] = $data['id'];
                
                $userOptions = RPw()->getSettings()->getUserOptions()->get($atts['id']);        
                $atts = RPw()->getSettings()->sanitizeSettings($atts, FALSE);
                
                if (!empty($userOptions)) {
                    
                    if (empty($atts['showCurrentWeather']) && !empty($userOptions['showCurrentWeather'])) {
                        unset($userOptions['showCurrentWeather']);
                    }
                    
                    if (empty($atts['showForecastWeather']) && !empty($userOptions['showForecastWeather'])) {
                        unset($userOptions['showForecastWeather']);
                    }
                    
                    $atts = array_merge($userOptions, $atts);
                }
                
                RPw()->getSettings()->getUserOptions()->set($atts['id'], $atts);
                RPw()->getApi()->getSession()->reset($atts['id']);
                $result['status'] = 'ok';
            }            
        }
        
        return $result;
    }
}
