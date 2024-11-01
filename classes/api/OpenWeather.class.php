<?php
namespace Webcodin\WCPOpenWeather\Plugin;

use Webcodin\WCPOpenWeather\Core\Agp_Curl;
use Webcodin\WCPOpenWeather\Core\Agp_Session;

class OpenWeather extends Agp_Curl {
    
    private $sunrise;

    private $sunset;          
    
    private $currentSessionId;        
    
    private $timeDiff;        
    
    /**
     * Session
     * 
     * @var Agp_Session
     */
    private $session;
    
    public function __construct() {
        $this->session = Agp_Session::instance();
        $this->timeDiff = 0;
        
        parent::__construct('http://api.openweathermap.org');
        $this->setBaseRoute('data/2.5');
        $this->addRequestParam('mode', 'json');
    }
        
    public function get($requestParams = array(), $route='') {
        $result = NULL;
        $data = $this->session->get($this->currentSessionId);
        if (!empty($data[$route]['timestamp']) && ((time() - $data[$route]['timestamp']) < $this->timeDiff) ) {
            $result = $data[$route]['data'];
        } else {
            $response = parent::get($requestParams, $route);    
            if ($response) {
                $data[$route]['timestamp'] = time();
                $data[$route]['data'] = json_decode($response);
                
                $this->session->set($this->currentSessionId, $data);
                $result = $data[$route]['data'];
            } elseif(!empty ($data[$route]['data'])) {
                $result = $data[$route]['data'];
            } else {
                $this->session->reset($this->currentSessionId);
            }
        }
        return $result;
    }    
    
    public function getWeather() {
        $response = $this->get(array(), 'weather');
        
        if (isset($response->id) && empty($response->id)) {
            $response->id = uniqid();
        }
        
        if (!empty($response->id)) {
            
            $weather = $response->weather[0];
                        
            $data = array(
                'response' => $response,
                'city' => array(
                    'ID' => $response->id,
                    'name' => $response->name,
                    'coord' => $response->coord,
                    'country' => $response->sys->country,
                ),
                'items' => array(
                    0 => array(
                        'ID' => $response->dt,
                        'temperature' => $response->main->temp,
                        'pressure' => $response->main->pressure,
                        'humidity' => $response->main->humidity,                        
                        'windSpeed' => $response->wind->speed,
                        'windDeg' => !empty($response->wind->deg) ? $response->wind->deg : NULL,    
                        'weatherId' => $weather->id,    
                        'weatherMain' => $weather->main,    
                        'weatherDescription' => $weather->description,    
                        'weatherIcon' => $weather->icon,  
                        'weatherIconUrl' => 'http://openweathermap.org/img/w/'. $weather->icon .'.png',
                        'clouds' => $response->clouds->all,
                        'sunrise' => $response->sys->sunrise,
                        'sunset' => $response->sys->sunset,
                    ),
                ),
            );

            $repository = new WeatherRepository($data);
            return $repository;
        } else {
            $this->session->reset($this->currentSessionId);
        }
    }
    
    public function getForecast() {
        $response = $this->get(array(), 'forecast');
        $weather = $this->get(array(), 'weather');
        $this->sunrise = $weather->sys->sunrise;
        $this->sunset = $weather->sys->sunset;
        
        if (isset($response->city->id) && empty($response->city->id)) {
            $response->city->id = uniqid();
        }
        
        if (!empty($response->city->id)) {        
            $data = array(
                'response' => $response,
                'city' => array(
                    'ID' => $response->city->id,
                    'name' => $response->city->name,
                    'coord' => $response->city->coord,
                    'country' => $response->city->country,
                ),
            );

            $items = array();
            if (!empty($response->list)) {
                $aitems = array();
                foreach ($response->list as $item) {
                    $index = strtotime(date('Y-m-d 00:00:00', $item->dt));
                    $times = $this->getForecastTimesByDt( $item->dt );
                    
                    if (!$aitems[ $index ]['temp'][ $times ]) {
                        $aitems[ $index ]['temp'][ $times ] = array();
                    }
                    array_push($aitems[ $index ]['temp'][ $times ], $item->main->temp);
                    
                    if ( empty($aitems[ $index ]['item']) && $this->getForecastTimesByDt($item->dt) == 'day' ) {                        
                        $aitems[ $index ]['item'] = $item;
                        $aitems[ $index ]['item_date'] = date('c', $item->dt);
                    }
                    
                }
                
                $cnt = 0;
                foreach ($aitems as $index => $value) {
                    $item = $value['item'];
                    $temps = $value['temp'];
                    $temp = new \stdClass();
                    
                    $temp->day = !empty($temps['day']) ? max( $temps['day'] ) : $item->main->temp;
                    $temp->night = !empty($temps['night']) ? min( $temps['night'] ) : $item->main->temp;
                    
                    $weather = $item->weather[0];
                    $items[] = array(
                        'ID' => $index,
                        'temperature' => $temp,   
                        'pressure' => $item->main->pressure,
                        'humidity' => $item->main->humidity,
                        'windSpeed' => $item->wind->speed,
                        'windDeg' => !empty($item->wind->deg) ? $item->wind->deg : NULL,   
                        'weatherId' => $weather->id,    
                        'weatherMain' => $weather->main,    
                        'weatherDescription' => $weather->description,    
                        'weatherIcon' => $weather->icon,
                        'weatherIconUrl' => 'http://openweathermap.org/img/w/'. $weather->icon .'.png',
                        'clouds' => $item->clouds->all,
                        'sunrise' => NULL,
                        'sunset' => NULL,                    
                    );
                    if ( ++$cnt >=5 ) break;
                }
                $data['items'] = $items;
            }
            $repository = new WeatherRepository($data);
            return $repository;
        } else {
            $this->session->reset($this->currentSessionId);
        }
    }
    
    public function getDailyForecast ($dayCount = NULL) {
        
        $params = array();
        if (!empty($dayCount)) {
            $params['cnt'] = $dayCount;
        }
        $response = $this->get($params, 'forecast/daily');
        
        if (isset($response->city->id) && empty($response->city->id)) {
            $response->city->id = uniqid();
        }
        
        if (!empty($response->city->id)) {        
            $data = array(
                'response' => $response,
                'city' => array(
                    'ID' => $response->city->id,
                    'name' => $response->city->name,
                    'coord' => $response->city->coord,
                    'country' => $response->city->country,
                ),
            );

            $items = array();
            foreach ($response->list as $item) {
                $weather = $item->weather[0];
                $items[] = array(
                    'ID' => $item->dt,
                    'temperature' => $item->temp,   
                    'pressure' => $item->pressure,
                    'humidity' => $item->humidity,
                    'windSpeed' => $item->speed,
                    'windDeg' => !empty($item->deg) ? $item->deg : NULL, 
                    'weatherId' => $weather->id,    
                    'weatherMain' => $weather->main,    
                    'weatherDescription' => $weather->description,    
                    'weatherIcon' => $weather->icon,     
                    'weatherIconUrl' => 'http://openweathermap.org/img/w/'. $weather->icon .'.png',
                    'clouds' => $item->clouds,
                    'sunrise' => NULL,
                    'sunset' => NULL,                                        
                );
            }
            $data['items'] = $items;        

            $repository = new WeatherRepository($data);
            return $repository;
        } else {
            $repository = $this->getForecast();
            return $repository;
        }
    }
    
    private function getForecastTimesByDt ( $dt ) {
        $sunrise = date('Gi', $this->sunrise);
        $sunset = date('Gi', $this->sunset);
        $hour = date('Gi', $dt);
        
        if ($hour >= $sunrise && $hour < $sunset ) {
            return 'day';
        } else {
            return 'night';
        }       
    }
    
    public function getCurrentSessionId() {
        return $this->currentSessionId;
    }

    public function setCurrentSessionId($currentSessionId) {
        $this->currentSessionId = $currentSessionId;
        return $this;
    }
 
    public function getTimeDiff() {
        return $this->timeDiff;
    }

    public function setTimeDiff($timeDiff) {
        $this->timeDiff = $timeDiff;
        return $this;
    }
    
    public function getSession() {
        return $this->session;
    }
    
}