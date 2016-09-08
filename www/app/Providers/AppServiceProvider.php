<?php namespace CarCooker\Providers;

use CarCooker\Device;
use Illuminate\Support\ServiceProvider;
use CarCooker\Validators\DeviceCodeValidator;

class AppServiceProvider extends ServiceProvider
{
    private $simpleBindings = [
        \CarCooker\Contracts\Repositories\SensorRepository::class => \CarCooker\Repositories\EloquentSensorRepository::class,
        \CarCooker\Contracts\Sensor::class => \CarCooker\Domain\EloquentSensor::class,
        \CarCooker\Contracts\SensorReading::class => \CarCooker\Domain\EloquentSensorReading::class,
        \CarCooker\Contracts\Repositories\StopTimeRepository::class => \CarCooker\Repositories\StopTimeRepository::class,
    ];
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerEloquentListeners();
        $this->registerValidators();
        $this->registerErrorHandlers();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->simpleBindings as $contract => $service) {
            $this->app->bind($contract, $service);
        }
    }

    private function registerErrorHandlers(){
    }

    private function registerEloquentListeners()
    {

    }

    private function registerValidators()
    {

    }
}
