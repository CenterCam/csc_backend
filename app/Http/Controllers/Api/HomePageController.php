<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use App\Models\Course;
use App\Models\Country;
use App\Models\Program;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        $programs = Program::all();
        $posts = Post::where('category','scholarship')->orderBy('created_at','desc')->limit(4)->get();
        $flags = Country::where('status','popular')->limit(4)->get();
        $services = Service::all();
        
        return response()->json([
            'countries'=> $countries,
            'programs' => $programs,
            'posts' => $posts,
            'flags' => $flags,
            'services' => $services
        ], 200);

    }

    public function getPostPagination ( Request $request , $search , $sortBy , $sortDir ){
        $page = 15;
        if ($search == "all") {
            $posts = Post::with('user')->orderBy($sortBy, $sortDir)
            ->paginate($page);
        }else{
            $posts = Post::with('user')->where('title','LIKE',"%$search%")
            ->orWhere('shortDescription','LIKE',"%$search%")
            ->orderBy($sortBy, $sortDir)
            ->paginate($page);
        }
        return response()->json($posts,200);
    }

    public function getPostsNotIn($id) {
        $posts = Post::whereNotIn('id', [$id])->limit(19)->get();
        return response()->json($posts, 200);
    }
    public function getOnePost ($id){

        $post = Post::findorFail($id);

        return response()->json($post, 200);
    }
    public function getCoursesPagination ( Request $request , $search , $sortBy , $sortDir){
        $page = 15;
        if ($search == "all") {
            $courses = Course::with('user')->orderBy($sortBy, $sortDir)
            ->paginate($page);
        }else{
            $courses = Course::with('user')->where('title','LIKE',"%$search%")
            ->orWhere('desc','LIKE',"%$search%")
            ->orderBy($sortBy, $sortDir)
            ->paginate($page);
        }
        return response()->json($courses,200);
    }
    
}
