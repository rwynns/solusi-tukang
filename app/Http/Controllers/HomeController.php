<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\SubJasa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with jasa list
     */
    public function index()
    {
        $jasaList = Jasa::oldest()->get();
        return view('index', compact('jasaList'));
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
