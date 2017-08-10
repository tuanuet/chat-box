<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;

class UploadFileAPIController extends Controller
{
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
                $data['type'] = $file->getMimeType();

                if (substr($file->getMimeType(), 0, 5) == 'image') {
                    //            Store in disk
                    $path = $file->store('files');

                    $File = new File();
                    $File->name = $file->getClientOriginalName();
                    $File->url = $path;
                    $File->contentType = $file->getMimeType();
                    $File->save();

                    $data["status"] = 1;
                    $data["type"] = config('message.types.IMAGE');
                    $data["content"] = "http://local.chat.com/api/file?url=" . $path;
                }
            }
        }
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getFile(Request $request)
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

}
