<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{

    /**
     * FileController constructor.
     */
    function __construct()
    {
        $this->middleware('authenticate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::all();
//        dd($files);
        return view('file.file', ['files'=>$files]);
    }

    public function upload(Request $request)
    {
        //echo $request;
        $file = $request->file('fileToUpload');
        if ($file == NULL) {
            echo "No file";
        } else {
            if ($file->isValid()) {
                echo 'File Name: ' . $file->getClientOriginalName();
                echo '<br>';

                //Display File Extension
                echo 'File Extension: ' . $file->getClientOriginalExtension();
                echo '<br>';

                //Display File Real Path
                echo 'File Real Path: ' . $file->getRealPath();
                echo '<br>';

                //Display File Size
                echo 'File Size: ' . $file->getSize();
                echo '<br>';

                //Display File Mime Type
                echo 'File Mime Type: ' . $file->getMimeType();
                echo '<br>';

                //            Store in disk
                $path = $file->store('files');
                echo 'File Path: ' . $path;
                echo '<br>';

                $File = new File();
                $File->name = $file->getClientOriginalName();
                $File->url = $path;
                $File->contentType = $file->getMimeType();
                $File->save();
                return redirect('/files');
                //            Store in database
                //$data = file_get_contents($file->getRealPath());
//                return response()->download(storage_path('app/files/U19Gx4ouUICvOixyvVaQGjd8LlMvjnbGNHL8qjQG.png'));
            }
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getfile(Request $request)
    {
        $url = $request->query('url');
        //echo 'Request to get file from '. $url;
        //echo '<br>';

        $filename = storage_path('/app/'. $url);
        //$file = File::where('url', $url)->first();
        if (file_exists($filename)) {
            //echo 'File exists!';
            return response()->file($filename);
        } else {
            echo 'File doesn\'t exist!';
        }
    }

    public function download(Request $request)
    {
        $url = $request->query('url');
        //echo 'Request to get file from '. $url;
        //echo '<br>';

        $filename = storage_path('/app/'. $url);
        //$file = File::where('url', $url)->first();
        if (file_exists($filename)) {
            //echo 'File exists!';
            return response()->download($filename);
        } else {
            echo 'File doesn\'t exist!';
        }
    }
}
