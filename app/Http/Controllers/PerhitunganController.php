<?php

namespace App\Http\Controllers;

use App\Imports\PerhitunganImport;
use App\Imports\PerhitunganLembursImport;
use App\Models\Lembur;
use App\Models\LemburFix;
use App\Models\PangkatGol;
use App\Models\Pegawai;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PerhitunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = 'perhitungan';
        $sub_menu = 'submenu';
        $item_menu = 'lembur';
        $pegawai = Pegawai::get();
        if ($request->ajax()) {
            // $data = Lembur::join('pegawais', 'lemburs.pegawai_id', '=', 'pegawais.id')
            //     ->join('pangkat_gols', 'pegawais.pangkat_id', '=', 'pangkat_gols.id')
            //     ->select('lemburs.id', 'lemburs.tgl_lembur', 'lemburs.pegawai_id', 'pegawais.nip', 'pegawais.nama', 'pangkat_gols.name', 'lemburs.mulai', 'lemburs.akhir', 'lemburs.pengajuan_awal', 'lemburs.pengajuan_akhir', 'lemburs.durasi_pengajuan', 'lemburs.harga', 'lemburs.created_at', 'lemburs.updated_at')
            //     ->latest()
            //     ->get();
            $data = LemburFix::latest()->get();
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

        return view('pages.admin.perhitungan.lembur', compact('menu', 'sub_menu', 'item_menu', 'pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Lembur::updateOrCreate(
            ['id' => $request->id],
            [
                'pegawai_id' => $request->pegawai_id, 'tgl_lembur' => $request->tgl_lembur,
                'mulai' => $request->mulai, 'akhir' => $request->akhir, 'pengajuan_awal' => $request->pengajuan_awal, 'pengajuan_akhir' => $request->pengajuan_akhir,
                'durasi_pengajuan' => $request->durasi_pengajuan, 'harga' => $request->harga
            ]
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
        $data = Lembur::find($id);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lembur::find($id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        try {
            Excel::import(new PerhitunganImport, $request->file);
            // Excel::import(new PerhitunganLembursImport, $request->file);
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
