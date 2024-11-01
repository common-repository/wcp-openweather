<?php
namespace Webcodin\WCPOpenWeather\Plugin;

use Webcodin\WCPOpenWeather\Core\Agp_Autoloader;

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'Webcodin\WCPOpenWeather\Plugin\rpw_output_buffer');
if (!function_exists('Webcodin\WCPOpenWeather\Plugin\rpw_output_buffer')) {
    function rpw_output_buffer() {
        ob_start();
    }    
}

if (file_exists(dirname(__FILE__) . '/agp-core/agp-core.php' )) {
    include_once (dirname(__FILE__) . '/agp-core/agp-core.php' );
} 

add_action( 'plugins_loaded', 'Webcodin\WCPOpenWeather\Plugin\rpw_activate_plugin');
if (!function_exists('Webcodin\WCPOpenWeather\Plugin\rpw_activate_plugin')) {
    function rpw_activate_plugin() {
        if (class_exists('Webcodin\WCPOpenWeather\Core\Agp_Autoloader') && !function_exists('RPw')) {
            $autoloader = Agp_Autoloader::instance();
            $autoloader->setClassMap(array(
                'namespaces' => array(
                    'Webcodin\WCPOpenWeather\Plugin' => array(
                        __DIR__ => array('classes'),
                    ),                    
                    'Webcodin\WCPOpenWeather\Core' => array(
                        __DIR__ => array('agp-core'),
                    ),
                    'Webcodin\WCPOpenWeather\Theme\DefaultTheme' => array(
                        __DIR__ . '/theme/default' => array('classes'),
                    ),                    
                    'Webcodin\WCPOpenWeather\Theme\MetroTheme' => array(
                        __DIR__ . '/theme/metro' => array('classes'),
                    ),                                        
                ),
                'classmaps' => array (
                    __DIR__ => 'classmap.json',
                    __DIR__ . '/theme/default' => 'classmap.json',
                    __DIR__ . '/theme/metro' => 'classmap.json',
                ),
            ));

    //        $autoloader->generateClassMap(__DIR__);
    //        $autoloader->generateClassMap(__DIR__ . '/theme/default');
    //        $autoloader->generateClassMap(__DIR__ . '/theme/metro');

            function RPw() {
                return RPw::instance();
            }    

            RPw();                
        }
    }    
}

register_activation_hook( __FILE__, 'Webcodin\WCPOpenWeather\Plugin\rpw_install_plugin' );
if (!function_exists('Webcodin\WCPOpenWeather\Plugin\rpw_install_plugin')) {
    function rpw_install_plugin () {
        global $wpdb;
        $table_name = $wpdb->prefix . "wcp_useroptions";
        
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE " . $table_name . " (
                    `id` varchar(64) NOT NULL,
                    `key` varchar(255) NOT NULL,
                    `data` text,
                    `access` int(10) unsigned DEFAULT NULL,
                    UNIQUE KEY `id` (`id`, `key`),
                    KEY `access` (`access`),
                    KEY `key` (`key`)
                );";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);            
        }
        
    }
}
