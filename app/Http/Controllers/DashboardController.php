<?php
// ========================
// app/Http/Controllers/DashboardController.php
// ========================
namespace App\Http\Controllers;

use App\Models\DiagnosisSession;
use App\Models\Article;
use App\Services\BurnoutExpertService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $latestDiagnosis = DiagnosisSession::where('user_id', $user->id)->latest()->first();
        $totalDiagnosis = DiagnosisSession::where('user_id', $user->id)->count();
        $riwayat = DiagnosisSession::where('user_id', $user->id)->latest()->take(5)->get();
        $articles = Article::published()->latest()->take(3)->get();

        return view('dashboard.index', compact('user', 'latestDiagnosis', 'totalDiagnosis', 'riwayat', 'articles'));
    }
}
