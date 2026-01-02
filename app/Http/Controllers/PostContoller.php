<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostContoller extends Controller
{
    public function post($id) {
        $article = [
            "title" => request("Judul"),
            "content" => request("Deskripsi"),
         ];
    return $article;
    }
}
