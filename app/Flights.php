<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flights extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date','time','depAirline','depFlightNo','retAirline','retFlightNo','fare','comment'
    ];
}
