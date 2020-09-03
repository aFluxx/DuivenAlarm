<?php

namespace App;

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
            $headers = [
                'Authorization' => 'key=AAAAmii6OEI:APA91bGtqwXxmUCaryyXT-eVOREBzLhQ7FlLGoGXFfl2TljmgTCilqck8IzCpq1A-rrvS4fT-f8_wbatC5g1UgyNMYGX8yw-a__-GDaEn8NnWA0urJj32egouFSGv5OxoByRL-a2bAsI',
                'Content-Type' => 'application/json',
            ];

            $body = [
                "data" => [
                    'title' => 'Nieuwe lossingsinformatie',
                    'subtitle' => '',
                    'text' => "{$flight['losplaats']} is net gelost om {$flight['losuur']}. \r\n Opmerking: {$flight['opmerking']}",
                    "click_action" => "GENERAL",
                    "badge" => 1,
                    "sound" => "default",
                ],
                "to" => "flJOVi9ShYE:APA91bGEzp2dsIv4ITfQ3fnH-mBNImzGnP58pddsmTN0hPERx-VbUjjrCxxrXpSjIgLRs0Pc1V-b0UTGiR7XpxYk7dEBlKnRSLGUqQFUU-Z8figAO45BvqOxu94jkIGMfYzFwV9AkAKq",
                "content_available" => true,
                "priority" => "high",
            ];

            $request = new Request('POST', 'https://fcm.googleapis.com/fcm/send', $headers, json_encode($body));

            $client = new Client();
            $response = $client->send($request);
        }
    }
}
