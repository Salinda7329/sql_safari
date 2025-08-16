<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlGameController extends Controller
{
    public function showLevel($level)
    {
        // Load level data from DB
        $levelData = DB::table('levels')->where('id', $level)->first();
        if (!$levelData) abort(404);

        return view('sql-game', ['level' => $levelData]);
    }

    public function runQuery(Request $request, $level)
    {
        $userQuery = $request->input('query');

        // Get expected query from DB
        $levelData = DB::table('levels')->where('id', $level)->first();
        if (!$levelData) {
            return response()->json(['success' => false, 'message' => 'Level not found']);
        }
        $expectedQuery = $levelData->expected_query;

        try {
            $userResult = DB::select($userQuery);
            $expectedResult = DB::select($expectedQuery);

            if ($userResult == $expectedResult) {
                return response()->json([
                    'success' => true,
                    'message' => "Correct! You’ve cleared " . $levelData->province . " Province!",
                    'result' => $userResult
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Incorrect. Try again!",
                    'result' => $userResult
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Error: " . $e->getMessage()
            ]);
        }
    }
}
