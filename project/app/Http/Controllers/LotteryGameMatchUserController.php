<?php

namespace App\Http\Controllers;


use App\Events\RecordingUserMatch;
use App\Http\Requests\LotteryGameMatchUserRequest;
use App\Http\Traits\User;
use App\Models\LotteryGameMatchUser;
use Illuminate\Http\Request;

class LotteryGameMatchUserController extends Controller
{
    use User;

    public function create(Request $request, LotteryGameMatchUserRequest $matchUserRequest)
    {
        $data = $this->decode_token($request->header('Authorization'));
        $validate = $matchUserRequest->validate($request->all(), 'create');

        if (!empty($validate)) {
            return response()->json([
                'errors' => $validate
            ]);
        }

        try {
            event(new RecordingUserMatch($request->user_id, $request->lottery_game_match_id));

            if ($data->sub == $request->user_id) {
                $record = LotteryGameMatchUser::create($request->all());

                if ($record) {
                    return response()->json([
                        'data' => $record,
                        'message' => 'Success recorded.'
                    ], 201);
                }
            }

            throw new \Exception('Error recorded.');
        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        }
    }
}
