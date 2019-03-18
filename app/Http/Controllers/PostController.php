<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //文章列表页
    public function index()
    {
//        $posts = Post::orderBy('created_at','desc')->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate(6);
        return view('post/index', compact('posts'));
    }

    //文章详情页
    public function show(Post $post)
    {
        return view('post/show', compact('post'));
    }

    //创建文章
    public function create()
    {
        return view('post/create');
    }

    //创建逻辑
    public function store()
    {
        //验证
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:1',
            'content' => 'required|string|min:5'
        ], [
            'title.required' => '文章标题不能为空',
            'content.required' => '文章内容不能为空',
        ]);
        $user_id = Auth::id();
        $params = array_merge(request(['title','content']),compact('user_id'));
        Post::create($params);
        return redirect('/posts');
    }

    //编辑文章
    public function edit(Post $post)
    {
        return view('post/edit', compact('post'));
    }

    //编辑逻辑
    public function update(Post $post)
    {
        //验证
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:1',
            'content' => 'required|string|min:5'
        ]);

        //是否具有操作权限
        $this->authorize('update',$post);
        $post->user_id = Auth::id();
        $post->title = request('title');
        $post->content = request('content');
        $post->save();
        return redirect("/posts/{$post->id}");

    }

    //删除文章
    public function delete(Post $post)
    {
        $this->authorize('delete',$post);
        //TODO:用户权限验证
        try{
            $post->delete();
        }catch (\Exception $e){}
        return redirect('/posts');
    }

    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/' . $path);
    }
}
