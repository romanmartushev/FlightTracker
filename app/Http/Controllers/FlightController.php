<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 8/25/17
 * Time: 4:06 PM
 */

namespace App\Http\Controllers;


use App\Flights;
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
        $date= Carbon::now('CST');

        return view('flightLayout')->withFirst($first)->withSecond($second)->withThird($third)->withDate($date);
    }
//    public function csv(){
//        $file = file('flights.csv');
//        foreach($file as $item){
//            $array = explode(",",$item);
//            $date = explode('/',$array[0]);
//            $date = implode('-',$date);
//            $time = $array[1][0].$array[1][1].$array[1][2].$array[1][3].$array[1][4].$array[1][5].$array[1][6].$array[1][7];
//            $flight = new Flights();
//            $flight->date = $date;
//            $flight->time = $time;
//            $flight->depAirline = $array[2];
//            $flight->depFlightNo = $array[3];
//            $flight->retAirline = $array[4];
//            $flight->retFlightNo = $array[5];
//            $flight->fare = $array[6];
//            $flight->comment = '';
//            $flight->save();
//        }
//    }

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
        $date= date("Y-m-d");
        $time = date("H:i:s");
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
        $fare = explode("USD",$fare)[1];
        $flight = new Flights();
        $flight->date = $date;
        $flight->time = $time;
        $flight->depAirline = $depAirline;
        $flight->depFlightNo = $depFlightNumber;
        $flight->retAirline = $retAirline;
        $flight->retFlightNo = $retFlightNo;
        $flight->fare = $fare;
        $flight->comment = '';
        $flight->save();

        return $array1;
    }
}