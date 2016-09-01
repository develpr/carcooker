<?php

use Illuminate\Database\Seeder;

class SensorReadingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sensor_readings')->delete();

        \CarCooker\Domain\EloquentSensorReading::create([
            'id' => 1,
            'temperature' => 82.42,
            'created_at' => new Carbon\Carbon("July 1st"),
            'sensor_id' => 1
        ]);

        \CarCooker\Domain\EloquentSensorReading::create([
            'id' => 2,
            'temperature' => 72.42,
            'created_at' => new Carbon\Carbon("July 9"),
            'sensor_id' => 1
        ]);

        \CarCooker\Domain\EloquentSensorReading::create([
            'id' => 3,
            'temperature' => 62.212,
            'sensor_id' => 1
        ]);
    }
}
