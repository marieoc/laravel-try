<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createPost(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // Strip tags to prevent malicious code
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        // Save post in database
        Post::create($incomingFields);

        // Redirect to homepage
        return redirect('/');
    }

    public function showEditScreen(Post $post) { // $post refers to the URL parameter 'post' defined in router
        // In real project, use middleware
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        return view('edit-post', ['post' => $post]);
    }

    public function editPost(Post $post, Request $request) {
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // Strip tags to prevent malicious code
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        // Update document with the built-in method update();
        $post->update($incomingFields);

        return redirect('/');
    }

    public function deletePost(Post $post) {
        if (auth()->user()->id === $post['user_id']) {
            $post->delete(); // delete() is a built-in method
        }



        return redirect('/');
    }
}
