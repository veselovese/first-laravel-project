<?php

namespace App\Http\Controllers;

use App\Jobs\VeryLongJob;
use App\Models\Comment;
use App\Mail\CommentMail;
use App\Models\Article;
use App\Models\User;
use App\Notifications\NewCommentNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $comments = Cache::remember('comments' . $page, 3000, function () {
            return Comment::latest()->paginate(8);
        });
        return view('comment.index', ['comments' => $comments]);
    }

    public function store(Request $request)
    {
        $keys = DB::table('cache')->whereRaw('key GLOB :key', [':key' => 'comments*[0-9]'])->get();
        foreach ($keys as $key) {
            Cache::forget($key->key);
        }
        $keys = DB::table('cache')->whereRaw('key GLOB :key', [':key' => 'commentUnderArticle' . $request->article_id])->get();
        foreach ($keys as $key) {
            Cache::forget($key->key);
        }
        $request->validate([
            'name' => 'required|min:4',
            'desc' => 'required|max:256'
        ]);

        $comment = new Comment;
        $comment->name = request('name');
        $comment->desc = request('desc');
        // $comment->desc = $request->desc;
        $comment->article_id = request('article_id');
        $comment->user_id = Auth::id();

        if ($comment->save()) {
            VeryLongJob::dispatch($comment);
            return redirect()->back()->with('status', 'Ваш комментарий отправлен на модерацию');
        } else {
            return redirect()->back()->with('status', 'Ошибка добавления комментария');
        }
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        Gate::authorize('update_comment', $comment);
        return view('comment.update', ['comment' => $comment]);
    }

    public function update(Request $request, Comment $comment)
    {
        $keys = DB::table('cache')->whereRaw('key GLOB :key', [':key' => 'comments*[0-9]'])->get();
        foreach ($keys as $key) {
            Cache::forget($key->key);
        }
        $keys = DB::table('cache')->whereRaw('key GLOB :key', [':key' => 'commentUnderArticle' . $comment->article_id])->get();
        foreach ($keys as $key) {
            Cache::forget($key->key);
        }
        Gate::authorize('update_comment', $comment);
        $request->validate([
            'name' => 'required|min:4',
            'desc' => 'required|max:256'
        ]);

        $comment->name = request('name');
        $comment->desc = request('desc');

        if ($comment->save()) {
            return redirect()->route('article.show', ['article' => $comment->article_id])->with('status', 'Ваш комментарий изменен');
        } else {
            return redirect()->back()->with('status', 'Ошибка изменения комментария');
        }
    }

    public function destroy(Comment $comment)
    {
        Cache::flush();
        Gate::authorize('update_comment', $comment);
        if ($comment->delete()) {
            return redirect()->route('article.show', ['article' => $comment->article_id])->with('status', 'Ваш комментарий удален');
        } else {
            return redirect()->route('article.show', ['article' => $comment->article_id])->with('status', 'Ошибка удаления комментария');
        }
    }

    public function accept(Comment $comment)
    {
        $keys = DB::table('cache')->whereRaw('key GLOB :key', [':key' => 'comments*[0-9]'])->get();
        foreach ($keys as $key) {
            Cache::forget($key->key);
        }
        $keys = DB::table('cache')->whereRaw('key GLOB :key', [':key' => 'commentUnderArticle' . $comment->article_id])->get();
        foreach ($keys as $key) {
            Cache::forget($key->key);
        }
        $article = Article::findOrFail($comment->article_id);
        $users = User::where('id', '!=', $comment->user_id)->get();
        $comment->accept = true;
        if ($comment->save()) Notification::send($users, new NewCommentNotify($article, $comment->name));
        return redirect()->route('comment.index');
    }

    public function reject(Comment $comment)
    {
        Cache::flash();
        $comment->accept = false;
        $comment->save();
        return redirect()->route('comment.index');
    }
}
