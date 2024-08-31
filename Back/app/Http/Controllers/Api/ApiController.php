<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Day;
use App\Models\Pit;

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

    public function getPits_Voys(Request $request)
    {
        $day_id = $request->input('day_id');

        // Recupera tutti i Pit associati al day con l'id specificato
        $Pits = Pit::whereHas('days', function($query) use ($day_id) {
            $query->where('day_id', $day_id);
        })
        ->get();

        return response()->json([
            'status' => 'success',
            'messages' => $Pits
        ]);
    }
}
