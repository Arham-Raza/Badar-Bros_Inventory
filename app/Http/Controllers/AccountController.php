<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:accounts-list|accounts-create|accounts-edit|accounts-delete', ['only' => ['index','store']]);
         $this->middleware('permission:accounts-create', ['only' => ['create','store']]);
         $this->middleware('permission:accounts-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:accounts-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        try {
            $accounts = Account::latest()->paginate(10);
            return view('accounts.index', compact('accounts'));
        } catch (\Exception $e) {
            Log::error('AccountController@index error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'An error occurred while loading accounts.');
        }
    }

    public function create()
    {
        try {
            $accountTypes = ['customer' => 'Customer', 'supplier' => 'Supplier', 'cash' => 'Cash', 'bank' => 'Bank'];
            return view('accounts.add', compact('accountTypes'));
        } catch (\Exception $e) {
            Log::error('AccountController@create error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'An error occurred while preparing account creation.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'account_type' => 'required|in:customer,supplier,cash,bank',
                'email' => 'nullable|email',
                'cnic' => 'nullable|string',
                'mobile1' => 'nullable|string',
                'mobile2' => 'nullable|string',
                'whatsapp' => 'nullable|string',
                'address' => 'nullable|string',
            ]);
            Account::create($request->all());
            return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
        } catch (\Exception $e) {
            Log::error('AccountController@store error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'An error occurred while creating the account.');
        }
    }

    public function show(Account $account)
    {
        try {
            return view('accounts.show', compact('account'));
        } catch (\Exception $e) {
            Log::error('AccountController@show error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'An error occurred while loading account details.');
        }
    }

    public function edit(Account $account)
    {
        try {
            $accountTypes = ['customer' => 'Customer', 'supplier' => 'Supplier', 'cash' => 'Cash', 'bank' => 'Bank'];
            return view('accounts.edit', compact('account', 'accountTypes'));
        } catch (\Exception $e) {
            Log::error('AccountController@edit error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'An error occurred while editing the account.');
        }
    }

    public function update(Request $request, Account $account)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'account_type' => 'required|in:customer,supplier,cash,bank',
                'email' => 'nullable|email',
                'cnic' => 'nullable|string',
                'mobile1' => 'nullable|string',
                'mobile2' => 'nullable|string',
                'whatsapp' => 'nullable|string',
                'address' => 'nullable|string',
            ]);
            $account->update($request->all());
            return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
        } catch (\Exception $e) {
            Log::error('AccountController@update error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'An error occurred while updating the account.');
        }
    }

    public function destroy(Account $account)
    {
        try {
            $account->delete();
            return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
        } catch (\Exception $e) {
            Log::error('AccountController@destroy error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'An error occurred while deleting the account.');
        }
    }
}
