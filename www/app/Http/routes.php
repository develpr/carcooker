<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return "Hello!";
});

AlexaRoute::launch('/alexa', 'CarCooker\Http\Controllers\CarCooker@handleLaunch');

AlexaRoute::sessionEnded('/alexa', 'CarCooker\Http\Controllers\CarCooker@handleSessionEnded');

AlexaRoute::intent('/alexa', 'CurrentTemperature', 'CarCooker\Http\Controllers\CarCooker@currentTemperature');

AlexaRoute::intent('/alexa', 'AreCookiesDone', 'CarCooker\Http\Controllers\CarCooker@areCookiesDone');

AlexaRoute::intent('/alexa', 'AverageTemp', 'CarCooker\Http\Controllers\CarCooker@averageTemperature');

AlexaRoute::intent('/alexa', 'TellMe', 'CarCooker\Http\Controllers\CarCooker@tellMeAboutCarCookies');

