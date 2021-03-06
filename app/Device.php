<?php

namespace App;

use App\Flight;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The flights that a device is subscribed to
     */
    public function subscribedFlights()
    {
        return $this->belongsToMany(Flight::class);
    }
}
