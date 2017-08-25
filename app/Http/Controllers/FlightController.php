<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 8/25/17
 * Time: 4:06 PM
 */

namespace App\Http\Controllers;


use Carbon\Carbon;

class FlightController extends Controller
{
    public function flights(){

        $MSPToDFW = '{
  "request": {
    "passengers": {
      "adultCount": 1
    },
    "slice": [
      {
        "origin": "MSP",
        "destination": "DFW",
        "date": "2017-11-14",
        "maxStops": 0
      },
      {
        "origin": "DFW",
        "destination": "MSP",
        "date": "2017-11-19",
        "maxStops": 0
      }
    ]
  }
}';
        $MSPToSEA = '{
  "request": {
    "passengers": {
      "adultCount": 1
    },
    "slice": [
      {
        "origin": "MSP",
        "destination": "SEA",
        "date": "2017-11-14",
        "maxStops": 0
      },
      {
        "origin": "SEA",
        "destination": "MSP",
        "date": "2017-11-19",
        "maxStops": 0
      }
    ]
  }
}';
        $PDXToANC = '{
  "request": {
    "passengers": {
      "adultCount": 1
    },
    "slice": [
      {
        "origin": "PDX",
        "destination": "ANC",
        "date": "2017-11-14",
        "maxStops": 0
      },
      {
        "origin": "ANC",
        "destination": "PDX",
        "date": "2017-11-19",
        "maxStops": 0
      }
    ]
  }
}';
        $first = $this->getFlights($MSPToDFW);
        $second = $this->getFlights($MSPToSEA);
        $third = $this->getFlights($PDXToANC);
        $date= Carbon::now();


        return view('flightLayout')->withFirst($first)->withSecond($second)->withThird($third)->withDate($date);
    }

    public function getFlights($postData){
        $array = [];
        $array1 = [];
        $url = "https://www.googleapis.com/qpxExpress/v1/trips/search?key=".env("Flights_API_KEY");
        $curlConnection = curl_init();

        curl_setopt($curlConnection, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($curlConnection, CURLOPT_URL, $url);
        curl_setopt($curlConnection, CURLOPT_POST, TRUE);
        curl_setopt($curlConnection, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curlConnection, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
        $results = curl_exec($curlConnection);
        $response = json_decode($results);
        curl_close ($curlConnection);
        $depAirline = $response->trips->tripOption[0]->slice[0]->segment[0]->flight->carrier;
        $depFlightNumber = $response->trips->tripOption[0]->slice[0]->segment[0]->flight->number;
        $retAirline = $response->trips->tripOption[0]->slice[1]->segment[0]->flight->carrier;
        $retFlightNo = $response->trips->tripOption[0]->slice[1]->segment[0]->flight->number;
        $fare = $response->trips->tripOption[0]->pricing[0]->saleTotal;
        $date= date("Y/m/d");
        $time = date("h:i:sa");
        array_push($array,$date);
        array_push($array,$time);
        array_push($array,$depAirline);
        array_push($array,$depFlightNumber);
        array_push($array,$retAirline);
        array_push($array,$retFlightNo);
        array_push($array,explode("USD",$fare)[1]);
        $file = fopen('flights.csv','a');
        fputcsv($file,$array);
        fclose($file);
        array_push($array1,$depAirline);
        array_push($array1,$depFlightNumber);
        array_push($array1,$retAirline);
        array_push($array1,$retFlightNo);
        array_push($array1,$fare);
        return $array1;
    }
}