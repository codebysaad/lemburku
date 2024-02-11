<?php

namespace App\Http\Controllers;

use App\Models\PangkatGol;
use App\Models\TarifLembur;
use App\Models\TarifLemburFix;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TarifLemburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = 'master';
        $sub_menu = 'submenu';
        $item_menu = 'tariflembur';
        $pangkat = PangkatGol::get();
        if ($request->ajax()) {
            // $data = TarifLembur::join('pangkat_gols', 'tarif_lemburs.gol_id', '=', 'pangkat_gols.id')
            //     ->select('tarif_lemburs.id', 'tarif_lemburs.tarif', 'tarif_lemburs.uang_makan', 'pangkat_gols.name', 'tarif_lemburs.created_at', 'tarif_lemburs.updated_at')
            //     ->latest()
            //     ->get();
            $data = TarifLemburFix::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn icon btn-primary me-md-2 editData" data-toggle="tooltip" data-original-title="Edit" data-id="' . $row->id . '"><i class="bi bi-pencil"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn icon btn-danger deleteData" data-toggle="tooltip" data-original-title="Delete" data-id="' . $row->id . '"><i class="bi bi-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.admin.master.tariflembur', compact('menu', 'sub_menu', 'item_menu', 'pangkat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TarifLembur::updateOrCreate(
        //     ['id' => $request->id],
        //     ['gol_id' => $request->gol_id, 'tarif' => $request->tarif, 'uang_makan' => $request->uang_makan]
        // );
        TarifLemburFix::updateOrCreate(
            ['id' => $request->id],
            ['gol' => $request->gol, 'tarif' => $request->tarif, 'uang_makan' => $request->uang_makan]
        );

        return response()->json(['success' => 'Data saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = TarifLemburFix::find($id);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TarifLemburFix::find($id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
