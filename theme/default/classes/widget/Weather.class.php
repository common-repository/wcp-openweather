<?php
namespace Webcodin\WCPOpenWeather\Theme\DefaultTheme;

use Webcodin\WCPOpenWeather\Plugin\WeatherWidgetAbstract;

class Weather extends WeatherWidgetAbstract {
    
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 'description' => __( "Adds weather to sidebar", 'wcp-openweather-theme') );
		parent::__construct( 'wcp_weather_widget', __('WCP Weather', 'wcp-openweather-theme'), $widget_ops);
	}
}

    