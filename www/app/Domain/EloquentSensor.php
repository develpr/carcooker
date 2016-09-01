<?php namespace CarCooker\Domain;

use CarCooker\Contracts\Sensor;
use Illuminate\Database\Eloquent\Model;

class EloquentSensor extends Model implements Sensor
{
    protected $table = "sensors";

    /**
     * @return EloquentSensorReading
     */
    public function getLatestSensorReading()
    {
        return $this->sensorReadings()->orderBy('created_at', 'desc')->first();
    }

    /**
     * @return double
     */
    public function getAverageTemperatureReading()
    {
        return round($this->sensorReadings()->avg('temperature'), 1);
    }

    /**
     * @return EloquentSensorReading | null
     */
    public function getFirstTemperatureReading()
    {
        return $this->sensorReadings()->orderBy('created_at', 'asc')->first();
    }

    /**
     * Get the sensor readings associated with this sensor
     */
    public function sensorReadings()
    {
        return $this->hasMany(EloquentSensorReading::class, 'sensor_id');
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addReadingData(array $data)
    {
        return $this->sensorReadings()->create($data);
    }


}