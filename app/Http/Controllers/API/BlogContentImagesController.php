<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogContentImagesRequest;
use App\Http\Requests\UpdateBlogContentImagesRequest;
use App\Http\Resources\BlogContentImagesResource;
use App\Models\Blog;
use App\Models\BlogContentImages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class BlogContentImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = BlogContentImages::all();
        $blogs = Blog::all();

        foreach($images as $image){
            $blogContentImagesInUseArr = [];
        $particularRowImages = $image["images"];

        foreach($particularRowImages as $img){
            $imgUsedInBlogs = [];
            foreach($blogs as $blog){
                if (str_contains($blog["blog_content"], $img)) {
                    $imgUsedInBlogs[] = $blog["blog_title"];
                }
            }
            $blogContentImagesInUseArr[] = ["image_src"=> $img, "used_in" => $imgUsedInBlogs]; 
        }

        if(count($blogContentImagesInUseArr) > 0){
        $image["blog_content_images_used_in"] = $blogContentImagesInUseArr;
        }

        }

        return response()->json($images, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogContentImagesRequest $request)
    {
        $data = $request->validated();
        $directory = public_path('blog_content_images');

        if ($request->hasFile("images_files")){
            $image_files = $request->file("images_files");
            $images_paths = [];

            foreach ($image_files as $image_file) {
                $image_filename = time() . '_' . uniqid() . Str::random(8) . '.' . $image_file->getClientOriginalExtension();
                $image_file->move($directory, $image_filename);
                $images_paths[] = 'blog_content_images/' . $image_filename; 
            }

            $data["images"] = $images_paths;
        }

        Arr::forget($data, [
            "images_files"
        ]);

        $blogContentImage = BlogContentImages::create($data);

        return response()->json([
            'success' => 'Blog Content Images created successfully',
            'blog_content_image' => new BlogContentImagesResource($blogContentImage),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogContentImages $blogContentImage)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogContentImagesRequest $request, BlogContentImages $blogContentImage)
    {
        $data = $request->validated();
        $directory = public_path('blog_content_images');

         // Handle destination_images update
         if ($request->hasFile("images_files")) {
            // Delete old images if they exist
            if (!empty($blogContentImage->images)){
                $oldImages = $blogContentImage->images;
                foreach ($oldImages as $oldImagePath){
                    $fullPath = public_path($oldImagePath);
                    if (file_exists($fullPath)){
                        unlink($fullPath);
                    }
                }
            }

            $image_files = $request->file("images_files");
            $images_paths = [];

            foreach ($image_files as $image_file) {
                $image_filename = time() . '_' . uniqid() . Str::random(8) . '.' . $image_file->getClientOriginalExtension();
                $image_file->move($directory, $image_filename);
                $images_paths[] = 'blog_content_images/' . $image_filename;
            }

            $data["images"] = $images_paths;
        }

        Arr::forget($data, [
            "images_files"
        ]);

        $blogContentImage->update($data);

        return response()->json([
            'success' => 'Blog Content Images updated successfully',
            'blog_content_image' => new BlogContentImagesResource($blogContentImage),
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogContentImages $blogContentImage)
    {

        // Delete images if they exist
        if (!empty($blogContentImage->images)) {
            $images = $blogContentImage->images;
            foreach ($images as $imagePath) {
                $fullPath = public_path($imagePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }

        $blogContentImage->delete();

        return response()->json(['success' => 'blog content images deleted successfully'], 200);
    }
}
