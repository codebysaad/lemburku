<?php

namespace App\Http\Controllers;

use App\Imports\PegawaisImport;
use App\Models\PangkatGol;
use App\Models\Pegawai;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
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
        $item_menu = 'pegawai';
        $pangkat = PangkatGol::get();
        if ($request->ajax()) {
            $data = Pegawai::join('pangkat_gols', 'pegawais.pangkat_id', '=', 'pangkat_gols.id')
                ->select('pegawais.id', 'pegawais.nip', 'pegawais.nama', 'pegawais.jabatan', 'pangkat_gols.name', 'pegawais.created_at', 'pegawais.updated_at')
                ->latest()
                ->get();
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

        return view('pages.admin.master.pegawai', compact('menu', 'sub_menu', 'item_menu', 'pangkat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Pegawai::updateOrCreate(
            ['id' => $request->id],
            ['pangkat_id' => $request->pangkat_id, 'nip' => $request->nip, 'nama' => $request->nama, 'jabatan' => $request->jabatan]
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
        $user = Pegawai::find($id);
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
        Pegawai::find($id)->delete();

        return response()->json(['success' => 'Data deleted successfully.']);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        try {
            Excel::import(new PegawaisImport, $request->file);
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
