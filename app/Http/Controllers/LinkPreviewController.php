<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;

class LinkPreviewController extends Controller
{
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

    public function getLink(Request $request)
    {

        $url = $request->query('url');

        /////////////Init result//////////////////////
        $res = array(
            "result" => array("status"=> "OK"),
            "meta" => array(
                "url" => $url,
                "title" => "",
                "favicon" => "http://local.chat.com/api/file?url=files/default-favicon.png",
                "image" => "http://local.chat.com/api/file?url=files/default-favicon.png",
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
            if (strpos(strtolower($key), 'description') !== false) {
                $res["meta"]["description"] = $value;
            }
        }

        ////////////////////FAVICON////////////////////////////////
        $res["meta"]["favicon"] = 'https://www.google.com/s2/favicons?domain=' . $url;
        $res["meta"]["image"] = 'https://www.google.com/s2/favicons?domain=' . $url;

        $res["meta"]["title"] = $this->getTitleHTML($url);
        return response()->json($res);
        //        return $meta;
        //return $meta;
    }
}
