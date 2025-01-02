<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\EnvironmentVariable;
use HTMLPurifier;
use HTMLPurifier_Config;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('comments.index', compact('comments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'comment' => 'required|string',
        ]);
        
        $variable = EnvironmentVariable::where('name', 'sanitize_xss_input')->first();
        if ($variable->value == 1) {
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
    
            $name = $purifier->purify($request->name);
            $email = $purifier->purify($request->email);
            $comment = $purifier->purify($request->comment);
        } else {
            $name = $request->name;
            $email = $request->email;
            $comment = $request->comment;
        }

        $comment = Comment::create([
            'name' => $name,
            'email' => $email,
            'comment' => $comment
        ]);

        $count = Comment::count();

        return response()->json([
            'message' => 'Comment saved successfully',
            'comment' => $comment,
            'count' => $count
        ], 201); // 201 Created status
    }

    public function delete($id)
    {
        $comment = Comment::find($id);

        if ($comment) {
            $comment->delete();

            $count = Comment::count();

            return response()->json([
                'id' => $id,
                'message' => 'Comment deleted successfully',
                'count' => $count
            ], 200); 
        }

        return response()->json([
            'message' => 'Comment not found',
        ], 404);
    }

    public function toggleSanitizeXss(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required|boolean',
        ]);

        $variable = EnvironmentVariable::where('name', $request->name)->first();
        
        if ($variable) {
            $variable->value = $request->value;
            $variable->save();

            return response()->json(['success' => true, 'value' => $variable->value]);
        }

        return response()->json(['success' => false, 'message' => 'Variable not found']);
    }

}

