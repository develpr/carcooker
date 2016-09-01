<?php  namespace CarCooker\Services\Data;

use CarCooker\Contracts\Sensor;
use CarCooker\Contracts\SensorReading;
use CarCooker\Domain\EloquentSensorReading;
use CarCooker\Exceptions\StaleDataException;
use Illuminate\Config\Repository as Config;

class SensorReadingsImporter {

	/**
	 * @var \Illuminate\Config\Repository
	 */
	private $config;
	/**
	 * @var \CarCooker\Services\Data\SensorDataSource
	 */
	private $sensorDataSource;

	/**
	 * SensorReadingsImporter constructor.
	 * @param SensorDataSource $sensorDataSource
	 * @param Config $config
     */
	function __construct(SensorDataSource $sensorDataSource, Config $config)
	{
		$this->config = $config;
		$this->sensorDataSource = $sensorDataSource;
	}

	/**
	 * @param Sensor $sensor
	 * @return string
	 */
	public function freshenSensor(Sensor $sensor)
	{
		if( ! $sensor ){
			return null;
		}

		//If the sensor reading is fresh do nothing
		if( ! $this->freshSensorReadingRequired($sensor->getLatestSensorReading())){
			return $sensor;
		}

		$data = $this->sensorDataSource->getRawDataFromSensor($sensor->id);

		//todo: log this, send an email notification, etc ?
		if( ! $data ){

			//If the sensor data is old and we NEEDED fresh data then we'll throw an exception here
			if( ! $this->config->get('carcooker.serve_stale_data') ){
				//todo: note this may not technically be "stale" - if null was returned
				throw new StaleDataException("Unable to refresh stale sensor data for sensor " . $sensor->id);
			}

			return $sensor;
		}

		$sensor->addReadingData($data);

		return $sensor;

	}

	/**
	 * todo: this isn't dry as it's repeated in the EloquentSensorRepository
	 * Check if the sensor reading we have is past the configured "freshness" margin
	 * @param SensorReading $sensorReading
	 * @return bool
	 */
	private function freshSensorReadingRequired($sensorReading){

		if(is_null($sensorReading))
			return true;

		return ($sensorReading->getReadingTime()->diffInSeconds() > $this->config->get('carcooker.data_age_threshold'));
	}

} 