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
    public function show()
    {
        $path = 'user/'.session()->get('id');
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            
            $userid= $results['user_id'];
            $username = $results['username'];
            $realname = $results['realname'];
            $email = $results['email'];
            $level = $results['level'];
            $is_enabled = $results['is_enabled'];

            $div_group .=  <<<EOD
            <div class="d-flex align-items-center " >
                  <div class="container text-dark" >
                      <div class="d-flex justify-content-between">
                        <div class="col-md-8">
                            <div class="card " >
                                <div class="card-body h6">
                                      <div class="row my-1 ">
                                          <div class="col-4 fw-bold">Name</div>
                                          <div class="col-8">: $realname</div>
                                      </div>
                                      <div class="row my-1 ">
                                          <div class="col-4 fw-bold">Username</div>
                                          <div class="col-8">: $username</div>
                                      </div>
                                      <div class="row my-1">
                                          <div class="col-4 fw-bold">Email</div>
                                          <div class="col-8">: $email</div>
                                      </div>
                                      <div class="row my-1">
                                          <div class="col-4 fw-bold">Level</div>
                                          <div class="col-8">: $level</div>
                                      </div>
                                      <div class="row my-1">
                                          <div class="col-4 fw-bold">Status</div>
                                          <div class="col-8">: <span class="badge bg-success"> $is_enabled</span></div>
                                      </div>
                                </div> 
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card " >
                          <div class="card-body h5">
                            <a href="/user/password/change" type="button" class="btn btn-danger my-1">Change password</a>
                          </div>
                  </div>
              </div>
                      </div>
                  </div>
                </div>
            
            EOD;
            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('users.edit');
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


    public function change(Request $request)
    {
        $validatedData = $request->validate(
            [
                'oldpasswd' => "required|regex:/^(?=.{8,})/",
                'passwd' => "required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/",
            ],
            [
                
                'passwd.required' => 'The password field is required.',
                'passwd.regex' => 'Please enter a valid password. It must contain 8 characters ',
                'oldpasswd.required' => 'The old password field is required.',
                'oldpasswd.regex' => 'It must contain 8 characters ',
            ]
        );

        $all_data = $request->post();
        unset($all_data['_token']);
        unset($all_data['_method']);
        $all_data['id'] = session()->get('id');
        try {
            $path = 'changer/password';
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->put($all_data);
            return $results;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 409);
        }
        return false;
    }
}
