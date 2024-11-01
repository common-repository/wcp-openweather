<?php
namespace Webcodin\WCPOpenWeather\Plugin;

class ThemeRepository {

    /**
     * Data
     * 
     * @var array
     */
    private $data = array();
    
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
    
    public function add(ThemeEntity $entity) {
        if (!isset($this->data[$entity->getId()])) {
            $this->data[$entity->getId()] = $entity;    
        }
    }
    
    public function delete($id) {
        if (isset($this->data[$id])) {
            unset($this->data[$id]);
        }
    }        
    
    public function deleteAll() {
        unset($this->data);
        $this->data = array();
    }            
    
    public function findById ($id) {
        if (isset( $this->data[$id]) ) {
            return $result = &$this->data[$id];    
        }
    }
    
    public function getAll () {
        return $result = &$this->data;
    }

    public function getFirst () {
        if (!empty($this->data)) {
            $data = &$this->data;
            return $result = reset($data);    
        }
    }    
    
    public function getCount () {
        return count($this->data);
    }    
    
    public function moveDefaultToFirst () {
        if (!empty($this->data)) {
            foreach ($this->data as $id => $entity) {
                if ($entity->getIsDefaultTheme()) {
                    $this->data = array_merge( array($id => $entity), $this->data);
                }
            }
        }
        
    }
    
    public function getActive() {
        if (!empty($this->data)) {
            foreach ($this->data as $id => $entity) {
                if ($entity->getActive()) {
                    return $entity;
                }
            }
        }
    }
}
