<?php

namespace App\Http\Controllers;

use App\File;
use App\Topic;
use DOMDocument;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function getTopics() {
        $topics = Topic::all();
        return response()->json($topics);
    }

    public function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function getTitleHTML($url)
    {
        $html = $this->file_get_contents_curl($url);

        //parsing begins here:
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');

        //get and display what you need:
        $title = $nodes->item(0)->nodeValue;

        return $title;
    }

    public function isLink(Request $request)
    {
        $url = $request->query('url');
        $res = array(
            "result" => true,
            "meta" => array(
                "url" => $url,
                "title" => "",
                "image" => null,
                "description" => ""
            )
        );

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            //echo "Link is invalid";
            $res["result"] = false;
        }
        if ($res["result"] === true) {
            $meta = null;
            //return response()->json($header);
            $meta = get_meta_tags($url);
            /////////////////////Description///////////////////////////
            foreach ($meta as $key=>$value) {
                if (strpos(strtolower($key), 'description') !== false) {
                    $res["meta"]["description"] = $value;
                    //echo $key . PHP_EOL . $value;
                }

                if (strpos(strtolower($key), 'image') !== false) {
                    $res["meta"]["image"] = $value;
                }
            }

            ////////////////////Image////////////////////////////////
            if ($res["meta"]["image"] === null)
                $res["meta"]["image"] = 'https://www.google.com/s2/favicons?domain=' . $url;

            $res["meta"]["title"] = $this->getTitleHTML($url);
        }
        return response()->json($res);
//        return $meta;
    }

    public function getLink(Request $request)
    {

        $url = $request->query('url');

        /////////////Init result//////////////////////
        $res = array(
            "result" => array("status"=> "OK"),
            "meta" => array(
                "url" => $url,
                "title" => "",
                "image" => null,
                "description" => ""
            ));
        ////////////Check link is valid or not////////////////
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            //echo "Link is invalid";
            $res["result"]["status"] = 'ERROR';
            return response()->json($res);
        }
        $header = get_headers($url);
        $meta = null;
        //return response()->json($header);

        ////////////////////////STATUS//////////////////////////////////
        if ($header[0].containsString('200 OK')) {
            $res["result"]["status"] = 'OK';
            $meta = get_meta_tags($url);
        } else {
            $res["result"]["status"] = 'ERROR';
        }
        //$i = strpos("description", "description");
        //dd($i);
        /////////////////////Description///////////////////////////
        foreach ($meta as $key=>$value) {
            //echo ($key . PHP_EOL);
            //$str = $key . " " . strpos(strtolower($key), "description") . $value . PHP_EOL;
            //echo $str;
            //echo strtolower($key) . PHP_EOL;
            if (strpos(strtolower($key), 'description') !== false) {
                $res["meta"]["description"] = $value;
                //echo $key . PHP_EOL . $value;
            }

            if (strpos(strtolower($key), 'image') !== false) {
                $res["meta"]["image"] = $value;
            }
        }

        ////////////////////Image////////////////////////////////
        if ($res["meta"]["image"] === null)
            $res["meta"]["image"] = 'https://www.google.com/s2/favicons?domain=' . $url;

        $res["meta"]["title"] = $this->getTitleHTML($url);
        return response()->json($res);
        //        return $meta;
        //return $meta;
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
