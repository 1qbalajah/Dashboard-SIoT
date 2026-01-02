<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QueryContoller extends Controller
{
    public function query()
    {
        $page = request('page');
        $sort = request('sort');
        return "halaman saya adalah " . $page . " dengan sort " . $sort;
    }
}
