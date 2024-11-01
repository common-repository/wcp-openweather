<?php
/**
 * Plugin Name: WCP OpenWeather - Metro Theme
 * Plugin URI: https://wordpress.org/plugins/# 
 * Description: WCP OpenWeather - Metro Theme
 * Version: 1.0.0
 * Author: Webcodin
 * Author URI: https://profiles.wordpress.org/webcodin/
 * License: GPL2
 * Text Domain: wcp-openweather-theme
 *  
 * @author webcodin <info@webcodin.com>
 * @license GPLv2
 * @package RPw
 * @version 1.0.0 
 */

/*  Copyright 2015 Webcodin (email : info@webcodin.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;

use Webcodin\WCPOpenWeather\Core\Agp_Autoloader;
use Webcodin\WCPOpenWeather\Plugin\RPw;

if (!defined('ABSPATH')) {
    exit;
}

function rpw_theme_activate() {
    if (class_exists('Webcodin\WCPOpenWeather\Core\Agp_Autoloader')) {
        $autoloader = Agp_Autoloader::instance();
        $autoloader->setClassMap(array(
            'namespaces' => array(
                __NAMESPACE__ => array(
                    __DIR__ => array('classes'),
                ),
            ),
            'classmaps' => array (
                __DIR__ => 'classmap.json'
            ),            
        ));
        //$autoloader->generateClassMap(__DIR__);
    }
}


add_action( 'plugins_loaded', function () {
    if (!class_exists('Webcodin\WCPOpenWeather\Core\Agp_Autoloader')) {
        global $pagenow;

        if ( !empty($pagenow) && 'plugins.php' === $pagenow ) {
            add_action( 'admin_notices', function() {
                unset( $_GET['activate'] );
                $name = get_file_data( __FILE__, array ( 'Plugin Name' ), 'plugin' );
                printf(
                    '<div class="error">
                        <p><i><a target="_blank" href="#" title="WCP OpenWeather">WCP OpenWeather</a></i> plugin not installed.</p>
                        <p><i>%1$s</i> has been deactivated.</p>
                    </div>',
                    $name[0]
                );
                deactivate_plugins( plugin_basename( __FILE__ ) );            
            }, 0 );
        }    
    } else {
        rpw_theme_activate();
    }    
});

rpw_theme_activate();

function RPw() {
    return RPw::instance();
}    