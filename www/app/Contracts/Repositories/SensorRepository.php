<?php  namespace CarCooker\Contracts\Repositories;

use CarCooker\Contracts\SensorReading;

interface SensorRepository {

	/**
	 * @param integer $id
	 * @return Sensor | null
	 */
	public function findById($id);

} 