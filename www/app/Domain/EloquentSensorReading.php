<?php namespace CarCooker\Domain;


use Carbon\Carbon;
use CarCooker\Contracts\SensorReading;
use Illuminate\Database\Eloquent\Model;

class EloquentSensorReading extends Model implements SensorReading
{

    protected $table = "sensor_readings";

    protected $fillable = ['temperature'];

    /**
     * @return double
     */
    public function getTemperature()
    {
        return round(doubleval($this->temperature), 1);
    }

    /**
     * @return Carbon
     */
    public function getReadingTime()
    {
        return $this->created_at;
    }

    /**
     * Get the sensor readings associated with this sensor
     */
    public function sensor()
    {
        return $this->belongsTo(EloquentSensor::class);
    }
}