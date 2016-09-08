<?php

return [


    //how many seconds until the data should be considered to be "old" and refreshed?
    'data_age_threshold' => 10,

    //is it ok to serve "stale" data if fresh data is not available for some reason
    'serve_stale_data' => true,

    //todo: this could be expanded to support multiple sensors if desired
    'data_source_uri' => 'http://carcookies.kristenchonowski.com/api/readTemp.php',

    'stop_time_data_source_uri' => 'http://carcookies.kristenchonowski.com/api/stopTime.php'

];
