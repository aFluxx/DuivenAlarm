<?php

namespace App;

use App\Device;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the devices which are subscribed to a flight.
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
