<?php

namespace App\Services;

class IPQualityScore {

    protected $phone;
    protected $key;

    public function __construct($phone)
    {
        $this->phone = $phone;
        $this->key = env('IPQUALITYSCORE_KEY');
    }

    public function verify(){
        // Retrieve additional (optional) data points which help us enhance fraud scores and ensure data is processed correctly.
        $countries = config('ipqualityscore.countries');
            
        // Create parameters array.
        $parameters = array(
            'country' => $countries
        );

        /* User & Transaction Scoring
        * Score additional information from a user, order, or transaction for risk analysis
        * Please see the documentation and example code to include this feature in your scoring:
        * https://www.ipqualityscore.com/documentation/phone-number-validation-api/transaction-scoring
        * This feature requires a Premium plan or greater
        */

        // Format Parameters
        $formatted_parameters = http_build_query($parameters);

        // Create API URL
        $url = sprintf(
            'https://www.ipqualityscore.com/api/json/phone/%s/%s?%s', 
            $this->key,
            $this->phone, 
            $formatted_parameters
        );

        // Fetch The Result
        $timeout = 5;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

        $json = curl_exec($curl);
        curl_close($curl);

        // Decode the result into an array.
        $result = json_decode($json, true);

        return $result;

    }
}