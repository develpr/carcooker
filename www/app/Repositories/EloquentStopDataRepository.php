<?php  namespace CarCooker\Repositories;

use CarCooker\Contracts\Repositories\StopTimeRepository;
use CarCooker\Domain\EloquentSensor;
use CarCooker\Services\Data\SensorReadingsImporter;
use CarCooker\Services\Data\StopTimeImporter;
use Illuminate\Config\Repository as Config;

class EloquentStopSensorRepository implements StopTimeRepository{
	
	/**
	 * @var \Illuminate\Config\Repository
	 */
	private $config;
	private $importer;

	/**
	 * EloquentSensorRepository constructor.
	 * @param EloquentSensor $sensor
	 * @param SensorReadingsImporter $importer
	 * @param Config $config
     */
	function __construct(StopTimeImporter $importer, Config $config)
	{
		$this->config = $config;
		$this->importer = $importer;
	}

	/**
	 * This is somewhat heavy lifting, and it's by choice y'all!
	 *
	 * @param $id
	 * @return EloquentStopSensorRepository | null
	 */
	public function getStopTime()
	{
		/** @var EloquentSensor $sensor */

		$time = $this->importer->getTime();

		return $time;
	}


} 