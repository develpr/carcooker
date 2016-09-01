<?php  namespace CarCooker\Repositories;

use CarCooker\Contracts\Repositories\SensorRepository;
use CarCooker\Domain\EloquentSensor;
use CarCooker\Domain\EloquentSensorReading;
use CarCooker\Services\Data\SensorDataSource;
use CarCooker\Services\Data\SensorReadingsImporter;
use Illuminate\Config\Repository as Config;

class EloquentSensorRepository implements SensorRepository{

	/**
	 * @var \CarCooker\Domain\EloquentSensor
	 */
	private $sensor;
	/**
	 * @var \Illuminate\Config\Repository
	 */
	private $config;
	/**
	 * @var SensorReadingsImporter
	 */
	private $importer;

	/**
	 * EloquentSensorRepository constructor.
	 * @param EloquentSensor $sensor
	 * @param SensorReadingsImporter $importer
	 * @param Config $config
     */
	function __construct(EloquentSensor $sensor, SensorReadingsImporter $importer, Config $config)
	{
		$this->sensor = $sensor;
		$this->config = $config;
		$this->importer = $importer;
	}

	/**
	 * This is somewhat heavy lifting, and it's by choice y'all!
	 *
	 * @param $id
	 * @return EloquentSensor | null
	 */
	public function findById($id)
	{
		/** @var EloquentSensor $sensor */
		$sensor = $this->sensor->find($id);

		if( ! $sensor ){
			return null;
		}

		$sensor = $this->importer->freshenSensor($sensor);

		return $sensor;
	}

	/**
	 * todo: this is not dry
	 *
	 * @param EloquentSensorReading $sensorReading
	 * @return bool
	 */
	private function freshSensorReadingRequired(EloquentSensorReading $sensorReading){

		if(is_null($sensorReading))
			return true;

		return ($sensorReading->getReadingTime()->diffInSeconds() > $this->config->get('carcooker.data_age_threshold'));
	}

} 