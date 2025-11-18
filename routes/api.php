<?php

use App\Http\Controllers\Api\CpfFormatterController;
use App\Http\Middleware\JsonInputParser;
use Illuminate\Support\Facades\Route;

Route::post( '/cpf-formatter', [
    CpfFormatterController::class,
    'cpfFormat'
])->middleware(JsonInputParser::class);
