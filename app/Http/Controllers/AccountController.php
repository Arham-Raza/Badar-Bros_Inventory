<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

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
        $accounts = Account::latest()->paginate(10);
        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        $accountTypes = ['customer' => 'Customer', 'supplier' => 'Supplier', 'cash' => 'Cash', 'bank' => 'Bank'];
        return view('accounts.add', compact('accountTypes'));
    }

    public function store(Request $request)
    {
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
    }

    public function show(Account $account)
    {
        return view('accounts.show', compact('account'));
    }

    public function edit(Account $account)
    {
        $accountTypes = ['customer' => 'Customer', 'supplier' => 'Supplier', 'cash' => 'Cash', 'bank' => 'Bank'];
        return view('accounts.edit', compact('account', 'accountTypes'));
    }

    public function update(Request $request, Account $account)
    {
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
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
