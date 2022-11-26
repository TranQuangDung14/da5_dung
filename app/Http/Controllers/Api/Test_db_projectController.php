<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\test_db_project;
use Illuminate\Support\Facades\Validator;


class Test_db_projectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return "đây là test db ";
        return test_db_project::all();
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

        //
        $input = $request->all();
        $rules = array(
            'name'=>'required',
            'email'=>'email',
        );
        $message = array(
            'name.required'=>'tên không được phép để trống',
            'email.email'=>'email chưa đúng định dạng!',

        );
        $validator = Validator::make($input,$rules,$message);
        if($validator->fails()){
            return response()->json([
                'error'=>$validator->errors()
            ]);
        }
        $data = $request->only('name','number_phone','email','adress');
        $status = test_db_project::create($data);
        if($status){
            return response()->json([
                'message'=> 'Thêm mới thành công!',
                // 'data'=>test_db_project::all(),
                'data'=>$data,
            ]);
        }
        else {
            return 'thất bại';
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
        return test_db_project::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        $input = $request->all();
        $rules = array(
            'name'=>'required',
            'email'=>'email',
        );
        $message = array(
            'name.required'=>'tên không được phép để trống',
            'email.email'=>'email chưa đúng định dạng!',

        );
        $validator = Validator::make($input,$rules,$message);
        if($validator->fails()){
            return response()->json([
                'error'=>$validator->errors()
            ]);
        }
        $data = $request->only('name','number_phone','email','adress');

        $user = test_db_project::findOrFail($id);
        $status = $user->update($data);
        if($status){
            return response()->json([
                'message'=> 'cập nhật thành công!',
                'data'=>$data,
            ]);
        }
        else {
            return 'thất bại';
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
        //
        $test_db = test_db_project::findOrFail($id);
        $test_db->delete();
        return 'xóa thành công';
    }
}
