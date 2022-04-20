<?php

namespace App\Http\Controllers;
use Exception;
// use Illuminate\Http\Request;

class ApiException extends Exception
{
    private $msg;
    private $err_code;
    private $head;
    private $httperror;
    public function __construct($head,$message,$httperror, $code = 0, Exception $previous = null) {
        $this->msg = $message;
        $this->err_code = $code ;
        $this->head = $head ;
        $this->httperror = $httperror ;
        parent::__construct($message, $code, $previous);
    }
    public function getErrorMessage() {
        return ["head"=> $this->head,"message"=>$this->msg,'code'=>$this->err_code ];
    }
    public function getErrorCode(){
        return (int)$this->httperror;
    }
}
