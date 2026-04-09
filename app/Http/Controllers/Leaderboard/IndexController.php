<?php

namespace App\Http\Controllers\Leaderboard;

use App\Actions\Leaderboard\GetLeaderboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    public function __construct(private readonly GetLeaderboard $getLeaderboard) {}

    public function __invoke(Request $request): Response|JsonResponse
    {
        $leaderboard = $this->getLeaderboard->handle();

        if ($request->expectsJson()) {
            return response()->json($leaderboard);
        }

        return Inertia::render('leaderboard/index', [
            'leaderboard' => $leaderboard,
        ]);
    }
}
