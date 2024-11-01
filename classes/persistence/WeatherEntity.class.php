<?php
namespace Webcodin\WCPOpenWeather\Plugin;

use Webcodin\WCPOpenWeather\Core\Agp_Entity;

class WeatherEntity extends Agp_Entity {

    private $temperature;
    
    private $pressure;
    
    private $humidity;
    
    private $windSpeed; 
    
    private $windDeg;
    
    private $weatherId;
    
    private $weatherMain;
    
    private $weatherDescription;
    
    private $weatherIcon;
    
    private $weatherIconUrl;
    
    private $day;
    
    private $tempUnit;
    
    private $clouds;
    
    private $sunrise;
    
    private $sunset;
    
    
    public function __construct($data) {
        $default = array(
            'ID' => NULL, 
        );

        parent::__construct($data, $default); 
    }
    
    public function applySettings($settings) {
        $this->tempUnit = '';
        $convertor = new Convertor(RPw());
        if (!empty($settings['tempUnit'])) {
            $fieldSet = RPw()->getSettings()->getFieldSet('temp');
            $this->tempUnit = $fieldSet[$settings['tempUnit']];
            
            if (is_object($this->temperature)) {
                $this->temperature = $convertor->temperatureObject($this->temperature, $settings['tempUnit']);    
            } else {
                $this->temperature = $convertor->temperature($this->temperature, $settings['tempUnit']);    
            }
        }
        if (!empty($settings['windSpeedUnit'])) {
            $this->windSpeed = $convertor->speed($this->windSpeed, $settings['windSpeedUnit']);
        }        
        
        if (!empty($settings['pressureUnit'])) {
            $this->pressure = $convertor->pressure($this->pressure, $settings['pressureUnit']);
        }        
        $this->windDeg = $convertor->degree($this->windDeg);
        $this->humidity = !empty($this->humidity) ? $this->humidity. '%' : '-';
        $this->clouds = !empty($this->clouds) ? $this->clouds. '%' : '-';
        $this->day = $this->getId();
    }
    
    public function applyThemeUrl($themeUrl) {
        $this->weatherIconUrl = $themeUrl . '/images/weather/' . $this->weatherIcon. '.png';
    }
    
    public function getTemperature() {
        return $this->temperature;
    }

    public function setTemperature($temperature) {
        $this->temperature = $temperature;
        return $this;
    }

    public function getPressure() {
        return $this->pressure;
    }

    public function setPressure($pressure) {
        $this->pressure = $pressure;
        return $this;
    }
    
    public function getHumidity() {
        return $this->humidity;
    }

    public function setHumidity($humidity) {
        $this->humidity = $humidity;
        return $this;
    }
    
    public function getWindSpeed() {
        return $this->windSpeed;
    }

    public function setWindSpeed($windSpeed) {
        $this->windSpeed = $windSpeed;
        return $this;
    }
    
    public function getWindDeg() {
        return $this->windDeg;
    }

    public function setWindDeg($windDeg) {
        $this->windDeg = $windDeg;
        return $this;
    }

    public function getWeatherId() {
        return $this->weatherId;
    }

    public function getWeatherMain() {
        return $this->weatherMain;
    }

    public function getWeatherDescription() {
        return $this->weatherDescription;
    }

    public function getWeatherIcon() {
        return $this->weatherIcon;
    }

    public function setWeatherId($weatherId) {
        $this->weatherId = $weatherId;
        return $this;
    }

    public function setWeatherMain($weatherMain) {
        $this->weatherMain = $weatherMain;
        return $this;
    }

    public function setWeatherDescription($weatherDescription) {
        $this->weatherDescription = $weatherDescription;
        return $this;
    }

    public function setWeatherIcon($weatherIcon) {
        $this->weatherIcon = $weatherIcon;
        return $this;
    }

    public function getWeatherIconUrl() {
        return $this->weatherIconUrl;
    }

    public function setWeatherIconUrl($weatherIconUrl) {
        $this->weatherIconUrl = $weatherIconUrl;
        return $this;
    }
    
    public function getDay() {
        return $this->day;
    }

    public function setDay($day) {
        $this->day = $day;
        return $this;
    }
    
    public function getTempUnit() {
        return $this->tempUnit;
    }

    public function setTempUnit($tempUnit) {
        $this->tempUnit = $tempUnit;
        return $this;
    }
    
    public function getTempUnitShort() {
        return str_replace("&deg;", '', __($this->getTempUnit(), 'wcp-openweather'));
    }

    public function getClouds() {
        return $this->clouds;
    }

    public function setClouds($clouds) {
        $this->clouds = $clouds;
        return $this;
    }

    public function getSunrise() {
        return $this->sunrise;
    }

    public function getSunset() {
        return $this->sunset;
    }

    public function setSunrise($sunrise) {
        $this->sunrise = $sunrise;
        return $this;
    }

    public function setSunset($sunset) {
        $this->sunset = $sunset;
        return $this;
    }
}
