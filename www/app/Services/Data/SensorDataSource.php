<?php  namespace CarCooker\Services\Data;

use Illuminate\Config\Repository as Config;

class SensorDataSource{

	const TEMPERATURE_STRING_PREFIX = 'Current temperature is: ';

	/**
	 * @var \Illuminate\Config\Repository
	 */
	private $config;

	function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * @return array
	 */
	public function getRawDataFromSensor($sensorId)
	{
		$sourceUrl = $this->config->get('carcooker.data_source_uri');

		try{
			$raw = file_get_contents($sourceUrl);
		}catch(\Exception $e){
			//todo: log this, send an email notification, etc ?
			return null;
		}

		$temperature = $this->getTemperatureFromRawResponse($raw);

		if( ! $temperature ){
			return null;
		}

		//todo: note that we've built this so that we could in theory support additional sensors, but we're "faking" it
		//Current temperature is: 76.019140625
		$result = [
			'temperature' => $temperature,
		];

		return $result;
	}

	private function getTemperatureFromRawResponse($raw){
		$raw = strtolower($raw);
		if(strpos($raw, strtolower(self::TEMPERATURE_STRING_PREFIX)) === false){
			return false;
		}
		return str_replace(strtolower(self::TEMPERATURE_STRING_PREFIX), '', $raw);
	}

} 