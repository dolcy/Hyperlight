<?php

declare(strict_types=1);

use function Siler\array_get;
use Siler\Diactoros;
use Siler\HttpHandlerRunner;
use Siler\Route;

$request = Diactoros\request();
$response = Route\match([
    // /greet/Leo?salute=Hello
    Route\get('/greet/{name}', function ($params) use ($request) {
        $salute = array_get($request->getQueryParams(), 'salute', 'Olá');
        return Diactoros\html("{$salute} <strong>{$params['name']}</strong> <br><br>");
    }, $request),

    Route\get('/', function () {
        return Diactoros\html('<pre>Hello Root</pre>');
    }, $request),

    Route\get('/foo', function () {
        return Diactoros\html('<pre>hello foo!</pre>');
    }, $request),

    Diactoros\html('<pre>404, not found</pre>', 404),
]);

HttpHandlerRunner\sapi_emit($response);
