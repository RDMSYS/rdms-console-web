<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Exception;
// use Illuminate\Http\Request;

class ApiHandler
{
    public $path;
    private $api_server = "http://127.0.0.1:8080/api";
    public  function fetch(){
        if ($this->api_server != NULL && $this->path != NULL){
            $url = $this->api_server.'/'.$this->path;
            $c = curl_init();
                // curl_setopt($c, CURLOPT_HEADER, true);
                // curl_setopt($c, CURLOPT_NOBODY, true);  
                curl_setopt($c, CURLOPT_TIMEOUT,10);
                curl_setopt($c,CURLOPT_URL,$url);
                curl_setopt($c, CURLOPT_USERAGENT, 'rdms-console/1.0.0-alpha');
                curl_setopt($c,CURLOPT_RETURNTRANSFER,true);
            
                $res = curl_exec($c);
            if(curl_errno($c)){
                throw new ApiException('Error',curl_error($c));
            }else{
                $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);
                $decode = json_decode($res,true);
                curl_close($c);
                if($http_status == 404){
                    throw new ApiException('Failed to connect to CDN',"Usually means there's a issue in CDN Server",10001);
                }elseif ($http_status == 502) {
                    throw new ApiException($decode['head'],$decode['message'],502);
                }
                // $httpcode = curl_getinfo($c);

                if($decode['success']){
                    return($decode['data']);
                }else{
                    throw new ApiException($decode['head'],$decode['message'],10001);
                }
                
            }
            
                
                
        }
        return false;
    }
}