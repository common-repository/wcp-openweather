<?php
namespace Webcodin\WCPOpenWeather\Plugin;

use Webcodin\WCPOpenWeather\Core\Agp_RepositoryAbstract;

class WeatherRepository extends Agp_RepositoryAbstract {

    public $entityClass = 'Webcodin\WCPOpenWeather\Plugin\WeatherEntity';    
    
    /**
     * City
     * 
     * @var CityEntity
     */
    private $city;
    
    public function __construct($data = NULL) {
        parent::__construct($data['items']);
        $this->city = new CityEntity($data['city']);
    }
    
    public function init () {
        
    }    
    
    /**
     * City
     * 
     * @return CityEntity
     */
    public function getCity() {
        return $this->city;
    }

    public function applySettings($settings) {
        foreach ($this->getAll() as $entity) {
            $entity->applySettings($settings);
        }
    }

    public function applyThemeUrl($themeUrl) {
        foreach ($this->getAll() as $entity) {
            $entity->applyThemeUrl($themeUrl);
        }
    }    
    
}
