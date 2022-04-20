<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class Hostes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hostes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $path = 'devices/group';
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
        } catch (ApiException $error) {
            return view('addhost', ['groups' => []]);
        }

        return view('addhost', ['groups' => $results]);
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
                'hostname' => "required|regex:/^[a-zA-Z0-9-_]+(([',. -][a-zA-Z ])?[a-zA-Z0-9-_]*)*$/u",
                'serialno' => 'required|regex:/^([a-zA-Z0-9]){16}$/',
                'group' => "required|regex:/^[a-zA-Z0-9-_]+(([',. -][a-zA-Z ])?[a-zA-Z0-9-_]*)*$/u",
                'comstring' => "required|regex:/^[a-zA-Z0-9-_]+(([',. -][a-zA-Z ])?[a-zA-Z0-9-_]*)*$/u"
            ],
            [
                'hostname.required' => 'The Hostname is required.',
                'hostname.regex' => 'Please provide valid name',
                'serialno.required' => 'The serial number is required.',
                'serialno.regex' => 'Enter a valid serial key. It must be 16 characters',
                'group.required' => 'The Group name is required.',
                'group.regex' => 'Please provide valid Group name ',
                'comstring.required' => 'The Community String is required.',
                'comstring.regex' => 'Please provide valid Community String ',
            ]
        );
            
        $all_data = $request->post();
        unset($all_data['_token']);
        try {
            $path = 'device';
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results=$apihandler->post($all_data);
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
        try {
            $path = 'device/'.$id.'/overview';
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
        } catch (ApiException $error) {
            return view('hostnotfound', ['error'=>$error->getErrorMessage()]);
        }

        return view('host',["result"=>$results[0]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function view($viewtype, $hoststatus)
    {
        if ($hoststatus == "all") {
            $path = 'devices';
        } else {
            return false;
        }

        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();

            $html = '';
            $head = '<div class="container"><h4>Main</h4></div>';
            if ($viewtype == 'grid') {
                $row = '';
                $div_count = 4;
                // $total_row = (round(count($results) / $div_count,0,PHP_ROUND_HALF_UP) == 0) ? 1 : round(count($results) / $div_count,0,PHP_ROUND_HALF_UP);
                $total_row= ceil(count($results) / $div_count);
                $j = 0;
                while ($total_row) {

                    if (count($results) < $div_count) {
                        $div_count = count($results);
                    }
                    $div_group = '';
                    for ($i = 0; $i < $div_count; $i++, $j++) {
                        $id = $results[$j]['id'];
                        $host_name = $results[$j]['host'];
                        $host_group = $results[$j]['group'];
                        $host_status = (int)($results[$j]['is_online']) ? "online" : 'offline';
                        $host_status_discr = (int)($results[$j]['is_online']) ? '<i class="bx bxs-square-rounded text-success"></i>' : '<i class="bx bxs-square-rounded text-danger"></i>';

                        $div_group .=  <<<EOD
                        <div   style="margin: 4px; padding: 0px; width:24.0%">
                        <a href="/device/$id">
                            <div class="card-container">
                              <div class="image-holder">
                                <img src="assets/logo/win10-default.jpg" alt="" />
                              </div>
                              <div class="card-body text-start">
                                <div><h5 class="text-light fw-bold">$host_name</h5>
                                <h5 class="text-light fw-bold">$host_group</h5>
                                </div>
                                <div>
                                <div class="card-body text-end">
                                <span class="sub-h text-light"
                                  >$host_status_discr $host_status </span
                                >
                              </div></div>
                              </div>
                              
                            </div>
                            </a>
                          </div>
                        
                        EOD;

                        unset($results[$j]);
                    }
                    $row  = '<div class="row">' . $div_group . '</div>';
                    $html .= $row;
                    $total_row--;
                }
            } elseif ($viewtype == 'list') {
                $div_group = '';
                $row  = '<div class="row">' . $div_group . '</div>';
                $html .= $row;
            }

            return $html;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }
}
