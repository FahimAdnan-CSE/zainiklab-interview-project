<?php namespace App\Http\Controllers;

use App\Admin;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customerId = Auth::guard('customer')->user()->id;
        $customer = Customer::findOrFail($customerId);
        return view('customer.profile', compact('customer'));
    }


    public function profile($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.profile', compact('customer'));
    }



}
