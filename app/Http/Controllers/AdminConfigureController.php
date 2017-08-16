<?php

namespace App\Http\Controllers;

use App\File;
use App\Topic;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AdminConfigureController extends Controller
{
    //
    public function runConfigure(Request $request)
    {
        try {
            $jsonData = $request->json()->all();
            $registers = $jsonData('registers');
            $topics = $jsonData('topics');

            $resultTopics =[];

            //todo: check duplicate and add topic to database
            $topics = array_unique($topics, SORT_STRING);
            foreach ($topics as $topic) {
                $newTopic = new Topic;
                $newTopic->name = $topic;
                $newTopic->save();
                $resultTopics[] = ["id" => $newTopic->id, "name"=>$newTopic->name];
            }

            //todo create config.json contains configuration of client
            $configData = \GuzzleHttp\json_encode(["register" => $registers,
                "topics" => $resultTopics]);
            $fp = fopen('config.json', 'w');
            fwrite($fp, $configData);
            fclose($fp);

            //todo: copy config.json to node folder
            $moveFile = new Process("cp config.json ../node");
            $moveFile->run();

            if (!$moveFile->isSuccessful()) {
                throw new ProcessFailedException($moveFile);
            }



            //todo: run webpack
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
            return response()->json(["success" => true, url => "http://localhost:3000/dist/bundle.js"]);
        }
        catch (Exception $e) {
            return response()->json(["success" => false]);
        }
    }
}
