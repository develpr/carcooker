<?php namespace CarCooker\Contracts;

use Carbon\Carbon;

interface SensorReading {

	/**
	 * @return double
	 */
	public function getTemperature();

	/**
	 * @return Carbon
	 */
	public function getReadingTime();

} 