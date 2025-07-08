<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\SubJasa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with jasa list and reviews
     */
    public function index()
    {
        $jasaList = Jasa::oldest()->get();

        // Get the latest reviews - limit to 6 for display
        $latestReviews = \App\Models\Review::with(['user', 'order', 'order.items.subJasa.jasa'])
            ->latest()
            ->take(6)
            ->get();

        return view('index', compact('jasaList', 'latestReviews'));
    }

    /**
     * Display jasa detail with its sub-jasa
     */
    public function jasaDetail(Jasa $jasa)
    {
        // Eager load sub jasa
        $jasa->load('subJasa');

        return view('detail-jasa', compact('jasa'));
    }

    /**
     * API endpoint for sub-jasa details
     */
    public function getSubJasaDetail(SubJasa $subJasa)
    {
        return response()->json($subJasa);
    }
}
