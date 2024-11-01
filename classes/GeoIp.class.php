<?php
namespace Webcodin\WCPOpenWeather\Plugin;

use DavidePastore\Ipinfo\Ipinfo;
use DavidePastore\Ipinfo\Host;

class GeoIp {
    
    /**
     * IP Info
     * 
     * @var Ipinfo 
     */
    private $ipInfo;
    
    /**
     * Client IP
     * 
     * @var string
     */
    private $ip;
    
    /**
     * Host
     * 
     * @var Host
     */
    private $host;
    
    /**
     * The single instance of the class 
     * 
     * @var object 
     */
    protected static $_instance = null;    
    
	/**
	 * Main Instance
	 *
     * @return GeoIp
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
     * Constructor
     */
    public function __construct() {
        $this->ipInfo = new Ipinfo();
        $this->ip = $this->_getClientIp();
        
        if (!empty($this->ip)) {
            $this->host = $this->ipInfo->getFullIpDetails($this->ip);    
        }
    }
    
    private function _getClientIp() {
        $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
        foreach ($ip_keys as $key) {
            if (!empty($_SERVER[$key])) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (! (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false )) {
                        return $ip;
                    }
                }
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
    }    

    /**
     * Gets Lat
     * 
     * @return string
     */
    public function getLat() {
        if (!empty($this->host)) {
            $loc = $this->host->getLoc();
            if (!empty($loc)) {
                $res = explode(',', $loc);
                if (!empty($res[0])) {
                    return trim($res[0]);
                }
            }
        }
    }
    
    /**
     * Gets Lon
     * 
     * @return string
     */    
    public function getLon() {
        if (!empty($this->host)) {
            $loc = $this->host->getLoc();
            if (!empty($loc)) {
                $res = explode(',', $loc);
                if (!empty($res[1])) {
                    return trim($res[1]);
                }
            }
        }        
    }    
    
    /**
     * ipInfo Getter
     * 
     * @return Ipinfo
     */
    public function getIpInfo() {
        return $this->ipInfo;
    }
    
    /**
     * ip Getter
     * 
     * @return string
     */    
    public function getIp() {
        return $this->ip;
    }
    
    /**
     * Host Getter
     * 
     * @return Host
     */    
    public function getHost() {
        return $this->host;
    }

    
}