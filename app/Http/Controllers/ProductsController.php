<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
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
        $danhmuc=DB::table('danhmuc')->get();
        $data = DB::table('sanpham')
        // ->leftJoin('danhmuc','sanpham.MaDM','=','danhmuc.MaDM')
        // ->select('*','danhmuc.TenDM as TenDM')
        ->get();
        return view('products',compact('data','danhmuc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id'=>'required|integer|exists:users,id',
            'm_sp' => 'required|string|unique:sanpham,MaSP',
            'ten_sp' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'mota' => 'required|string|max:1000',
            'danhmuc' => 'required|integer',
            'product_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


            $imageName = 'product_photo'.time().'.'
                                .$request->name.'.'
                                .$request->product_photo->extension();
            $request->product_photo->storeAs('public/products', $imageName);

            $data = [
                'MaSP' => $validatedData['m_sp'],
                'TenSP' => $validatedData['ten_sp'],
                'DonGia' => $validatedData['price'],
                'MoTa' => $validatedData['mota'],
                'MaDM' => $validatedData['danhmuc'],
                'MaTK' => $validatedData['user_id'],
                'HinhAnh' => 'storage/products/'.$imageName,
                'NgayTao' => now(),

            ];

            $query=DB::table('sanpham')->insert($data);

            if($query){
                return redirect()->back()->with('alert',[
                    'type'=>'success',
                    'message'=>'Thêm thàh thành công !'
            ]);
            }else{
                return redirect()->back()->with('alert',[
                    'type'=>'error',
                    'message'=>'Không thành công !'
            ]);
            }
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
        $danhmuc = DB::table('danhmuc')->get('*');
        $data = DB::table('sanpham')->get();
        $dataSP = DB::table('sanpham')
        // ->leftJoin('danhmuc','sanpham.MaDM','=','danhmuc.MaDM')
        // ->select('*','danhmuc.TenDM as TenDM')
        ->where('MaSP',$id)->first();
        return view('products',compact('dataSP','data','danhmuc'));
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

        $check=DB::table('sanpham')->where('MaSP', $id)->first();
        $validatedData = $request->validate([
            'user_id'=>'required|integer|exists:users,id',
            'm_sp' => 'required|string',
            'ten_sp' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'mota' => 'required|string|max:1000',
            'danhmuc' => 'required|integer',
            'product_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);



            $data = [
                'MaSP' => $validatedData['m_sp'],
                'TenSP' => $validatedData['ten_sp'],
                'DonGia' => $validatedData['price'],
                'MoTa' => $validatedData['mota'],
                'MaDM' => $validatedData['danhmuc'],
                'MaTK' => $validatedData['user_id'],
                'NgayTao' => now(),

            ];



            if ($request->hasFile('product_photo')) {
                if (file_exists(public_path($check->HinhAnh))) {
                    unlink(public_path($check->HinhAnh));

                }
                $imageName = 'product_photo'.time().'.'
                .$request->product_photo->extension();
                $request->product_photo->storeAs('public/products', $imageName);
                $data['HinhAnh'] ='storage/products/'.$imageName;
            }else{
                $data['HinhAnh'] =$check->HinhAnh;
            }

            $query=DB::table('sanpham')->where('MaSP',$id)->update($data);

            if($query){
                return redirect()->back()->with('alert',[
                    'type'=>'success',
                    'message'=>'Thêm thàh thành công !'
            ]);
            }else{
                return redirect()->back()->with('alert',[
                    'type'=>'error',
                    'message'=>'Không thành công !'
            ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check =  DB::table('sanpham')->where('MaSP',$id)->first();
        if ($check) {
            DB::table('sanpham')->where('MaSP', $id)->delete();

            return redirect()->back()->with('alert',[
                'type'=>'success',
                'message'=>'Xóa thành công !'
        ]);
        }else{
            return redirect()->back()->with('alert',[
                'type'=>'error',
                'message'=>'Không tìm thấy !'
        ]);
        }
    }
}
