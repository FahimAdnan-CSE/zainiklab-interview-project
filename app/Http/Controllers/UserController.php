<?php namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function index()
    {
       return  redirect()->route('login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6|confirmed',
            'about' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
             'g-recaptcha-response' => 'required',
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            $destination = 'avatars';
            $folderPath = public_path('uploads/' . $destination);
            $file_name = time() . '-' . $avatar->getClientOriginalName();

            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $path = 'uploads/'. $destination .'/' .$file_name;
            $avatar->move(public_path('uploads/' . $destination .'/'), $file_name);

            $customer = Customer::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' =>  Hash::make($request->input('password')),
                'about' => $request->input('about'),
                'avatar' => $path,
            ]);
        } else {
            $customer = Customer::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' =>  Hash::make($request->input('password')),
                'about' => $request->input('about'),
            ]);
        }

        return redirect()->route('customer.profile', ['id' => $customer->id])->with('success', 'Registration successful. Please log in.');
        //return redirect()->route('register')->with('success', 'Registration successful. Please log in.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.users');
        }
        if (Auth::guard('customer')->attempt($credentials)) {
            $status = Auth::guard('customer')->user()->status;
            if($status==1)
            {
                Auth::guard('customer')->logout();
                return view('errors.disable');
            }
            return redirect()->route('customer.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => "Invalid credentials",
        ]);
    }


    public function logout(Request $request)
    {

        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->forget('admin');
        }

        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }


}
