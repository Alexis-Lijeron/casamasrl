<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailReporteRequest;
use App\Mail\EnviarTablaMail;
use App\Mail\ReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function reporteVentas(Request $request)
    {
        $data = json_decode($request->message, true);
        return view('emails.ventas', compact('data'));
    }

    public function reporteCompras(Request $request)
    {
        $data = json_decode($request->message, true);
        return view('emails.compras', compact('data'));
    }

    public function enviarReporteVentas(EmailReporteRequest $request)
    {
        $emails = $request->to;
        $subject = $request->subject;
        $content = $request->content;

        // Inicializar el array de archivos
        // $files = [];

        // if ($request->hasFile('attachment')) {
        //     foreach ($request->file('attachment') as $file) {
        //         $filename = $file->getClientOriginalName();
        //         $file->storeAs('pdfs', $filename);

        //         // Agregar el nombre del archivo al array
        //         $files[] = $filename;
        //     }
        // }

        $data = [
            'subject' => $subject,
            'content' => $content,
            'type' => 'ventas',
            // 'files' => $files
        ];

        $toAddresses = explode(',', $emails);
        $toAddresses = array_map('trim', $toAddresses);

        $enviado = false;

        foreach ($toAddresses as $to) {
            $result = Mail::to($to)->send(new ReportMail($data));
            if ($result) {
                $enviado = true;
            }
        }

        if (!$enviado) {
            session()->flash('error', 'No se pudo enviar el reporte');
            return redirect()->back();
        }

        session()->flash('enviado', 'Reporte enviado correctamente');
        return redirect()->route('reportes.ventas');
    }

    public function enviarReporteCompras(EmailReporteRequest $request)
    {
        $emails = $request->to;
        $subject = $request->subject;
        $content = $request->content;

        $data = [
            'subject' => $subject,
            'content' => $content,
            'type' => 'compras'
        ];

        $toAddresses = explode(',', $emails);
        $toAddresses = array_map('trim', $toAddresses);

        $enviado = false;

        foreach ($toAddresses as $to) {
            $result = Mail::to($to)->send(new ReportMail($data));
            if ($result) {
                $enviado = true;
            }
        }

        if (!$enviado) {
            session()->flash('error', 'No se pudo enviar el reporte');
            return redirect()->back();
        }

        session()->flash('enviado', 'Reporte enviado correctamente');
        return redirect()->route('reportes.compras');
    }
}
