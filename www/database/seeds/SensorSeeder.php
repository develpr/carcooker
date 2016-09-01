<?php

use Illuminate\Database\Seeder;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sensors')->delete();

        \CarCooker\Domain\EloquentSensor::create([
            'id' => 1,
        ]);
    }
}
