<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
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

        $post = Posts::create($data);

        // Генерация события
        event(new PostCreated($post));

        return response()->json([
            'data' => $post,
        ]);
    }

}
