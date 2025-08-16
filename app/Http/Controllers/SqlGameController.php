<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlGameController extends Controller
{
    public function index()
    {
        return view('sql-game');
    }

    public function runQuery(Request $request)
    {
        $userQuery = $request->input('query');

        //Correct Answer for Level 1
        $expectedQuery = "SELECT name, country, check_in
                          FROM tourists t
                          JOIN bookings b ON t.tourist_id = b.tourist_id";

        try {
            // Run user's query
            $userResult = DB::select($userQuery);
            $expectedResult = DB::select($expectedQuery);

            // Compare results
            if ($userResult == $expectedResult) {
                return response()->json([
                    'success' => true,
                    'message' => "Correct! Well done!",
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
