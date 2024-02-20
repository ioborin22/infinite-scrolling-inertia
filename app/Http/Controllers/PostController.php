<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Inertia\Response
    {
        $posts = Post::latest()->cursorPaginate();

        if($request->wantsJson()) {
            return PostResource::collection($posts);
        }

        return inertia()->render('Posts/Index', [

            'posts' => PostResource::collection($posts)

        ]);
    }
}
