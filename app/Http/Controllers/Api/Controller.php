<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers;

    public function errorResponse($statusCode, $message=null, $code=0)
    {
        throw new HttpException($statusCode, $message, null, [], $code);
    }
}