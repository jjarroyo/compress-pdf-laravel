<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ilovepdf\Ilovepdf;
class CompressPdfController extends Controller
{
 
    public function compressPdf(Request $request){      
        $file = $request->file('file');   
        $contents = file_get_contents($file);  
        $request->file('file')->move(public_path('pdfs'), $request->file('file')->getClientOriginalName());     
        $path = public_path('pdfs') . '/' . $request->file('file')->getClientOriginalName();
        $ilovepdf = new Ilovepdf('project_public_8b85675d246b0b95f5e2f4255e077f9a_NfUva671d654e70fd6227fa75d1032b6f57e2','secret_key_a0055a209c62d78c344a7ef7bafd835a_oQ1Z2d019b7c36c858b9583dd8b71b821be9c');
        $myTask = $ilovepdf->newTask('compress');
        $myTask->addFile($path);
        $myTask->execute();
        $myTask->download(public_path('pdfs')); 

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($path, 'compress.pdf', $headers);
    }
}
