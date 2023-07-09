<?php namespace App\Http\Controllers;

use App\Admin;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function showUserList()
    {
        $users = Customer::latest()->paginate(1);
        // $users = Customer::where('status', 0)->latest()->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function removeUser($id)
    {
        $user = Customer::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User removed successfully.');
    }

    public function disableUser($id,$status)
    {
        $user = Customer::findOrFail($id);
        $user->status = $status;
        $user->save();
        $notic='';
        if($status==0)
        {
            $notic='User Enable successfully.';
        }
        else
        {
            $notic='User disabled successfully.';
        }

        return redirect()->route('admin.users')->with('success', $notic);
    }
}
