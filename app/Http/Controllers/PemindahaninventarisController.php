<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pemindahaninventaris;
use Illuminate\Support\Facades\Gate;

class PemindahaninventarisController extends Controller
{
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } 
        $data = pemindahaninventaris::all(); 
        return view('admin/pages/pemindahaninventaris/pemindahaninventaris', ['data' => $data]); 
    }
}
