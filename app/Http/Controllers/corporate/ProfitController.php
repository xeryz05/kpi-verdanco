<?php

namespace App\Http\Controllers\corporate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\corporate\Profit;
use App\Models\periode\Event;
use App\Http\Requests\Corporate\ProfitRequest;

class ProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profits = Profit::get();
        // @dd($profits);
        return view('admin.corporate.net_profits.index', compact('profits'));
    }

     public function create(){
        $events = Event::get();
        return view('admin.corporate.net_profits.create', compact('events'));
    }
    public function store(ProfitRequest $request){
        Profit::create($request->all());
        
        return redirect()->route('profits.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function edit(Profit $profit){
        $event = Event::get();

        return view('admin.corporate.net_profits.edit', compact('profit','event'));
    }

    public function update(ProfitRequest $request, Profit $profit){
        $profit->update($request->all());

        return redirect()->route('profits.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function destroy(Profit $profit){
        $profit->delete();

        return redirect()->route('profits.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
}
