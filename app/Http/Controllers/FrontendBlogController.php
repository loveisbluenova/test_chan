<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogCategory;
use App\BlogComment;
use App\Http\Requests;
use App\Http\Requests\BlogCommentRequest;
use App\Http\Requests\BlogRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Response;
use Sentinel;


class FrontendBlogController extends ChandraController {


    private $tags ;

    public function __construct()
    {
        parent::__construct();
        $this->tags = Blog::allTags();
    }
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //featured blog
        $featured = Blog::where('featured',1)->orderBy('created_at','DESC')->first();
        // Grab all the blogs
        $blogs = Blog::latest()->where('id', '!=', is_object($featured) ? $featured->id : '')->simplePaginate(5);
        $blogs->setPath('blog');
        $tags = $this->tags;
        //return $tags;
        $latest = Blog::latest()->take(5)->get();
        // Show the page
        return view('blog.index', compact('featured','blogs','tags','latest'));
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug='')
    {
        if($slug=='')
        {
            $blog = Blog::first();
        }
        try {
            $blog = Blog::findBySlugOrFail($slug);
            $blog->increment('views');
        }
        catch(ModelNotFoundException $e)
        {
            return Response::view('404', array(), 404);
        }
        $popular = Blog::orderBy('views','DESC')->first();
        // Show the page
        return view('blog.show', compact('blog','popular'));

    }

    /**
     * @param $tag
     * @return \Illuminate\View\View
     */
    public function getBlogTag($tag)
    {
        $blogs = Blog::withAnyTags($tag)->simplePaginate(5);
        $blogs->setPath('blog/'.$tag.'/tag');
        $tags = $this->tags;
        return view('blog.index', compact('blogs','tags'));
    }

    /**
     * @param BlogCommentRequest $request
     * @param Blog $blog
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeComment(BlogCommentRequest $request,Blog $blog)
    {
        $blogcooment = new BlogComment($request->all());
        $blogcooment->blog_id = $blog->id;
        $blogcooment->save();

        return redirect('blog/'.$blog->slug);
    }

}
