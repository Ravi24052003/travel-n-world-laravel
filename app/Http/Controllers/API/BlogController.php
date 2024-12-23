<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    public function index()
    {
        $blogs = Blog::all();

        return response()->json(BlogResource::collection($blogs), 200);
    }


    public function userBlogs(){
        $blogs = Blog::where("user_id", Auth::id())->get();

        $blogsResource = BlogResource::collection($blogs);

        return response()->json($blogsResource, 200);

    }


    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        $data["user_id"] = Auth::id();

        $directory = public_path('blog_images');
        // Handle the image upload
        if ($request->hasFile('blog_image_file')) {
            $blog_image_file = $request->file("blog_image_file");
          
            $blog_image_filename = time() . '_' . uniqid(). Str::random(8) . '.' . $blog_image_file->getClientOriginalExtension();

            $blog_image_file->move($directory, $blog_image_filename);

            $data["blog_image"] = 'blog_images/' . $blog_image_filename;
        }

        // Remove 'blog_image_file' field
        Arr::forget($data, 'blog_image_file');

        $blog = Blog::create($data);

        return response()->json(['success' => 'Blog created successfully', 'blog'=> new BlogResource($blog)], 201);
    }

    public function show(Blog $blog)
    {
        return response()->json(new BlogResource($blog), 200);
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {

        $data = $request->validated();

        $directory = public_path('blog_images');
        // Handle the image upload
        if ($request->hasFile('blog_image_file')){
            // Delete the old image if it exists
            if (!empty($blog->blog_image)) {
                $oldBlogImage = public_path($blog->blog_image);

                if(file_exists($oldBlogImage)){
                    unlink($oldBlogImage);
                }
            }

            $blog_image_file = $request->file("blog_image_file");
          
            $blog_image_filename = time() . '_' . uniqid(). Str::random(8) . '.' . $blog_image_file->getClientOriginalExtension();

            $blog_image_file->move($directory, $blog_image_filename);

            $data["blog_image"] = 'blog_images/' . $blog_image_filename;
        }

        // Remove 'blog_image_file' field
        Arr::forget($data, 'blog_image_file');

        $blog->update($data);

        return response()->json(['success' => 'Blog updated successfully', 'blog'=> new BlogResource($blog)], 200);
    }


    public function destroy(Blog $blog)
    {
        if (!empty($blog->blog_image)) {
            $oldBlogImage = public_path($blog->blog_image);

            if(file_exists($oldBlogImage)){
                unlink($oldBlogImage);
            }
        }


        $blog->delete();

        return response()->json(['success' => 'Blog deleted successfully'], 200);
    }
}
