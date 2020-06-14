<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Passport;
use GuzzleHttp\Client;


class UserRepository extends BaseRepository {

    public function getList($conditions, $columns, $orderBy, $skip, $take)
    {
        $result = User::where('is_deleted', '=', 0)->where($conditions);

        if(!is_null($columns))
            $result = $result->select($columns);

        if(!is_null($orderBy))
        {
            $result = $result->orderBy($orderBy->column, $orderBy->dir);
        }

        return [
            'items' => $result->skip($skip)->take($take)->get(),
            'totalCount' => $result->count()
        ];
    }

    public function getOTP($phone)
    {
        $rand = rand(100,999) . rand(100,999);
        Log::info('otp = '.$rand.', phone = '.$phone);
        cache()->remember($phone, now()->addMinutes(12), function () use ($rand) {
                return $rand;
        });
        $mobile = 964 . substr($phone,1);
        $client = new Client();
        $response = $client->post('http://sms-gw.net:81/v2/api/Gateway/SendMessage' , [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1laWRlbnRpZmllciI6IjE2ZGMwNmEyLThkYWQtNDcyYy1hNDBhLWY3YmQwYWVhZDAxNyIsImVtYWlsIjoiZW5qYXpAc21zLWd3Lm5ldCIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL25hbWUiOiJFTkpBWiIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvcm9sZSI6IkN1c3RvbWVyIiwiaHR0cDovL3NjaGVtYXMueG1sc29hcC5vcmcvd3MvMjAwOS8wOS9pZGVudGl0eS9jbGFpbXMvYWN0b3IiOiIyIiwianRpIjoiODQ0MzM3NzAtM2VlMS00NjY3LTg4ODktMDBjOWZhNDdmNDRkIiwibmJmIjoxNTc2NTk0OTAwLCJleHAiOjE2MDgyMTczMDAsImlzcyI6Iklzc3VlciIsImF1ZCI6IkF1ZGllbmNlIn0.xh9avMxWnwHH-uh1QPjLij5CWW5p5fF3ENz4A0xjHb4',
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                'number' => $mobile,
                'text' => ' Please Insert This Code ' . $rand,
                'messageType' => 3,
                'sentThrough' => 1
                ]
            ]);
        if ($response)
        {
            return [
                'response' => 'message sent.',
                'code'=> 200,
            ];
        }
        return [
            'response' => 'error occurred.',
            'code'=> 401,
        ];
    }

    /**
     * checking if OTP is correct and authenticate the User
     * @param $phone
     * @return array
     * @throws \Exception
     */
    public function loginWithOTP($cache, $data)
    {
        if (!is_null($cache))
        {
            if (!($cache == (int)$data['OTP']))
            {
                return [
                    'response' => 'wrong OTP.',
                    'code' => 401,
                ];
            }
            $User = User::where('phone', $data['phone'])->first();
            if (is_null($User))
            {
                $newUser = $this->createModel(new User($data));


                $token = $newUser->createToken('Personal Access Token');
                $token->token->expires_at = Carbon::now()->addMonths(6);
                return [
                    'response' => [
                        'User' => $newUser,
                        'token' => $token->accessToken,
                    ],
                    'code' => 200,
                ];
            }
            $token = $User->createToken('Personal Access Token');
            $token->token->expires_at = Carbon::now()->addMonths(6);
            return [
                'response' => [
                    'User' => $User,
                    'token' => $token->accessToken,

                ],
                'code' => 200,
            ];

        }
        return [
            'response' => 'cache time-out',
            'code' => 401,
        ];
    }



}
