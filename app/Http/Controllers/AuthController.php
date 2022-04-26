<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
date_default_timezone_set('Asia/Kolkata');
class AuthController extends Controller
{
    public function loginView()
    {
       return view('auth.login');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate(
            [
                'username' => "required",
                'passwd' => "required|min:8",
            ],
            [
                'username.required' => 'username field is required',
                'passwd.required' => 'Password field is required',
                'passwd.min' => 'Password must be minimum 8 letters',
            ]
        );

        $all_data = $request->post();
        unset($all_data['_token']);
        try {
            $path = 'login';
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $result = $apihandler->post($all_data);
            if($this->jwtValidate($result['data']) == TRUE){
                $payload = get_object_vars(json_decode(base64_decode(explode('.', $result['data'])[1])));
                $request->session()->put("id",$payload['user_id']);
                $request->session()->put("realname",$payload['realname']);
                $request->session()->put("level",$payload['level']);
                $request->session()->put("email",$payload['email']);
                
                return redirect('/dashboard');
            }else{
                return back()->with('fail',"please duoble check credential");
            }
            
        } catch (ApiException $error) {
            return back()->with('fail',$error->getErrorMessage()['message']);
        }
        return false;
    }
    private function base64url_encode($str) {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

    private function jwtValidate($jwt) {
        $secret = env("JWT_SECRET");
        
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];

        $expiration = json_decode($payload)->exp;
        $is_token_expired = ($expiration - time()) < 0;
    
        $base64_url_header = $this->base64url_encode($header);
        $base64_url_payload = $this->base64url_encode($payload);
        $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
        $base64_url_signature = $this->base64url_encode($signature);
        // echo $expiration;
        // echo "<br>";
        // echo time();

        $is_signature_valid = ($base64_url_signature === $signature_provided);
        if ($is_token_expired || !$is_signature_valid) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

   
}
