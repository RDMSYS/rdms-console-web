<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $path = 'users';
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
        }  catch (ApiException $error) {
            return view('hostnotfound', ['error' => $error->getErrorMessage()]);
        }
        
        return view("users.users", ['results' => $results]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.registration');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'fname' => "required|regex:/^[a-zA-Z\- ]+$/",
                'email' => 'required|regex:/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/',
                'uname' => "required|regex:/^[a-zA-Z0-9]+$/",
                'usertype' => "required",
                'passwd' => "required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/",
            ],
            [
                'fname.required' => 'The First name field is required.',
                'fname.regex' => 'Please enter  valid name',
                'email.required' => 'The email field is required.',
                'email.regex' => 'Please enter a valid email',
                'uname.required' => 'The username field is required.',
                'uname.regex' => 'Please enter a valid username ',
                'usertype.required' => 'The user type is required.',
                'passwd.required' => 'The password field is required.',
                'passwd.regex' => 'Please enter a valid password. It must contain 8 characters ',
            ]
        );

        $all_data = $request->post();
        unset($all_data['_token']);
        try {
            $path = 'user';
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->post($all_data);
            return $results;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), $error->getErrorCode());
        }
        return false;
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
        return "Edit" . $id;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        try {
            $path = 'user/'.$id;
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->delete();
            return back()->with("success",$results['message']);

        }  catch (ApiException $error) {
            return back()->with('fail',"Failed :".$error->getErrorMessage()['message']);
        }
        

    }
}
