<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(DashboardService $dashboardService): View
    {
        $usuario = auth()->user();
        $dashboardData = $dashboardService->getDashboardData($usuario);

        return view('dashboard', [
            'summary' => $dashboardData['summary'],
            'mainRate' => $dashboardData['mainRate'],
        ]);
    }
}
