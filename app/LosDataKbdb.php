<?php

namespace App;

use App\Flight;
use App\LossingsNotification;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

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
            $devices = Flight::where('id', $flight['losplaats_id'])->with('devices')->first()->devices;
            Log::info('Sending a notifiation to ' . count($devices) . ' devices');

            foreach ($devices as $device) {
                $headers = [
                    'Authorization' => 'key=AAAAmii6OEI:APA91bGtqwXxmUCaryyXT-eVOREBzLhQ7FlLGoGXFfl2TljmgTCilqck8IzCpq1A-rrvS4fT-f8_wbatC5g1UgyNMYGX8yw-a__-GDaEn8NnWA0urJj32egouFSGv5OxoByRL-a2bAsI',
                    'Content-Type' => 'application/json',
                ];

                $body = [
                    "notification" => [
                        'title' => 'Nieuwe lossingsinformatie',
                        'subtitle' => '',
                        'body' => "{$flight['losplaats']} is net gelost om {$flight['losuur']}. \n {$flight['opmerking']}",
                        "click_action" => "OPEN_ACTIVITY_1",
                        "badge" => 1,
                        "sound" => "default",
                    ],
                    "data" => [
                        'title' => 'Nieuwe lossingsinformatie',
                        'subtitle' => '',
                        'body' => "{$flight['losplaats']} is net gelost om {$flight['losuur']}. \n {$flight['opmerking']}",
                    ],
                    "to" => $device->token,
                    "content_available" => true,
                ];

                $request = new Request('POST', 'https://fcm.googleapis.com/fcm/send', $headers, json_encode($body));

                $client = new Client();
                $client->send($request);

                $notification = LossingsNotification::create([
                    'to_device' => $device->token,
                    'data' => json_encode($body),
                    'body' => json_encode($body["notification"]["body"]),
                    'losplaats' => $flight['losplaats'],
                    'losuur' => $flight['losuur'],
                    'opmerking' => $flight['opmerking'],
                ]);

                Log::info('New notification saved to database, with id #' . $notification->id);
                Log::info(' ');
            }
        }
    }
}
