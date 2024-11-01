<?php
namespace Webcodin\WCPOpenWeather\Plugin;

use Webcodin\WCPOpenWeather\Core\Agp_SettingsAbstract;

class Settings extends Agp_SettingsAbstract {
    
    private $currentId;
    
    private $currentTag;
    
    private $currentTemplate;
    
    /**
     * User Options
     * 
     * @var UserOptions
     */
    private $userOptions;
    
    /**
     * The single instance of the class 
     * 
     * @var object 
     */
    protected static $_instance = null;    

    /**
     * Parent Module
     * 
     * @var RPw
     */
    protected static $_parentModule;
    
	/**
	 * Main Instance
	 *
     * @return object
	 */
	public static function instance($parentModule = NULL) {
		if ( is_null( self::$_instance ) ) {
            self::$_parentModule = $parentModule;            
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
     * Constructor 
     * 
     * @param Agp_Module $parentModule
     */
    public function __construct() {
        
        $this->userOptions = UserOptions::instance();
        
        $config = include ($this->getParentModule()->getBaseDir() . '/config/config.php');        

        parent::__construct($config);                

    }
    
    public static function renderSettingsPage() {
        
        echo self::getParentModule()->getTemplate('admin/options/layout', self::instance());
    }
    
    public static function renderThemeSettingsPage() {
        
        if (!isset($_REQUEST['tab'])) {
            $theme = self::getParentModule()->getThemeRepository()->getActive();
            if (!empty($theme)) {
                $key = $theme->getSettingsKey();
                if (empty($key)) {
                    $key = 'rpw-theme-default-settings';
                }
                wp_redirect(add_query_arg(array('tab' => $key)));
            }
        }
        
        echo self::getParentModule()->getCurrentTheme()->getTemplate('admin/options/layout', self::getParentModule()->getCurrentTheme()->getSettings());
    }    
    
    public static function getThemesFieldSet() {
        $data = self::$_parentModule->getThemeRepository()->getAll();
        if (!empty($data) and is_array($data)) {
            foreach ($data as $item) {
                $result[$item->getId()] = $item->getName();
            }
        }
        
        return $result;        
    }        
    
    public static function getLanguages() {
        $languages = self::$_instance->getFieldSet('languages');
        natsort($languages);
        $result = array('' => __('Auto Detect', 'wcp-openweather')) + $languages; 
        return $result;        
    }            

    public static function getShortcodeTemplates($tag = "wcp_weather") {
        $templateList = RPw()->getCurrentTheme()->getSettings()->getFieldSet("{$tag}_templates");
        if (empty($templateList)) {
            $templateList = array(
                'default' => __('Default', 'wcp-openweather'),
            );
        }
        return $templateList;        
    }            
    
    public static function getParentModule() {
       
        return self::$_parentModule;
    }
    
    /**
     * Create menu
     */
    public function adminMenu() {
        if (!empty($this->getConfig()->admin->menu)) {
            foreach ($this->getConfig()->admin->menu as $menu_slug => $page) {

                $page->page_title = __($page->page_title, 'wcp-openweather');
                $page->menu_title = __($page->menu_title, 'wcp-openweather');
                
                add_menu_page( $page->page_title, $page->menu_title, $page->capability, $menu_slug, $page->function, $page->icon_url, $page->position);
                
                if (!empty($page->submenu)) {
                    foreach ($page->submenu as $submenu_slug => $subpage) {                    
                        $subpage->page_title = __($subpage->page_title, 'wcp-openweather');
                        $subpage->menu_title = __($subpage->menu_title, 'wcp-openweather');
                        add_submenu_page( $menu_slug, $subpage->page_title, $subpage->menu_title, $subpage->capability, $submenu_slug, $subpage->function );
                    }
                }

                if (!empty($page->hideInSubMenu)) {
                    remove_submenu_page( $menu_slug, $menu_slug );            
                }                
            }
        }
    }
    
    /**
     * Sanitize settings
     * 
     * @param array $input
     * @return array
     */
    public function sanitizeSettings($input, $refreshUniqueId = TRUE) {
        $input = parent::sanitizeSettings($input);
        if ($refreshUniqueId) {
            $input['uniqueId'] = uniqid();    
        }
        return $input;
    }
    
    public function getSettingsKeys() {
        $result = array();
        $fields = $this->getFields('global-settings');
        
        if (!empty($fields) && is_array($fields)) {
            foreach ($fields['fields'] as $key => $value) {
                $result[trim(strtolower($key))] = $key;
            }            
            
            $result['enableusersettings'] = 'enableUserSettings';
            $result['hideweatherconditions'] = 'hideWeatherConditions';
        }

        return $result;
    }
    
    public function lowerSettings( $data ) {
        $result = array();

        if (isset($data) && is_array($data)) {
            $keys = $this->getSettingsKeys();
            
            foreach ($data as $key => $value) {
                $lowerKey = trim(strtolower($key));
                if (array_key_exists($lowerKey, $keys)) {
                    $result[$lowerKey] = $value;
                } else {
                    $result[$key] = $value;
                }
            }        
        } else {
            $result = $data;
        }
        
        return $result;
    }
    
    public function upperSettings( $data ) {
        $result = array();

        if (isset($data) && is_array($data)) {
            $keys = $this->getSettingsKeys();
            
            foreach ($data as $key => $value) {
                $lowerKey = trim(strtolower($key));
                if (array_key_exists($lowerKey, $keys)) {
                    $result[$keys[$lowerKey]] = $value;
                } else {
                    $result[$key] = $value;
                }
            }        
        } else {
            $result = $data;
        }
        
        return $result;        
    }
    
    
    /**
     * Recursive callable apply 
     * 
     * @param mix $value
     * @return mix
     */
    public function getRecursiveCallable ($value) {
        $result = $value;
        if (is_callable($value) && is_array($value)) {
            $result =  call_user_func($value);
        } elseif (is_array($value)) {
            foreach ($value as $k => $v) {
                $result[$k] = $this->getRecursiveCallable($v);        
            }
        }         
        return $result;
    }      

    /**
     * Page getter
     * 
     * @return string
     */
    public function getPage() {
        return $this->getRecursiveCallable(parent::getPage());
    }
    
    /**
     * Tabs getter
     * 
     * @return array
     */
    public function getTabs() {
        return $this->getRecursiveCallable(parent::getTabs());
    }
    
    public function getUserOptions() {
        return $this->userOptions;
    }
    
    public function getWeatherSettings () {
        return $this->getSettings('global-settings');
    }
    
    public function getPluginSettings () {
        return $this->getSettings('plugin-settings');                
    }

    public function getAPISettings () {
        return $this->getSettings('api-settings');                
    }  
    
    public function getCurrentId() {
        return $this->currentId;
    }

    public function setCurrentId($currentId) {
        $this->currentId = $currentId;
        return $this;
    }
    
    public function getCurrentTag() {
        return $this->currentTag;
    }

    public function setCurrentTag($currentTag) {
        $this->currentTag = $currentTag;
        return $this;
    }

    public function getCurrentTemplate() {
        return $this->currentTemplate;
    }

    public function setCurrentTemplate($currentTemplate) {
        $this->currentTemplate = $currentTemplate;
        return $this;
    }
    
    public function getCurrentTemplatePath() {
        $result = '';
        $ra = array();
            
        if (!empty($this->currentTag)) {
            $ra[] = $this->currentTag;
        }
        
        if (!empty($this->currentTemplate)) {
            $ra[] = $this->currentTemplate;
        }

        if (!empty($ra)) {
            $result = implode('/', $ra);
        }
        
        return $result;
    }
}

