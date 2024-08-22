<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Day;

class ApiController extends Controller
{
    public function getVoys(Request $request)
    {
        $days = Day :: all();

        return response()->json([
            'status' => 'success',
            'messages' => $days
        ]);
    }
}
