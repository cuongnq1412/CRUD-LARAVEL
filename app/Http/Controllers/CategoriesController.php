<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = DB::table('danhmuc')->get();
        return view('categories',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validatedData=$request->validate([
            'name'=>'required|string|max:100',
            'description'=>'required|string|max:500',
            'user_id'=>'required|integer'
        ]);
        $query=DB::table('danhmuc')->insert([
            'TenDM'=>$validatedData['name'],
            'MoTa'=>$validatedData['description'],
            'MaTK'=>$validatedData['user_id'],
            'NgayTao'=>now()


        ]);

        return redirect()->back();
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
    public function edit($id)
    {
        $data = DB::table('danhmuc')->get();
        $dataDM = DB::table('danhmuc')->where('MaDM',$id)->first();
        return view('categories',compact('dataDM','data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataDM = DB::table('danhmuc')->where('MaDM',$id)->first();

        $validatedData=$request->validate([
            'name'=>'required|string|max:100',
            'description'=>'required|string|max:500',

        ]);
        $query=DB::table('danhmuc')->where('MaDM',$id)->update([
            'TenDM'=>$validatedData['name'],
            'MoTa'=>$validatedData['description'],




        ]);

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check =  DB::table('danhmuc')->where('MaDM',$id)->first();
        if ($check) {
            DB::table('danhmuc')->where('MaDM', $id)->delete();

            return redirect()->back()->with('alert',[
                'type'=>'success',
                'message'=>'Xóa danh mục thành công !'
        ]);
        }else{
            return redirect()->back()->with('alert',[
                'type'=>'error',
                'message'=>'Không tìm thấy danh mục !'
        ]);
        }

    }
}
