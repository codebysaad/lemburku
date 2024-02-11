<?php

namespace App\Http\Controllers;

use App\Imports\PangkatGolsImport;
use App\Models\PangkatGol;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PangkatGolController extends Controller
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
        $item_menu = 'pangkat';
        if ($request->ajax()) {
            $data = PangkatGol::latest()->get();
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

        return view('pages.admin.master.pangkat', compact('menu', 'sub_menu', 'item_menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        PangkatGol::updateOrCreate(
            ['id' => $request->id],
            ['gol' => $request->gol, 'name' => $request->name]
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
        $pangkat = PangkatGol::find($id);
        return response()->json($pangkat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PangkatGol::find($id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        try {
            Excel::import(new PangkatGolsImport, $request->file);
            // return response()->json(['success' => 'Data deleted successfully.']);
            Alert('Success', 'Data Berhasil Diimport', 'success');
            return redirect()->back();
        } catch (Exception $e) {
            // return response()->json(['error' => $e->getMessage()]);
            Alert('Success', $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
