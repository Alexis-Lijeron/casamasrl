<?php

namespace App\Http\Controllers;

use App\Mail\EnviarTablaMail;
use App\Mail\ReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function report()
    {
        return view('emails.index');
    }

    public function sendReport(Request $request)
    {
        $email = $request->to;
        // dd($email);
        Mail::to($email)->send(new ReportMail());
    }
}
