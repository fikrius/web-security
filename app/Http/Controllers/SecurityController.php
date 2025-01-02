<?php 

namespace App\Http\Controllers;

use App\Http\Patterns\SendEmail;
use App\Models\Comment;
use App\Models\EnvironmentVariable;
use App\Models\User;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function menu()
    {
        return view('index');
    }

    public function attacked() {
        return view('security.attacked');
    }

    public function storedXss()
    {
        $comments = Comment::all();
        $count = $comments->count();

        $variable = EnvironmentVariable::where('name', 'sanitize_xss_input')->first();

        return view('security.stored_xss', compact('comments','count','variable'));
    }

    public function reflectedXss()
    {
        $code = session('code', null);

        return view('security.reflected_xss', compact('code'));
    }

    public function searchOrder(Request $request)
    {
        $code = $request->input('code');
        return redirect()->route('reflected.xss')->with('code', $code);
    }

    public function csrfDetail()
    {
        $variable = EnvironmentVariable::where('name', 'enable_csrf_token')->first();
        return view('security.csrf', compact('variable'));
    }

    public function csrfAttacker()
    {
        return view('security.csrf_attacker');
    }

    public function sqlInjectionDetail()
    {
        return redirect()->route('api/documentation');
    }

    public function testStaticCodeAnalisys() {
        $status = User::getUserStatus();

        $user = (new User)->getUsername();

        return true;
    }

    public function sendToOutlet($email, $email_backup, $subject, $message, $from, $from_name)
    {
        SendEmail::send($message, $subject, $from, $from_name, $email);
    }
}
