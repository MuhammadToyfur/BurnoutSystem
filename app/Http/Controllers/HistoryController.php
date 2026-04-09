<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiagnosisSession;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        // Riwayat (WAJIB paginate)
        $riwayat = DiagnosisSession::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        // Chart (pakai get)
        $chartData = DiagnosisSession::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get()
            ->reverse()
            ->values();

        return view('history.index', compact('riwayat', 'chartData'));
    }
}