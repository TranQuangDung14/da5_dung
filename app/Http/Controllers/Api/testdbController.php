<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\test_db_project;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\testdb;
use Illuminate\Support\Facades\DB;

class testdbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json([
            'messege' => 'day la bản test db!',
            // 'data' => testdb::all(),
        ], 200);
        // return testdb::all();
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
        $input = $request->all();
        $rules = array(
            'name' => 'required',
            'age' => 'required',
            'sex' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'age.required' => 'tuổi không được phép trống!',
            'sex.required' => 'giới tính không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        DB::beginTransaction();
        try {
            // return $result;
            $test = new testdb();
            $test->name =  (!empty($request->name)) ? $request->name : null;
            $test->sex =  (!empty($request->sex)) ? $request->sex : null;
            $test->age =  (!empty($request->age)) ? $request->age : null;
            $test->phone =  (!empty($request->phone)) ? $request->phone : null;
            // $test->testdb1_id = $testdb_pro->id;
            // $product->image =  (!empty($request->image)) ? upload($request->file, $destination) : null;
            $test->save();
            foreach ( $request->testdb_pro as $answer) {
                test_db_project::create([
                    // 'username' => Auth::user()->name,
                    'name' => $request->name,
                    'number_phone' => $request->number_phone,
                    'email' => $request->email,
                    'adress' => $request->adress,
                    'testdb1_id' => $test->id
                    // 'correct_answer' => $answer,
                    // 'question_id' => $request->question_id,
                ]);
            }


            DB::commit();
            return response()->json([
                'messege' => $test,
                'testdb_pro'=>$answer,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return response()->json([
                'messege' => 'Thất bại!',
            ], 200);
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
        return testdb::findOrFail($id);
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
            'name' => 'required',
            'age' => 'required',
            'sex' => 'required',
        );
        $messages = array(
            'name.required' => 'Tên  không được phép trống!',
            'age.required' => 'tuổi không được phép trống!',
            'sex.required' => 'giới tính không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('name', 'sex', 'age','phone');
        $user = testdb::findOrFail($id);
        $status = $user->update($data);
        // $status = testdb::create($data);

        if ($status)
        {
            return response()->json([
                'messege' => 'Sửa thành công !',
            ], 201);
        } else {
            return response()->json([
                'messege' => 'Sửa thất bại!',
            ], 400);
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
        $testdb = testdb::findOrFail($id);
        $testdb->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
