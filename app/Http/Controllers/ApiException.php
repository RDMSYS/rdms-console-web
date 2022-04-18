<?php

namespace App\Http\Controllers;
use Exception;
// use Illuminate\Http\Request;

class ApiException extends Exception
{
    private $msg;
    private $err_code;
    private $head;
    public function __construct($head,$message, $code = 0, Exception $previous = null) {
        $this->msg = $message;
        $this->err_code = $code ;
        $this->head = $head ;
        parent::__construct($message, $code, $previous);
    }
    public function getErrorMessage() {
        return ["head"=> $this->head,"message"=>$this->msg,'code'=>$this->err_code ];
    }
}
