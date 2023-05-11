<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $Voucher=Voucher::get();
            return response()->json([
                'voucher'=>$Voucher,
            ], 200);
        } catch (\Exception $e) {
          dd($e);
        }
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
    $request->validate([
        'discount_percentage' => 'required',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after:start_date',
    ]);

    $maxId = Voucher::max('id')+1;
    $code = 'VCID' . $maxId;

    $voucher = new Voucher();
    $voucher->code = $code;
    $voucher->discount_percentage = $request->discount_percentage;
    $voucher->start_date = $request->start_date;
    $voucher->end_date = $request->end_date;

    $voucher->save();

    return response()->json(['message' => 'Voucher được tạo thành công'], 201);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Voucher::findOrFail($id);
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
        $input = $request->all();
        $rules = array(
            'code' => 'required',
            'discount_percentage' => 'required',
        );
        $messages = array(
            'code.required' => 'Mã voucher không được phép trống!',
            'discount_percentage.required' => 'Chiết khấu không được phép trống!',
        );
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $data = $request->only('code', 'discount_percentage','start_date','end_date');
        $user = Voucher::findOrFail($id);
        $status = $user->update($data);
        // $status = Category_product::create($data);

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
        $Voucher = Voucher::findOrFail($id);
        $Voucher->delete();
        return response()->json([
            'messege' => 'Xóa thành công!',
        ], 200);
    }
}
