<?php

namespace App\Http\Controllers;

use App\Models\CarWash;
use Illuminate\Http\Request;

class CarWashController extends Controller
{

    public function create(){
        return view('owner.createCarWash');
    }
    public function store(Request $request)
    {

        $validate = $request->validate([
            'name'=>'required|string|max:255',
            'address'=>'required|string',
            'lat'=>'required|numeric',
            'lng'=>'required|numeric',
        ]);

        CarWash::create([
            'user_id'=>auth()->id(),
            'name'=>$validate['name'],
            'address'=>$validate['address'],
            'lat'=>$validate['lat'],
            'lng'=>$validate['lng'],
        ]);
        return redirect()->back()->with('success','car wash created successfully');
    }
}
