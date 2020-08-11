<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return User::paginate($request->input('per_page', 20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $id)
    {
        return $id;
    }

    public function show(User $user)
    {
        $this->authorize('show', $user);

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return $user;
    }

    public function updateUser(Request $request, $id)
    {
        $userEdit = User::where('id', $id)->first();

        $this->validate($request, [
            'name' => 'required',
            'email' =>'required|email|unique:users,email,'.$id.',id,deleted_at,NULL',
        ]);

        return tap($userEdit)->update($request->only('name', 'email'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);

        return tap($user)->delete();
    }

    public function delete($id)
    {
        $userDelete = User::where('id', $id)->first();

        return tap($userDelete)->delete();
    }
}
