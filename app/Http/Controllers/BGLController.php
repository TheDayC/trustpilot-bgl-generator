<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BGLController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        if(!$request->user()->authorizeRoles(['administrator'])){ return redirect()->route('account'); }

        return view('createlinks');
    }
}