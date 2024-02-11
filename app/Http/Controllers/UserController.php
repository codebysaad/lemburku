<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
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
        $item_menu = 'user';
        if ($request->ajax()) {
            $data = User::latest()->get();
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

        return view('pages.admin.master.user', compact('menu', 'sub_menu', 'item_menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name, 'email' => $request->email, 'password' => $request->password]
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
        $user = User::find($id);
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
        User::find($id)->delete();

        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
