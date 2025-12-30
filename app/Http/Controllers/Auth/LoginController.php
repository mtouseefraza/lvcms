<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\Models;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {


        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            LoginHistory::create([
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'login_at' => now(),
            ]);


            //Start: menu and permiission set here
            $selectedPermission = UserPermission::query()->select('permission')->where('user_id', Auth::id())->first();
            $selectedPermission = !empty($selectedPermission['permission']) ? $selectedPermission['permission'] : [];

            $models = Models::query()
                ->join('sections', 'models.section_id', '=', 'sections.id')
                ->select('models.id', 'models.name', 'models.section_id', 'models.url', 'sections.name as section_name', 'sections.icon as sections_icon','sections.type as section_type')
                ->get()
                ->toArray();


            $menu = [];
            foreach ($models as $key => $model) {
                $moduleId = $model['id'];
                if(isset($selectedPermission[$moduleId])){
                    $per = $selectedPermission[$moduleId];
                    $mod = explode('.',$model['url']);
                    $menu[$model['section_type']][$model['section_id']][$moduleId] = $model;
                    if(isset($mod[0])){
                        $menu['Permission'][$mod[0]] = $per;
                    }     
                }
            }
            Session::put('menu', $menu);
            //End: menu and permiission set here

            return redirect()->intended('dashboard')->with('success', 'Logged in successfully.');
        }

        // Authentication failed
        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    /**
     * Log out the authenticated user.
     */
    public function logout()
    {
        Auth::logout();
        Session::flush(); 
        return redirect('/')->with('success', 'You have been logged out.');
    }
}

