<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LosDataDuivenspel extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'los_data_duivenspel';

    public function setLosplaatsAttribute($value)
    {
        $this->attributes['losplaats'] = ucwords(strtolower($value));
    }

    public function setOpmerkingAttribute($value)
    {
        $this->attributes['opmerking'] = ucwords(strtolower($value));
    }
}
