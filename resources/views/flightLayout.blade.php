@extends('flights')

@section('firstFlight')
    <h1>MSP TO DFW</h1>
    <div>depAirline: {{$first[0]}}</div>
    <div>depFlightNo: {{$first[1]}}</div>
    <div>retAirline: {{$first[2]}}</div>
    <div>retFlightNo: {{$first[3]}}</div>
    <div>fare: {{explode("USD",$first[4])[1]}}</div>
@stop

@section('secondFlight')
    <h1>MSP TO SEA</h1>
    <div>depAirline: {{$second[0]}}</div>
    <div>depFlightNo: {{$second[1]}}</div>
    <div>retAirline: {{$second[2]}}</div>
    <div>retFlightNo: {{$second[3]}}</div>
    <div>fare: {{explode("USD",$second[4])[1]}}</div>
@stop

{{--@section('thirdFlight')--}}
    {{--@if($third)--}}
        {{--<h1>PDX TO ANC</h1>--}}
        {{--<div>depAirline: {{$third[0]}}</div>--}}
        {{--<div>depFlightNo: {{$third[1]}}</div>--}}
        {{--<div>retAirline: {{$third[2]}}</div>--}}
        {{--<div>retFlightNo: {{$third[3]}}</div>--}}
        {{--<div>fare: {{explode("USD",$third[4])[1]}}</div>--}}
    {{--@endif--}}
{{--@stop--}}
@section('date')
    {{$date}}
@stop