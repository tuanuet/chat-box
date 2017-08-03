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

    /**
     * @param Request $request
     * @return string
     */
    public function adminUpload(Request $request)
    {
        $file = $request->file('fileToUpload');
        if ($file != NULL) {
            if ($file->isValid()) {
                if (substr($file->getMimeType(), 0, 5) != 'image') return redirect('files');
//                echo 'File Name: ' . $file->getClientOriginalName();
//                echo '<br>';
//
//                //Display File Extension
//                echo 'File Extension: ' . $file->getClientOriginalExtension();
//                echo '<br>';
//
//                //Display File Real Path
//                echo 'File Real Path: ' . $file->getRealPath();
//                echo '<br>';
//
//                //Display File Size
//                echo 'File Size: ' . $file->getSize();
//                echo '<br>';
//
//                //Display File Mime Type
//                echo 'File Mime Type: ' . $file->getMimeType();
//                echo '<br>';

                //            Store in disk
                $path = $file->store('files');
//                echo 'File Path: ' . $path;
//                echo '<br>';

                $File = new File();
                $File->name = $file->getClientOriginalName();
                $File->url = $path;
                $File->contentType = $file->getMimeType();
                $File->save();
            }
        }
        return redirect('files');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function upload(Request $request)
    {
        //return $request;
        //echo $request;
        $file = $request->file('fileToUpload');
        $data = array(
            "status" => 0,
            "type" => "",
            "content" => ""
        );
        if ($file != NULL) {
            if ($file->isValid()) {
                if (substr($file->getMimeType(), 0, 5) == 'image') {
                    //            Store in disk
                    $path = $file->store('files');

                    $File = new File();
                    $File->name = $file->getClientOriginalName();
                    $File->url = $path;
                    $File->contentType = $file->getMimeType();
                    $File->save();

                    $data["status"] = 1;
                    $data["type"] = "image";
                    $data["content"] = "http://local.chat.com/file?url=" . $path;
                }
            }
        }
        return json_encode($data);
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
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

    public function delete(Request $request)
    {
        $id = $request->query('id');

        ////get url of file from database////
        $file = File::where('id', $id)->first();
        if ($file == NULL) {
            return redirect('files');
        } else {
            $url = $file->url;

            /////Delete from storage////
            $urlFile = storage_path('/app/'. $url);
            if (file_exists($urlFile)) {
                //echo 'File exists!';
                Storage::delete($url);
            }
            ////Delete info in database
            $file->delete();
        }
        return redirect("files");
    }
}
