<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(Request $request)
    {
        return view('home.index', [
            'nama' => 'Fahmi',
            'tanggal' => '<div style="color:red">' . date('Y-m-d') . '</div>'
        ]);
    }
}
