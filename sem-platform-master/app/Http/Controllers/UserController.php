<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(20);

        if(request()->has('q')) {
            $users = User::whereLike(['name', 'email'], request()->get('q'))->paginate(20);
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param \App\Models\User                     $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->input('name'),
            'revenue_share' => $request->input('revenue_share'),
            'email' => $request->input('email'),
            'payment_method' => $request->input('payment_method'),
            'paypal_email' => $request->input('paypal_email'),
            'bank_account_holder' => $request->input('bank_account_holder'),
            'bank_account_number' => $request->input('bank_account_number'),
            'bank_sort_code' => $request->input('bank_sort_code'),
            'team_id' => $request->input('team'),
            'is_admin' => $request->has('is_admin'),
        ]);

        flash('User has been updated.');

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        flash('User has been deleted.');

        return redirect()->back();
    }

    public function impersonate(User $user)
    {
        auth('web')->loginUsingId($user->id);
        return redirect()->back();
    }
}
