<?php
/**
 * Plugin Name: WCP OpenWeather
 * Plugin URI: https://wordpress.org/plugins/wcp-openweather/
 * Description: The weather forecast plugin based on OpenWeatherMap API that includes various sidebar widgets and shortcodes
 * Version: 2.5.0
 * Author: Webcodin
 * Author URI: https://profiles.wordpress.org/webcodin/
 * License: GPL2
 * Text Domain: wcp-openweather
 * 
 * @package RPw
 * @category Core
 * @author webcodin
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

if ( !defined( 'RPW_MIN_PHP_VERSION' ) ) {
    define( 'RPW_MIN_PHP_VERSION', '5.3.0');    
}

if ( !defined( 'RPW_CUR_PHP_VERSION' ) ) {
    if ( function_exists( 'phpversion' ) ) {
        define( 'RPW_CUR_PHP_VERSION', phpversion() );        
    } else {
        define( 'RPW_CUR_PHP_VERSION', RPW_MIN_PHP_VERSION );        
    }
}

/**
 * Check for minimum required PHP version
 */
if ( function_exists( 'version_compare' ) && version_compare( RPW_CUR_PHP_VERSION , RPW_MIN_PHP_VERSION) == -1 ) {
    add_action( 'admin_notices', 'RPw_PHPVersion_AdminNotice' , 0 );
/**
 * Check for existing cURL library 
 */    
} elseif ( function_exists ( 'extension_loaded' ) && !( extension_loaded('curl') && function_exists('curl_version') ) ) {
    add_action( 'admin_notices', 'RPw_Curl_AdminNotice' , 0 );
/**
 * Initialize
 */    
} else {
    include_once (dirname(__FILE__) . '/wcp-openweather-init.php' );        
}

/**
 * Incorrect PHP version admin notice
 */
function RPw_PHPVersion_AdminNotice() {
    $name = get_file_data( __FILE__, array ( 'Plugin Name' ), 'plugin' );

    printf(
        '<div class="error">
            <p><strong>%s</strong> plugin can\'t work properly. Your current PHP version is <strong>%s</strong>. Minimum required PHP version is <strong>%s</strong>.</p>
        </div>',
        $name[0],
        RPW_CUR_PHP_VERSION,
        RPW_MIN_PHP_VERSION
    );
}

/**
 * Absent cURL library admin notice
 */
function RPw_Curl_AdminNotice() {
    $name = get_file_data( __FILE__, array ( 'Plugin Name' ), 'plugin' );
    printf(
        '<div class="error">
            <p><strong>%s</strong> plugin can\'t work properly. For properly work <a href="http://php.net/manual/en/book.curl.php" title="cURL">cURL</a> library must be installed on your server.</p>
        </div>',
        $name[0]
   );
 }

