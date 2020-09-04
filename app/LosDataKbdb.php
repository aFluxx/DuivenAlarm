<?php

namespace App;

use App\Flight;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class LosDataKbdb extends Model
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
    protected $table = 'los_data_kbdb';

    public function setLosplaatsAttribute($value)
    {
        $this->attributes['losplaats'] = ucfirst(strtolower($value));
    }

    public function setOpmerkingAttribute($value)
    {
        $this->attributes['opmerking'] = ucfirst(strtolower($value));
    }

    public static function notifyUsers($flightsThatWereUpdated)
    {
        foreach ($flightsThatWereUpdated as $flight) {
            foreach (Flight::where('id', $flight['losplaats_id'])->with('devices')->first()->devices as $device) {
                $headers = [
                    'Authorization' => 'key=AAAAmii6OEI:APA91bGtqwXxmUCaryyXT-eVOREBzLhQ7FlLGoGXFfl2TljmgTCilqck8IzCpq1A-rrvS4fT-f8_wbatC5g1UgyNMYGX8yw-a__-GDaEn8NnWA0urJj32egouFSGv5OxoByRL-a2bAsI',
                    'Content-Type' => 'application/json',
                ];

                $body = [
                    "notification" => [
                        'title' => 'Nieuwe lossingsinformatie',
                        'subtitle' => '',
                        'body' => "{$flight['losplaats']} is net gelost om {$flight['losuur']}. \n {$flight['opmerking']}",
                        "click_action" => "GENERAL",
                        "badge" => 1,
                        "sound" => "default",
                    ],
                    "to" => $device->token,
                    "content_available" => true,
                ];

                $request = new Request('POST', 'https://fcm.googleapis.com/fcm/send', $headers, json_encode($body));

                $client = new Client();
                $response = $client->send($request);
            }
        }
    }
}
