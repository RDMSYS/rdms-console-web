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
                'hostname' => 'required|alpha_num',
                'serialno' => 'required|alpha_num',
                'group' => 'required|alpha_num',
                'comstring' => 'required|alpha_num',
            ],
            [
                'hostname.required' => 'The Hostname is required.',
                'hostname.alpha_num' => 'Special characters not allowed',
                'serialno.required' => 'The serial number is required.',
                'serialno.alpha_num' => 'Special characters not allowed',
                'group.required' => 'The Group name is required.',
                'group.alpha_num' => 'Special characters not allowed',
                'comstring.required' => 'The Community String is required.',
                'comstring.alpha_num' => 'Special characters not allowed',
            ]
        );

        $all_data = $request->post();
        unset($all_data['_token']);
        $ch = curl_init();
        $url = 'http://127.0.0.1:8080/api/device';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json'
        // ));
        curl_setopt($ch, CURLOPT_USERAGENT, 'rdms-console/1.0.0-alpha');
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            $all_data
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $res = curl_exec($ch);
        if(curl_errno($ch)){
            throw new ApiException('Error',curl_error($ch));
        }else{
            $decode = json_decode($res,true);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($http_status == 404){
                throw new ApiException('Failed to connect to CDN',"Usually means there's a issue in CDN Server",404);
            }elseif ($http_status == 502) {
                throw new ApiException($decode['head'],$decode['message'],502);
            }
            
            if($decode['success']){
                unset($decode['success']);
                return $decode;
            }else{
                throw new ApiException($decode['head'],$decode['message'],404);
            }
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
                        $host_name = $results[$j]['host'];
                        $host_group = $results[$j]['group'];
                        $host_status = (int)($results[$j]['is_online']) ? "online" : 'offline';
                        $host_status_discr = (int)($results[$j]['is_online']) ? '<i class="bx bxs-square-rounded text-success"></i>' : '<i class="bx bxs-square-rounded text-danger"></i>';

                        $div_group .=  <<<EOD
                        <div   style="margin: 4px; padding: 0px; width:24.0%">
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
