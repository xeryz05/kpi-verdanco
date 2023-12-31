<?php

namespace App\Http\Controllers\Departement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departement\viitem;
use App\Models\Departement;
use App\Models\periode\Event;
use App\Imports\ViitemImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Corporate\RevenueRequest;

use Illuminate\Support\Facades\Auth;

class viitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viitems = viitem::get();
        $dept = Departement::get();
        $event = Event::get();

        // @dd($items);

        return view('kpi_departement.item.vi.index', compact('viitems','dept','event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->rules($request);

        $viitem = new viitem();
        $viitem->departement_id = $request->departement_id;
        $viitem->event_id = $request->event_id;
        $viitem->area = $request->area;
        $viitem->kpi = $request->kpi;
        $viitem->calculation = $request->calculation;
        $viitem->target = $request->target;
        $viitem->weight = $request->weight;
        $viitem->realization = $request->realization;
        $viitem->created_by = Auth::user()->id;
        $viitem->updated_by = Auth::user()->id;
        $viitem->save();
        
        return redirect()->route('viitem.index')->with(['success' => 'Data Berhasil Disimpan!']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(viitem $viitem)
    {
        return view('kpi_departement.item.vi.edit', compact('viitem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, viitem $viitem)
    {
        $this->validate($request, [
            'area' => 'required',
            'kpi' => 'required',
            'calculation' => 'required',
            'target' => 'required',
            'weight' => 'required|max:100',
            'realization' => 'numeric',
        ]);

        $viitem->update([
            'area' => $request->area,
            'kpi' => $request->kpi,
            'calculation' => $request->calculation,
            'target' => $request->target,
            'weight' => $request->weight,
            'realization' => $request->realization,
        ]);

      return redirect()->route('viitem.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = viitem::findOrFail($id);
        $item->delete();

        return redirect()->route('viitem.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function rules($request){
        $request->validate([
            'area' => 'required',
            'kpi' => 'required',
            'calculation' => 'required',
            'target' => 'required',
            'weight' => 'required|max:100',
            'departement_id' => 'required',
            'event_id' => 'required'
        ]);
    }

    public function import(Request $request)
    {
        Excel::import(new ViitemImport, $request->file('file'));
        // dd($request->file('file'));
        return redirect()->back()->with('success', 'All good!');
    }
}
