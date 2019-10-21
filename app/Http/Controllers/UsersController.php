<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\User;
use App\Note;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::paginate(15);

        return view('users.all')
        ->with('users', $users)
        ->with('name', 'All users');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required',
            'image' => 'sometimes|file|image|max:5000',
            'title' => 'required'
        ]);



        $user = new User;
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->gender = $request->input('gender');
        $user->title = $request->input('title');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->dob = $request->input('dob');
        if ($request->hasFile('image')) {
            $user->image = request()->image->store('images/avatars', 'public');
            $img = Image::make('storage/' . $user->image)->fit(150,150);
            $img->save();
        }
        $user->save();

        $notes = new Note;
        $notes->note = 'Your private notes!';
        $notes->user_id = $user->id;
        $notes->save();

        auth()->login($user);

        return redirect()->to('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required',
            'image' => 'sometimes|file|image|max:5000',
            'title' => 'required'
        ]);

        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->gender = $request->input('gender');
        $user->title = $request->input('title');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->dob = $request->input('dob');
        if ($request->hasFile('image')) {
            $user->image = request()->image->store('images/avatars', 'public');
            $img = Image::make('storage/' . $user->image)->fit(150,150);
            $img->save();
        }

        $user->save();

        return redirect('/users')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        $notes = Note::where('user_id', '=', $user);
        $notes->delete();

        return back()->with('success', 'User deleted successfully!');
    }
}
