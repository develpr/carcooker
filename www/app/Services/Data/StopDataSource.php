<?php  namespace CarCooker\Services\Data;

use Illuminate\Config\Repository as Config;

class StopDataSource{

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
		$sourceUrl = $this->config->get('carcooker.stop_time_data_source_uri');

		try{
			$time = file_get_contents($sourceUrl);
		}catch(\Exception $e){
			//todo: log this, send an email notification, etc ?
			return null;
		}


		if( ! $time ){
			return null;
		}

		//todo: note that we've built this so that we could in theory support additional sensors, but we're "faking" it
		//Current temperature is: 76.019140625
		$result = [
			'stopTime' => $time,
		];

		return $result;
	}

} 