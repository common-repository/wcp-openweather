<?php
namespace Webcodin\WCPOpenWeather\Plugin;

use Webcodin\WCPOpenWeather\Core\Agp_Module;

abstract class ThemeEntity extends Agp_Module {
    
    /**
     * LESS Parser
     * 
     * @var Less_Parser
     */
    private $lessParser;

    /**
     * System Unique ID
     * 
     * @var string
     */
    private $uniqueId;
    
    /**
     * Widget or Shortcode ID
     * 
     * @var string
     */
    private $id;
    
    private $name;
    
    private $isDefaultTheme = FALSE;
    
    private $active = FALSE;
    
    private $settingsKey = '';
    
    /**
     * Settings
     * 
     * @var ThemeSettings
     */
    private $settings;    
    
    public function __construct($active = FALSE, $baseDir = NULL) {
        parent::__construct($baseDir);
        
        $this->lessParser = new \Less_Parser();
        $this->active = $active;
        $this->uniqueId = 'rpw-theme-' . uniqid();
        $this->settings = new ThemeSettings( $this );
    }
    
    public function init () {
        if ($this->active) {
            add_action( 'wp_enqueue_scripts', array($this, 'enqueueScripts' ) );        
            add_action( 'admin_enqueue_scripts', array($this, 'enqueueAdminScripts' ));                    
            add_action( 'after_setup_theme', array($this, 'setupTheme' ) );
            add_filter( 'image_size_names_choose', array($this, 'sizeNamesChoose' ) );
        }        
    }
    
    public function getLessStyle ($atts, $src = NULL) {
        $defaults = array (
            'id' => $atts['id'],
        );
        
        $variables = $this->getLessVariables($atts, $src);
        if ( !empty($variables) && is_array($variables) ) {
            $this->lessParser->Reset();
            $this->lessParser->parseFile($this->getBaseDir() . '/assets/less/style.less');
            $this->lessParser->ModifyVars( 
                array_merge( 
                    $defaults,
                    $variables
                )
            );
            return '<style type="text/css" >' . $this->lessParser->getCss() . '</style>';        
        }
    }        

    public function getLessVariables($id, $src = NULL) {
    }
    
    public function setupTheme() {
        add_theme_support( 'post-thumbnails' );
        
        $sizes = array();
        if (!empty(RPw()->getSettings()->getConfig()->image->sizes)) {
            $s = RPw()->getSettings()->objectToArray( RPw()->getSettings()->getConfig()->image->sizes );
            if (!empty($s) && is_array($s)) {
                $sizes = array_merge($sizes, $s);
            }
        }

        $s = $this->getThemeImageSizes();
        if (!empty($s) && is_array($s)) {
            $sizes = array_merge($sizes, $s);
        }
        
        if (!empty($sizes) && is_array($sizes)) {
            foreach ($sizes as $size => $params) {
                add_image_size( $size, $params['width'], $params['height'], !empty($params['crop']) ); 
            }
        }
    }        
    
    
    function sizeNamesChoose( $sizes ) {

        $a = array();
        if (!empty(RPw()->getSettings()->getConfig()->image->sizes)) {
            $s = RPw()->getSettings()->objectToArray( RPw()->getSettings()->getConfig()->image->sizes );
            if (!empty($s) && is_array($s)) {
                $a = array_merge($a, $s);
            }
        }

        $s = $this->getThemeImageSizes();
        if (!empty($s) && is_array($s)) {
            $a = array_merge($a, $s);
        }        
        
        if (!empty($a) && is_array($a)) {
            $arr = array();
            foreach ($a as $size => $params) {
                if (!empty($params['name'])) {
                    $arr[$size] = $params['name'];    
                }
            }
            $sizes = array_merge( $sizes, $arr );
        }        
        
        return $sizes;
    }
    
    
    public function getThemeImageSizes () {
    }
   
    public function getThemeConstructorBeforeRender ( $args = NULL ) {
    }    
    
    public function getThemeConstructorAddon ( $args = NULL ) {
    }
    
    public function adminMenu() {
        if ($this->active) {
            add_submenu_page('wcp-weather-main', __('Theme Settings', 'wcp-openweather'), __('Theme Settings', 'wcp-openweather'), 'manage_options', 'wcp-theme' , array('Webcodin\WCPOpenWeather\Plugin\Settings', 'renderThemeSettingsPage') );                    
        }
    }    
    
    public function enqueueScripts () {
        wp_enqueue_script( $this->uniqueId , $this->getAssetUrl('js/main.js'), array('rpw','iris') );  
        wp_enqueue_style( $this->uniqueId . '-css', $this->getAssetUrl('css/style.css') );    
    }            
    
    public function enqueueAdminScripts () {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('agp_upload_media', RPw()->getAssetUrl('js/upload-media.js'), array('jquery'));
        wp_localize_script( 'agp_upload_media', 'agp_upload_media', array( 
            'button' => __('Select', 'wcp-openweather'),         
            'title' => __('Upload Image', 'wcp-openweather'),
            'noimage_url' => RPw()->getAssetUrl( 'images/noimage.png' ) ,
        ));
        wp_enqueue_style('thickbox');
        wp_enqueue_media();
    }                
    
    public function renderIcon ($item, $hideWeatherConditions = FALSE) {
        if ($hideWeatherConditions) {
            return '<img src="' . $item->getWeatherIconUrl() .'" alt=""  title=""/>';
        } else {
            return '<img src="' . $item->getWeatherIconUrl() .'" alt="' . $item->getWeatherDescription() . '"  title="' . $item->getWeatherDescription() . '"/>';    
        }
    }        
    
    private function _prepareAtts ($atts, $tag, $template) {
        $plugin = RPw()->getSettings()->getPluginSettings();

        $timeDiff = !empty($plugin['refreshPeriod']) ? 1 * $plugin['refreshPeriod'] : 0 ;
        RPw()->getApi()->setTimeDiff($timeDiff);
        
        $id = !empty($atts['id']) ? $atts['id'] : 'default-weather-id';
        $id = stripslashes(str_replace(' ','_', str_replace(', ', '_', $id)));
        $id = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($id));
        if (isset($atts['id'])) {
            unset($atts['id']);
        }

        $tag = !empty($atts['tag']) ? $atts['tag'] : $tag;    
        $atts['tag'] = $tag;
        
        $template = !empty($atts['template']) ? $atts['template'] : $template;    
        $templateList = RPw()->getCurrentTheme()->getSettings()->getFieldSet("{$tag}_templates");
        $isSingleTemplate = !empty($templateList) && is_array($templateList) && count($templateList) == 1 || empty($template);
        if ($isSingleTemplate) {
            $template = 'default';
        }
        $atts['template'] = $template;
        $atts['themeOptions'] = $this->getSettings()->getSettings($this->settingsKey);
        
        RPw()->getSettings()->setCurrentId($id);        
        RPw()->getSettings()->setCurrentTag($tag);     
        RPw()->getSettings()->setCurrentTemplate($template);        
        
        $atts = RPw()->getSettingsById($id, $atts);    
        
        $atts['tag'] = $tag;
        $atts['template'] = $template;
        $atts['themeOptions'] = $this->getSettings()->getSettings($this->settingsKey);        
        
        return $atts;
    }
    
    public function doShortcode ($atts, $content, $tag = 'wcp_weather', $template = NULL) {
        $atts = $this->_prepareAtts($atts, $tag, $template);
        echo RPw()->getCurrentTheme()->getLessStyle($atts, 'shortcode');
        return $this->getTemplate("shortcode/{$atts['tag']}/{$atts['template']}/layout", $atts);        
    }
    
    public function doWidget ($atts, $tag, $template = NULL) {
        $atts = $this->_prepareAtts($atts, $tag, $template);        
        echo RPw()->getCurrentTheme()->getLessStyle($atts, 'widget');
        return $this->getTemplate("widget/{$atts['tag']}/{$atts['template']}/layout", $atts);
    }       
    
    public function getExcludeUserOptions ($tag) {
        $exlude = $this->getSettings()->getAllExcludeUserOptions();
        if (!empty($exlude[$tag])) {
            return $exlude[$tag];
        }
        return array();
    }
    
    public function isLangExists( $lang ) {
        $languages = $this->settings->getFieldSet('languages');
        if (!empty($languages)) {
            return array_key_exists($lang, $languages);    
        }
    }
    
    public function isPartialLang( $lang ) {
        $languages = RPw()->getSettings()->getFieldSet('partial_languages');
        if (!empty($languages) && array_key_exists($lang, $languages)) {
            return $languages[$lang];    
        }
    }    
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
 
    public function getIsDefaultTheme() {
        return $this->isDefaultTheme;
    }

    public function setIsDefaultTheme($isDefaultTheme) {
        $this->isDefaultTheme = $isDefaultTheme;
        return $this;
    }
    
    public function getUniqueId() {
        return $this->uniqueId;
    }
    
    public function getSettings() {
        return $this->settings;
    }
    
    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }
    
    public function getSettingsKey() {
        return $this->settingsKey;
    }

    public function setSettingsKey($settingsKey) {
        $this->settingsKey = $settingsKey;
        $this->settings->setSettingsKey($settingsKey);
        return $this;
    }

    public function getLessParser() {
        return $this->lessParser;
    }

}
