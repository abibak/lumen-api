<?php

namespace App\Http\Controllers;


use App\Events\FinishedMatch;
use App\Http\Requests\LotteryGameMatchRequest;
use App\Models\LotteryGameMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class LotteryGameMatchController extends Controller
{
    public function index($lottery_game_id)
    {
        try {
            $id = (!is_numeric($lottery_game_id) ? throw new \Exception('Error request.') : $lottery_game_id);

            $matches = LotteryGameMatch::where('game_id', '=', $id)->get();

            return response()->json([
                'data' => $matches
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        }

    }

    public function create(Request $request, LotteryGameMatchRequest $lotteryRequest)
    {
        $validate = $lotteryRequest->validate($request->all(), 'create');

        if (!empty($validate)) {
            return response()->json([
                'errors' => $validate
            ]);
        }

        if (Carbon::parse($request->start_date)->getTimestamp() < Carbon::now()->getTimestamp()) {
            return response()->json([
                'message' => 'Start date is invalid.',
            ]);
        }

        $match_create = LotteryGameMatch::create($request->all());

        if ($match_create) {
            return response()->json([
                'data' => $match_create
            ], 201);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $lottery_match = LotteryGameMatch::where('id', '=', $id)->first();

            if ($lottery_match) {
                if ($lottery_match->is_finished) {
                    throw new \Exception('Finished match.');
                }

                $lottery_match->update(['is_finished' => (is_bool($request->is_finished) ? $request->is_finished : false)]);

                if ($lottery_match) {
                    event(new FinishedMatch($lottery_match, $id));

                    return response()->json([
                        'data' => $lottery_match,
                        'message' => 'Success updated',
                    ], 200);
                }
            }

            throw new \Exception('Lottery game not found.');
        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        }
    }
}
