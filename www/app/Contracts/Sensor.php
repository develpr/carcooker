<?php namespace CarCooker\Contracts;

interface Sensor
{
    /**
     * @return SensorReading | null
     */
    public function getLatestSensorReading();

    /**
     * @return double
     */
    public function getAverageTemperatureReading();

    /**
     * @return SensorReading | null
     */
    public function getFirstTemperatureReading();

    /**
     * @param array $data
     * @return mixed
     */
    public function addReadingData(array $data);
    

}