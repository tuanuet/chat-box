<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AdminConfigureController extends Controller
{
    //
    public function runConfigure(Request $request)
    {
        $jsonData = $request->json()->all();
        $registers = $jsonData('registers');
        $topics = $jsonData('topics');
        $configData = \GuzzleHttp\json_encode(["register" => $registers,
            "topics" => $topics]);
        $fp = fopen('config.json', 'w');
        fwrite($fp, $configData);
        fclose($fp);

        $moveFile = new Process("cp config.json ../node");
        $moveFile->run();

        if (!$moveFile->isSuccessful()) {
            throw new ProcessFailedException($moveFile);
        }


        $serverNode = "../node";

        $processBuildWebpack = new Process('webpack');

        $processBuildWebpack->setWorkingDirectory($serverNode);
        $processBuildWebpack->run();
        if (!$processBuildWebpack->isSuccessful()) {
            throw new ProcessFailedException($processBuildWebpack);
        }

        echo "webpack build successfully";

        $processRunServerNode = new Process('npm start');
        $processRunServerNode->setWorkingDirectory($serverNode);
        $processRunServerNode->run();
        if (!$processRunServerNode->isSuccessful()) {
            echo $processRunServerNode->getOutput();
        }
        echo "run server successfully";
        return "http://localhost:3000/dist/bundle.js";
    }
}
