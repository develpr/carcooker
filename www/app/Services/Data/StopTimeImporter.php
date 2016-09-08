<?php  namespace CarCooker\Services\Data;

use CarCooker\Contracts\Sensor;
use CarCooker\Contracts\SensorReading;
use CarCooker\Domain\EloquentSensorReading;
use CarCooker\Exceptions\StaleDataException;
use Illuminate\Config\Repository as Config;

class StopTimeImporter {

	/**
	 * @var \Illuminate\Config\Repository
	 */
	private $config;
	/**
	 * @var \CarCooker\Services\Data\StopDataSource
	 */
	private $stopDataSource;

	/**
	 * StopTimeImporter constructor.
	 * @param Config $config
     */
	function __construct(StopDataSource $stopDataSource, Config $config)
	{
		$this->config = $config;
		$this->stopDataSource = $stopDataSource;
	}

	/**
	 * @param Sensor $sensor
	 * @return string
	 */
	public function getTime()
	{

		$data = $this->stopDataSource->getRawDataFromApi();

		return $data;

	}

} 