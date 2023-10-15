<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;

class PostController extends Controller
{

    public function testApi()
    {
        return 'тест АПИ ';
    }

    public function createPost(Request $request)
    {
        $data = $request->all();

        $person = Posts::create($data);

        return response()->json([
            'data' => $person,
        ]);
    }

}
