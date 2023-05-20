<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SampleEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $toEmail = $request->input('email');
        $emailData = [
            'name' => $request->input('name'),
            'message' => $request->input('message')
        ];

        Mail::to($toEmail)->send(new SampleEmail($emailData));

        return response()->json(['message' => 'Email đã được gửi thành công!']);
    }
}
