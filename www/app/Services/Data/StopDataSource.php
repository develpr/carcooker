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
	public function getRawDataFromApi()
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

		$result = [
			'stopTime' => $time,
		];

		return $result;
	}

} 