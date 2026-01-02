<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteContoller extends Controller
{
    public function routeGet($kelas, $asal) {
    return "nama saya wais " . $kelas . " dari "  . $asal;
    }
}
