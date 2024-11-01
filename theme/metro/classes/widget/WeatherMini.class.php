<?php
namespace Webcodin\WCPOpenWeather\Theme\MetroTheme;

class WeatherMini extends ThemeWeatherWidget {
    
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 'description' => __( "Adds mini weather to sidebar", 'wcp-openweather-theme') );
		parent::__construct( 'wcp_weather_mini_widget', __('WCP Weather Mini', 'wcp-openweather-theme'), $widget_ops);
	}
    
}

    