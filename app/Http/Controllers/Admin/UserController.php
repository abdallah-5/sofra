<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
       $records = User::all();

       return view('admin.users.index',compact('records'));
     }

     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         return view ('admin.users.create');
     }

     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
       $rules = [
         'name' => 'required|unique:users,name',
         'password' => 'required|confirmed',
         'email' => 'required',
         'roles_list' => 'required|array',
       ];

       $messages = [
         'name.required' => 'Name is required',
         'password.required' => 'Password is required',
         'email.required' => 'Email is required',
         'roles_list.required' => 'Roles is required',
       ];

       $this->validate($request, $rules, $messages);
       $request->merge(['password' => bcrypt($request->password)]);

       $record = User::create($request->except('roles_list'));
       $record->roles()->attach($request->roles_list);

       flash()->success("تم إضافة مستخدم بنجاح");

       return redirect(route('users.index'));
     }

     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {
         //
     }

     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {
       $model = User::findOrFail($id);

       return view('admin.users.edit', compact('model'));
     }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, $id)
     {
       $rules = [
         'name' => 'required',
         'password' => 'required|confirmed',
         'email' => 'required',
         'roles_list' => 'required',
       ];

       $messages = [
         'name.required' => 'Name is required',
         'name.required' => 'Password is required',
         'name.required' => 'Email is required',
         'name.required' => 'Roles is required',
       ];
       $this->validate($request, $rules, $messages);

       $record = User::findOrFail($id);
       $record->roles()->sync((array)$request->roles_list);
       $request->merge(['password' => bcrypt($request->password)]);

       $record->update($request->all());
       flash()->success("تم التعديل بنجاح");
       return redirect(route('users.index'));
     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
       $record = User::findOrFail($id);
       $record->delete();
       flash()->success("تم الحذف بنجاح");
       return back();
     }
}
