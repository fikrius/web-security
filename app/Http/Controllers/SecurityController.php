<?php 

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\EnvironmentVariable;
use App\Models\User;

class SecurityController extends Controller
{
    public function menu()
    {
        return view('index');
    }

    public function xssDetail()
    {
        $status = User::getUserStatus();

        $comments = Comment::all();
        $count = $comments->count();

        $variable = EnvironmentVariable::where('name', 'sanitize_xss_input')->first();

        return view('security.xss', compact('comments','count','variable'));
    }

    public function csrfDetail()
    {
        $variable = EnvironmentVariable::where('name', 'enable_csrf_token')->first();
        return view('security.csrf', compact('variable'));
    }

    public function sqlInjectionDetail()
    {
        return redirect()->route('api/documentation');
    }
}
