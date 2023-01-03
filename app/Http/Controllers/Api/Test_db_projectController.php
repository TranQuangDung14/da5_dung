<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\test_db_project;
use Illuminate\Support\Facades\DB;
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


    public function upload(Request $request){
        $result =$request->file('file')->store('image');
        return ["result"=>$result];
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
        // DB::beginTransaction();
        // try {
        //     $test_db = new test_db_project();
        //     // $test
        //     $test_db->name         =  (!empty($request->name)) ? $request->name : null;
        //     $test_db->number_phone =  (!empty($request->number_phone)) ? $request->number_phone : null;
        //     $test_db->testdb1_id =  (!empty($request->testdb1_id)) ? $request->testdb1_id : null;
        //     $test_db->email =  (!empty($request->email)) ? $request->email : null;
        //     $test_db->adress =  (!empty($request->adress)) ? $request->adress : null;

        //     $test_db->save();
        //     // DB::commit();

        // }catch(\Exception $e){
        //     // DB::rollback();
        // }
        $data = $request->only('name','number_phone','email','adress','testdb1_id');
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
