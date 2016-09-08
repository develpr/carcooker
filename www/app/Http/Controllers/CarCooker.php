<?php  namespace CarCooker\Http\Controllers;

use CarCooker\Contracts\Repositories\StopTimeRepository;
use CarCooker\Contracts\Sensor;
use CarCooker\Contracts\Repositories\SensorRepository;
use CarCooker\Device;
use CarCooker\Services\Data\StopDataSource;
use Illuminate\Routing\Controller as BaseController;
use \Alexa;

class CarCooker extends  BaseController{

	const AUDIO_DING_URI = 'https://s3-us-west-2.amazonaws.com/alexaappstore/audio/carcooker/ding.mp3';
	const AUDIO_TICKTOCK_URI = 'https://s3-us-west-2.amazonaws.com/alexaappstore/audio/carcooker/ticktock.mp3';

	private $stationRepository;
	/**
	 * @var SensorRepository
	 */
	private $sensorRepository;
	private $stopTimeRepository;

	/**
	 * Biker constructor.
	 * @param SensorRepository $sensorRepository
     */
	function __construct(SensorRepository $sensorRepository, StopTimeRepository $stopTimeRepository)
	{
		$this->sensorRepository = $sensorRepository;
		$this->stopTimeRepository = $stopTimeRepository;
	}

	/**
	 * Handle the launch event for the app
	 */
	public function handleLaunch(){
//		$device = $this->retrieveOrCreateDevice();
		return Alexa::say("Hello, I am Arrow Lab's car cookies cooking assistant. Car Cookie timer initiated. C is for cookie and cookie is for me!");
	}

	/**
	 * Handle the launch event for the app
	 */
	public function handleSessionEnded(){
		return Alexa::say("You’re saving one for me, right?")->endSession();
	}

	public function tellMeAboutCarCookies(){
		/** @var Sensor $sensor */
		$sensor = $this->sensorRepository->findById(1);
		if( ! $sensor ){
			Alexa::say("Sorry, I can't find a sensor with ID " . Alexa::slot("Id"))->endSession();
		}

		$latestSensorReading = $sensor->getLatestSensorReading();

		if( ! $latestSensorReading ){
			Alexa::say("Sorry, wasn't able to retrieve a sensor reading!")->endSession();
		}

		$stopDataSource = $this->stopTimeRepository->getStopTime();
		$time = $stopDataSource->getRawDataFromSensor();

		$ssml = '<speak><audio src="'.self::AUDIO_DING_URI.'" />Car temperature is <say-as interpret-as="unit">'.$latestSensorReading->getTemperature().' degrees fahrenheit</say-as>. The cookies have been cooking for <say-as interpret-as="time">' . $time . '</say-as></speak>';
		return Alexa::ssml($ssml)->endSession();
	}

	public function currentTemperature(){
		/** @var Sensor $sensor */
		$sensor = $this->sensorRepository->findById(Alexa::slot("Id"));
		if( ! $sensor ){
			Alexa::say("Sorry, I can't find a sensor with ID " . Alexa::slot("Id"))->endSession();
		}

		$latestSensorReading = $sensor->getLatestSensorReading();

		if( ! $latestSensorReading ){
			Alexa::say("Sorry, wasn't able to retrieve a sensor reading!")->endSession();
		}

		$ssml = '<speak>The car cooker is currently <say-as interpret-as="unit">'.$latestSensorReading->getTemperature().' degrees fahrenheit</say-as></speak>';
		\Log::debug($ssml);
		$result = Alexa::ssml($ssml)->endSession()->toJson();
		\Log::debug($result);
		return Alexa::ssml($ssml)->endSession();

	}

	public function areCookiesDone(){

		/** @var Sensor $sensor */
		$sensor = $this->sensorRepository->findById(1);
		if( ! $sensor ){
			Alexa::say("Well I'm not positive, because I can't check the temperature right now... but probably not!");
		}

		$latestSensorReading = $sensor->getLatestSensorReading();
		if( ! $latestSensorReading ){
			Alexa::say("Sorry, wasn't able to retrieve a sensor reading!")->endSession();
		}

		if($latestSensorReading->getTemperature() > 70){
			$ssml = '<speak><audio src="'.self::AUDIO_DING_URI.'" /> The car oven is <say-as interpret-as="unit">'.$latestSensorReading->getTemperature().' degrees fahrenheit</say-as> so the cookies should be done!</speak>';
		}

		else{
			$ssml = '<speak><audio src="'.self::AUDIO_TICKTOCK_URI.'" /> The car oven is <say-as interpret-as="unit">'.$latestSensorReading->getTemperature().' degrees fahrenheit</say-as> so the cookies are probably not quite done!<audio src="'.self::AUDIO_TICKTOCK_URI.'" /></speak>';
		}

		\Log::debug($ssml);
		$result = Alexa::ssml($ssml)->endSession()->toJson();
		\Log::debug($result);
		return Alexa::ssml($ssml)->endSession();
	}

	private function getCookieQuote(){
		$quotes = [
			'Num num num num num',
			'Cookies are made of butter and love',
			'Life is better with fresh baked cookies',
			'A balanced diet is a cookie in each hand',
			'When the going gets tough, the tough make cookies',
			'That’s the way the cookie crumbles'
		];

		$randomNumber = mt_rand(0,5);

		return $quotes[$randomNumber];
	}

	/**
	 * @return \Develpr\AlexaApp\Contracts\AmazonEchoDevice|Device|null
	 */
	private function retrieveOrCreateDevice(){
		$device = Alexa::device();

		if( ! $device ){
			$device = new Device;
			$device->setDeviceId(\Alexa::request()->getUserId());
			$device->save();
		}

		return $device;
	}


} 