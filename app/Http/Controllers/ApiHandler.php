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
                // throw new ApiException('Error',curl_error($c));
                throw new ApiException('Failed to connect to CDN',"Usually means there's a issue in CDN Server",10001);
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


    public function post($postData)
    {
        $ch = curl_init();
        $url = $this->api_server.'/'.$this->path;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json'
        // ));
        curl_setopt($ch, CURLOPT_USERAGENT, 'rdms-console/1.0.0-alpha');
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            $postData
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $res = curl_exec($ch);
        if(curl_errno($ch)){
            throw new ApiException('Error',curl_error($ch),502);
        }else{
            $decode = json_decode($res,true);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($http_status == 404){
                throw new ApiException('Failed to connect to CDN',"Usually means there's a issue in CDN Server",404);
            }elseif ($http_status == 403) {
                throw new ApiException($decode['head'],$decode['message'],502);
            }
            elseif ($http_status == 502) {
                throw new ApiException($decode['head'],$decode['message'],502);
            }elseif ($http_status == 409){
                throw new ApiException($decode['head'],$decode['message'],409);
            }
            
            if($decode['success']){
                unset($decode['success']);
                return $decode;
            }else{
                throw new ApiException($decode['head'],$decode['message'],404);
            }
        }
    }

    public  function delete(){
        if ($this->api_server != NULL && $this->path != NULL){
            $url = $this->api_server.'/'.$this->path;
            
            $c = curl_init();
                // curl_setopt($c, CURLOPT_HEADER, true);
                // curl_setopt($c, CURLOPT_NOBODY, true);  
                curl_setopt($c, CURLOPT_TIMEOUT,10);
                curl_setopt($c,CURLOPT_URL,$url);
                curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($c, CURLOPT_USERAGENT, 'rdms-console/1.0.0-alpha');
                curl_setopt($c,CURLOPT_RETURNTRANSFER,true);
            
                $res = curl_exec($c);
            if(curl_errno($c)){
                // throw new ApiException('Error',curl_error($c));
                throw new ApiException('Failed to connect to CDN',"Usually means there's a issue in CDN Server",10001);
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
                    unset($decode['success']);
                    return $decode;
                }else{
                    throw new ApiException($decode['head'],$decode['message'],404);
                }
                
            }
            
                
                
        }
        return false;
    }
}