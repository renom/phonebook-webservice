<?php

namespace App\Http\Requests;

class Request extends \Illuminate\Http\Request
{
    public function isJson()
    {
        return true;
    }
    
    public function expectsJson()
    {
        return true;
    }
    
    public function wantsJson()
    {
        return true;
    }
}
