<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChessService;

class ChessController extends Controller
{
    protected $chessService;

    public function __construct(ChessService $chessService)
    {
        $this->chessService = $chessService;
    }

    public function findShortestPath(Request $request)
    {
        $request->validate([
            'start' => 'required|array|size:2',
            'start.0' => 'integer|min:0|max:7',
            'start.1' => 'integer|min:0|max:7',
            'end' => 'required|array|size:2',
            'end.0' => 'integer|min:0|max:7',
            'end.1' => 'integer|min:0|max:7',
        ]);

        $start = $request->input('start');
        $end = $request->input('end');

        $path = $this->chessService->getShortestPath($start, $end);

        return response()->json([
            'start' => $start,
            'end' => $end,
            'path' => $path,
            'steps' => count($path) - 1
        ]);
    }
}
