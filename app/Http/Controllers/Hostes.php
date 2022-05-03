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
        try {
            $path = 'devices';
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            return view('hostes', ['results'=>$results]);
        }  catch (ApiException $error) {
            return view('hostnotfound', ['error' => $error->getErrorMessage()]);
        }
        
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
        try {
            $path = 'device/' . $id . '/overview';
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
        } catch (ApiException $error) {
            return view('datanotfound', ['error' => $error->getErrorMessage()]);
        }

        return view('host', ["result" => $results[0]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $path_group = 'devices/group';
            $path_device = 'device/'.$id;
            $apihandler_group = new ApiHandler();
            $apihandler_device = new ApiHandler();
            $apihandler_group->path = $path_group;
            $apihandler_device->path = $path_device;
            $results_group = $apihandler_group->fetch();
            $result_device =$apihandler_device->fetch()[0];
            
        } catch (ApiException $error) {
            return back()->with("fail",'Something went wrong. Cannot edit device informations');
        }
        
        return view('edithost', ['groups' => $results_group,'device_data' => $result_device]);
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
        $validatedData = $request->validate(
            [
                'hostname' => "required|regex:/^[a-zA-Z0-9-_]+(([',. -][a-zA-Z ])?[a-zA-Z0-9-_]*)*$/u",
                'group' => "required|regex:/^[a-zA-Z0-9-_]+(([',. -][a-zA-Z ])?[a-zA-Z0-9-_]*)*$/u",
                'comstring' => "required|regex:/^[a-zA-Z0-9-_]+(([',. -][a-zA-Z ])?[a-zA-Z0-9-_]*)*$/u"
            ],
            [
                'hostname.required' => 'The Hostname is required.',
                'hostname.regex' => 'Please provide valid name',
                'group.required' => 'The Group name is required.',
                'group.regex' => 'Please provide valid Group name ',
                'comstring.required' => 'The Community String is required.',
                'comstring.regex' => 'Please provide valid Community String ',
            ]
        );

        $all_data = $request->post();
        unset($all_data['_token']);
        try {
            $path = 'device/'.$id;
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $path = 'device/'.$id;
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->delete();
            return back()->with("success",$results['message']);

        }  catch (ApiException $error) {
            return back()->with('fail',"Failed :".$error->getErrorMessage()['message']);
        }
        
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
                $total_row = ceil(count($results) / $div_count);
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
                                <img src="assets/logo/win10-default.jpg" />
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
                $div_group = '<hr/>';
                foreach ($results as $result) {

                    $id = $result['id'];
                    $host_name = $result['host'];
                    $host_group = $result['group'];
                    $host_status = (int)($result['is_online']) ? "online" : 'offline';
                    $status_color = (int)($result['is_online']) ? "success" : 'danger';
                    $host_status_discr = (int)($result['is_online']) ? '<i class="bx bxs-square-rounded text-success"></i>' : '<i class="bx bxs-square-rounded text-danger"></i>';
                    $div_group .= <<<EOD
                        
                            <div class="d-flex bd-highlight">
                            <div class="p-2 flex-fill bd-highlight " style="width:10%">
                            <div class="image-holder">
                            <img src="assets/logo/win10-default.jpg" />
                            </div>
                            </div>
                            <div class="p-4 flex-fill bd-highlight " style="width:40%">
                            <a href="/device/$id"> $host_name</a><br />
                            <p class="m-0" style="font-size:12px;">$host_group</p>
                            </div>
                            <div style="width:20%" class="p-4 flex-fill bd-highlight"><span class="badge bg-$status_color">$host_status</span></div>
                            <div style="width:20%" class="p-4 flex-fill bd-highlight">
                            <a class="btn btn-sm btn-danger">Delete</a>
                            <a  class="btn btn-sm btn-secondary">Edit</a></div>
                        </div>

                    <hr/>
                EOD;
                }
                $row  = '<div class="row">' . $div_group . '</div>';
                $html .= $row;
            }

            return $html;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function getBaseboard($id)
    {
        $path = 'device/' . $id . '/baseboard';
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            $basebord_manufacturer = $results['basebord_manufacturer'];
            $basebord_product = $results['basebord_product'];
            $basebord_serial_number = $results['basebord_serial_number'];
            $basebord_version = $results['basebord_version'];
            $bios_name = $results['bios_name'];
            $bios_serial_number = $results['bios_serial_number'];
            $bios_build_number = $results['bios_build_number'];
            $bios_release_date = $results['bios_release_date'];

            $div_group .=  <<<EOD
            <div class="panel panel-default panel-condensed device-overview">
                <div class="panel-body text-dark">
                    <div class="row">
                    <div class="col-sm-3">Manufacturer</div>
                    <div class="col-sm-9">$basebord_manufacturer</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Product</div>
                    <div class="col-sm-8">$basebord_product</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Serial Number</div>
                    <div class="col-sm-8">$basebord_serial_number</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Version</div>
                    <div class="col-sm-8">$basebord_version</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">BIOS</div>
                    <div class="col-sm-8">$bios_name</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">BIOS Serial Number</div>
                    <div class="col-sm-8">$bios_serial_number</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">BIOS Build Number</div>
                    <div class="col-sm-8">$bios_build_number</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">BIOS Release Date</div>
                    <div class="col-sm-8">$bios_release_date</div>
                </div>
                </div>
            </div> 
            
            EOD;
            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }
    public function getCpu($id)
    {
        $path = 'device/' . $id . '/cpu';
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            foreach ($results as $result) {
                $manufacturer = $result['manufacturer'];
                $name = $result['name'];
                $description = $result['description'];
                $family = $result['family'];
                $address_width = $result['address_width'];
                $arch = $result['arch'];
                $number_of_cores = $result['number_of_cores'];
                $number_of_logical_processors = $result['number_of_logical_processors'];
                $current_clock_speed = $result['current_clock_speed'];
                $max_clock_speed = $result['max_clock_speed'];
                $l2_cache = $result['l2_cache'];
                $l3_cache = $result['l3_cache'];
                $status = $result['status'];
                $dev_id = $result['dev_id'];

                $row =  <<<EOD
            <div class="panel panel-default panel-condensed device-overview">
                <div class="panel-body text-dark">
                    <div>
                        <h3>$dev_id</h3>
                        <hr class="hr-primary" />
                        <div class="row">
                            <div class="col-sm-4">Manufacturer</div>
                            <div class="col-sm-8">$manufacturer</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">CPU</div>
                            <div class="col-sm-8">
                            $name
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">CPU Description</div>
                            <div class="col-sm-8">
                            $description
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Family</div>
                            <div class="col-sm-8">$family</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Address Width</div>
                            <div class="col-sm-8">$address_width</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Architecture</div>
                            <div class="col-sm-8">$arch</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Number of Cores</div>
                            <div class="col-sm-8">$number_of_cores</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Number of Logical Cores</div>
                            <div class="col-sm-8">$number_of_logical_processors</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Current Clock Speed</div>
                            <div class="col-sm-8">$current_clock_speed</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Maximum Clock Speed</div>
                            <div class="col-sm-8">$max_clock_speed</div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">L2 Cache</div>
                            <div class="col-sm-8">$l2_cache</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">L3 Cache</div>
                            <div class="col-sm-8">$l3_cache</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Status</div>
                            <div class="col-sm-8">$status</div>
                        </div>
                    </div>
                </div>
            </div>
        EOD;
                $div_group .= $row;
            }

            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }
    public function getRam($id)
    {
        $path = 'device/' . $id . '/primary/memory';
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            foreach ($results as $result) {
                $capacity = $result['capacity'];
                $clock_speed = $result['clock_speed'];
                $data_width = $result['data_width'];
                $device_locator = $result['device_locator'];
                $manufacturer = $result['manufacturer'];
                $max_voltage = $result['max_voltage'];
                $memory_type = $result['memory_type'];
                $min_voltage = $result['min_voltage'];
                $part_number = $result['part_number'];
                $serial_number = $result['serial_number'];
                $tag = $result['tag'];
                $form_factor = $result['form_factor'];

                $row =  <<<EOD
            <div class="panel panel-default panel-condensed device-overview">
                <div class="panel-body text-dark">
                    <div>
                        <h3>$tag</h3>
                        <div class="row">
                            <div class="col-sm-4">Manufacturer</div>
                            <div class="col-sm-8">$manufacturer</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Part Number</div>
                            <div class="col-sm-8">$part_number/8G</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Serial Number</div>
                            <div class="col-sm-8">$serial_number</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Capacity</div>
                            <div class="col-sm-8">$capacity MB</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Clock Speed</div>
                            <div class="col-sm-8">$clock_speed MHz</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Data Width</div>
                            <div class="col-sm-8">$data_width</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Device Locator</div>
                            <div class="col-sm-8">$device_locator</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Maximum voltage</div>
                            <div class="col-sm-8">$max_voltage mV</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Minimum voltage</div>
                            <div class="col-sm-8">$min_voltage mV</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Memory Type</div>
                            <div class="col-sm-8">$memory_type</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Form Factor</div>
                            <div class="col-sm-8">$form_factor</div>
                        </div>
                    </div>
                </div>
            </div>

            EOD;
                $div_group .= $row;
            }

            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function getOs($id)
    {
        $path = 'device/' . $id . '/os';
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $result = $apihandler->fetch();
            $os_name = $result['os_name'];
            $os_status = $result['os_status'];
            $os_version = $result['os_version'];
            $os_serial_number = $result['os_serial_number'];
            $os_arch = $result['os_arch'];
            $os_install_date = $result['os_install_date'];

            $div_group .=  <<<EOD
            <div class="panel panel-default panel-condensed device-overview">
                <div class="panel-body text-dark">
                    <div class="row">
                        <div class="col-sm-3">Name</div>
                        <div class="col-sm-9">$os_name $os_version</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">Architecture</div>
                        <div class="col-sm-9">$os_arch</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">Serial Number</div>
                        <div class="col-sm-9">$os_serial_number</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">Installed at</div>
                        <div class="col-sm-9">$os_install_date</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">Status</div>
                        <div class="col-sm-9">$os_status</div>
                    </div>
                </div>
            </div>

            EOD;


            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function getHdd($id)
    {
        $path = 'device/' . $id . '/secondary/memory';
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            foreach ($results as $result) {
                $name = $result['name'];
                $drive_index = $result['drive_index'];
                $capability = $result['capability'];
                $caption = $result['caption'];
                // $compression_method = $result['compression_method'];
                $media_type = $result['media_type'];
                $model = $result['model'];
                $partitions = $result['partitions'];
                $dev_id = $result['dev_id'];
                $pnp_device_id = $result['pnp_device_id'];
                $serial_number = $result['serial_number'];
                $manufacturer = $result['manufacturer'];
                $size = $result['size'];
                $status = $result['status'];
                $avaliabale_size = $result['avaliabale_size'];
                $interface_type = $result['interface_type'];
                $row =  <<<EOD
                <div class="panel panel-default panel-condensed device-overview">
                    <div class="panel-body text-dark">
                        <div>
                            <h3>HDD $drive_index</h3>
                            <div class="row">
                                <div class="col-sm-4">Name</div>
                                <div class="col-sm-8">$caption</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Size</div>
                                <div class="col-sm-8">$size GB</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Avaliabale Size</div>
                                <div class="col-sm-8">$avaliabale_size GB</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Capability</div>
                                <div class="col-sm-8">$capability</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Media Type</div>
                                <div class="col-sm-8">$media_type</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Model</div>
                                <div class="col-sm-8">$model</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Manufacturer</div>
                                <div class="col-sm-8">$manufacturer</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Partitions</div>
                                <div class="col-sm-8">$partitions</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Interface Type</div>
                                <div class="col-sm-8">$interface_type</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Device ID</div>
                                <div class="col-sm-8">
                                $dev_id
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Serial Number</div>
                                <div class="col-sm-8">
                                $serial_number
                                </div>
                            <div class="row">
                                <div class="col-sm-4">Status</div>
                                <div class="col-sm-8">
                                $status
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                EOD;
                $div_group .= $row;
            }
            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function getGpu($id)
    {
        $path = 'device/' . $id . '/gpu';
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            foreach ($results as $result) {
                $name = $result['name'];
                $video_processor = $result['video_processor'];
                $adapter_compatibility = $result['adapter_compatibility'];
                $description = $result['description'];
                $adapter_ram = $result['adapter_ram'];
                $video_mode_description = $result['video_mode_description'];
                $curr_refresh_rate = $result['curr_refresh_rate'];
                $max_refresh_rate = $result['max_refresh_rate'];
                $min_refresh_rate = $result['min_refresh_rate'];
                $driver_date = $result['driver_date'];
                $driver_version = $result['driver_version'];
                $status = $result['status'];
                $video_architecture = $result['video_architecture'];
                $video_memory_type = $result['video_memory_type'];
                $video_mode = $result['video_mode'];
                $i = 0;
                $row =  <<<EOD
                <div class="panel panel-default panel-condensed device-overview">
                

                    <div class="panel-body text-dark">
                        <div>
                            <h3>GPU $i</h3>
                            <div class="row">
                                <div class="col-sm-4">Name</div>
                                <div class="col-sm-8">$name</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Video Processor</div>
                                <div class="col-sm-8">
                                $video_processor
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Manufacturer</div>
                                <div class="col-sm-8">$adapter_compatibility</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Description</div>
                                <div class="col-sm-8">$description</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Adapter RAM</div>
                                <div class="col-sm-8">$adapter_ram</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Resulution</div>
                                <div class="col-sm-8">$video_mode_description</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Current Refresh Rate</div>
                                <div class="col-sm-8">$curr_refresh_rate fps</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Maximum Refresh Rate</div>
                                <div class="col-sm-8">$max_refresh_rate fps</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">minimum Refresh Rate</div>
                                <div class="col-sm-8">$min_refresh_rate fps</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Driver Date</div>
                                <div class="col-sm-8">$driver_date</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Driver Version</div>
                                <div class="col-sm-8">$driver_version</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Status</div>
                                <div class="col-sm-8"> $status</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Video Architecture</div>
                                <div class="col-sm-8">$video_architecture</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Video Memor Type</div>
                                <div class="col-sm-8">$video_memory_type</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">Video Mode</div>
                                <div class="col-sm-8">$video_mode</div>
                            </div>
                        </div>
                    </div>
                </div>

                EOD;
                $div_group .= $row;
            }
            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function getLdisk($id)
    {
        $path = 'device/' . $id . '/logicaldrives';
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            foreach ($results as $result) {
                $name = $result['name'];
                $drive_type = $result['drive_type'];
                $file_system = $result['file_system'];
                $free_space = $result['free_space'];
                $volume_name = $result['volume_name'];
                $used_space = $result['used_space'];
                $total_size = $result['total_size'];

                $used_per = number_format(((float)explode(" ", $used_space)[0] * 100) / (float)explode(" ", $total_size)[0], 1);
                if ((int)$used_per < 50) {
                    $progress_color = "success";
                } elseif ((int)$used_per > 50 && (int)$used_per < 85) {
                    $progress_color = "warning";
                } else {
                    $progress_color = "danger";
                }

                $volume_serial_number = $result['volume_serial_number'];
                $row =  <<<EOD
                <div class="p-3 my-2 rounded border border-secondary">
                    <div class="row fw-bold">
                        <div class="col-12 col-md-4">$drive_type $name</div>
                        <div class="col-12 col-md-6">$volume_name</div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">Serial Number</div>
                        <div class="col-12 col-md-6">$volume_serial_number</div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">File system</div>
                        <div class="col-12 col-md-6">$file_system</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="progress" style="height: 20px">
                                <div
                                    class="progress-bar bg-$progress_color h6"
                                    role="progressbar"
                                    style="width: $used_per%"
                                    aria-valuenow="25"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                >
                                $used_per%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row fw-bold mt-3">
                        <div class="col-4">Total Space</div>
                        <div class="col-4">Used Space</div>
                        <div class="col-4">Free space</div>
                    </div>
                    <div class="row">
                        <div class="col-4">$total_size</div>
                        <div class="col-4">$used_space</div>
                        <div class="col-4">$free_space</div>
                    </div>
                </div>

                EOD;
                $div_group .= $row;
            }
            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function getIo($id)
    {
        $path = 'device/' . $id . '/io';
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            $device_types = [];
            foreach ($results as $value) {
                $device_types[] = $value['device_type'];
            }
            $device_types = array_unique($device_types);
            foreach ($device_types as $device_type) {
                $device_type_group = '<div class="card my-2"><div class="card-header fw-bold h5">' . $device_type . '</div><div class="card-body">';
                foreach ($results as $result) {
                    $name = $result['name'];
                    $description = $result['description'];
                    $detailed_info = $result['detailed_info'];
                    $status = $result['status'];
                    $device_id = $result['device_id'];
                    $dev_type = $result['device_type'];
                    $infos = '';

                    foreach ($detailed_info as $key => $value) {
                        $infos .= '<div class="row">
                        <div class="col-12">
                            <div class="row ">
                                <div class="col-12 col-md-3 fw-bold">' . $key . ' </div>
                                <div class="col-12 col-md-6"> : ' . $value . '</div>
                            </div>
                        </div>
                        
                    </div>';
                    }
                    if ($device_type == $dev_type) {
                        $row =  <<<EOD
                            <div class="py-2">
                                <h5 class="h5">$name</h5>
                                <p style="font-size:14px">$description</p>
                                <div class="row my-1">
                                    <div class="col-12  col-md-3 fw-bold">Status</div>
                                    <div class="col-12 col-md-6">$status</div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-12 col-md-3 fw-bold">Device ID</div>
                                    <div class="col-12 col-md-6">$device_id</div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        $infos
                                    </div>
                                    
                                </div>
                            </div>
                            <hr>
                    EOD;
                        $device_type_group .= $row;
                    }
                }
                $device_type_group .= '</div></div>';
                $div_group .= $device_type_group;
            }


            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function getSoftwaresDetailed($id, $softid)
    {
        $path = 'device/' . $id . '/softwares/' . $softid;
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $result = $apihandler->fetch();
            $name = $result['name'];
            $version = $result['version'];
            $description = $result['description'];
            $identifying_number = $result['identifying_number'];
            $install_date = $result['install_date'];
            $install_location = $result['install_location'];
            $install_source = $result['install_source'];
            $vendor = $result['vendor'];
            $install_state_descriptions = $result['install_state_descriptions'];
            $assignment_type_descriptions = $result['assignment_type_descriptions'];

            $row =  <<<EOD
                <div class="card my-2 text-dark" id="soft_info">
                <div class="card-header fw-bold h5">
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight">
                    <h5 class="h5">$name $version</h5>
                    <p style="font-size:14px">$description</p>
                    </div>
                    <div class="p-2 bd-highlight">
                    <a type="button" id="soft_close" class="btn btn-dark p-2"><i class='bx bx-window-close' ></i> </i>Close</a>
                    </div>
                </div>
                       
                </div>
            <div class="card-body">
                <div class="py-2">
                
                    <div class="row my-1">
                        <div class="col-3">Identifying Number</div>
                        <div class="col-6">$identifying_number</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3">Install_Date</div>
                        <div class="col-6">$install_date</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3">Install Location</div>
                        <div class="col-6">$install_location</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3">Install Source</div>
                        <div class="col-6">$install_source</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3">vendor</div>
                        <div class="col-6">$vendor</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3">Install State</div>
                        <div class="col-6">$install_state_descriptions</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3">Assignment Type</div>
                        <div class="col-6">$assignment_type_descriptions</div>
                    </div>
                </div>
                <hr>
            </div>
            </div>
            <script>
            var soft_close = document.getElementById('soft_close');
            var tab_4_body = document.getElementById('tabs-5').children[0].children[1].children[0];
            $(soft_close).click(function () { 
                $(tab_4_body).removeClass('d-none');
                $('#soft_info').remove();
            });
            </script>
            EOD;
            $div_group .= $row;

            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }


    public function getSoftwares($id)
    {
        $path = 'device/' . $id . '/softwares';
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            foreach ($results as $result) {
                $name_slited = array_slice(explode(' ', $result['name']), 0, 3);
                $name = implode(" ", $name_slited);;
                $soft_id = $result['id'];
                $row =  <<<EOD
                <div class="card border-0 m-1 p-1 soft-card" style="width: 9rem; cursor:pointer" data-id="$soft_id">
                        <img src="http://127.0.0.1:8000/assets/icons/software_22118.png" style="width:64px; height:64px; margin-right: auto; margin-left: auto;" 
                        class=" rounded-circle card-img-top" >
                        <div class="card-body" style="text-align:center;">
                          
                          <p class="card-text"> $name</p>
                        </div>
                      </div>
                      
                EOD;

                $div_group .= $row;
            }
            $script = "<script>
            var soft_card = document.querySelectorAll('.soft-card');
            soft_card.forEach((t) => t.addEventListener('click',function(e){
            var soft_id = this.getAttribute('data-id')
            var tab_4 = document.getElementById('tabs-5').children[0].children[1];
            var tab_4_body = document.getElementById('tabs-5').children[0].children[1].children[0];
            $.get('/device/" . $id . "/softwares/'+soft_id, function(data, status){
                
                $(tab_4_body).addClass('d-none');
                $(tab_4).append(data)
                
              });
                }));
                
            </script>";
            $div_group .= $script;
            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function getUserAccounts($id)
    {
        $path = 'device/' . $id . '/useraccounts';
        $div_group = '<div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col-1">#</th>
                    <th scope="col-2">Name</th>
                    <th scope="col-2">Account Type</th>
                    <th scope="col-2">Description</th>
                    <th scope="col-1"></th>
                    <th scope="col-2">Domain</th>
                    <th scope="col-3">Full Name</th>
                    <th scope="col-1">Status</th>
                </tr>
            </thead>
            <tbody>';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            $i = 0;
            foreach ($results as $result) {
                $i++;
                $name = $result['name'];
                $account_type = $result['account_type'];
                $description = $result['description'];
                $is_disabled = ($result['is_disabled'] == 1) ? "Disabled" : "Enabled";
                $domain = $result['domain'];
                $full_name = $result['full_name'];
                $local_account = ($result['local_account'] == 1) ? "Local Account" : "";
                $password_required = ($result['password_required'] == 1) ? "Password required" : "No Password";
                $status = $result['status'];
                $row =  <<<EOD
                            <tr>
                                <th scope="row">$i</th>
                                <td>$name<br><span class="badge bg-secondary">$local_account</span></td>
                                <td>$account_type</td>
                                <td>$description<br>
                                <span class="badge bg-dark">$password_required</span></td>
                                <td>$is_disabled</td>
                                <td>$domain</td>
                                <td>$full_name</td>
                                <td>$status</td>
                            </tr>
                EOD;

                $div_group .= $row;
            }
            $div_group .= ' </tbody></table></div>';

            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function getNetAdapter($id)
    {
        $path = 'device/' . $id . '/network/adapters';
        $div_group = '<div class="row mt-3">
        <div class="col-4 fw-bold">Name</div>
        <div class="col-2 fw-bold">Speed</div>
        <div class="col-2 fw-bold">Status</div>
        <div class="col-2 fw-bold"></div>
        <div class="col-2 fw-bold">Mac Adderess</div>
        </div>
        <hr class="m-1"/>
        ';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            $i = 0;
            foreach ($results as $result) {
                $name =  $result['name'];
                $adapter_type = $result['adapter_type'];
                $adapter_index = $result['adapter_index'];
                $interface_index = $result['interface_index'];
                $mac_address = $result['mac_address'];
                $manufacturer = $result['manufacturer'];
                $net_connection_id = $result['net_connection_id'];
                $net_connection_status = ($result['net_connection_status'] == "Connected") ?
                    "<span class='badge bg-success'>" . $result['net_connection_status'] . "</span>" : "<span class='badge bg-danger'>" . $result['net_connection_status'] . "</span>";
                $speed = ((float)$result['speed']);

                if ($speed > 0) {
                    $i = floor(log($speed) / log(1000));
                    $sizes = array('Bps', 'Kbps', 'Mbps', 'Gbps', 'Tbps', 'Pbps', 'Ebps', 'Zbps', 'Ybps');
                    if (round($speed / 1000) < 99999999) {
                        $speedstr = sprintf('%.02F', round($speed / pow(1000, $i), 1)) * 1 . ' ' . @$sizes[$i];
                    } else {
                        $speedstr =  "0 Bps";
                    }
                } else {
                    $speedstr =  "0 Bps";
                }

                $physical_adapter = ($result['physical_adapter'] == 1 ? "Physical Adapter" : "Virtual Adapter");
                $row =  <<<EOD
                        
                        <div class="row my-2 py-1 " >
                            <div class="col-4">
                            <a href="JavaScript:void(0)" class="netadapter" data-int="$interface_index"> $name</a><br />
                            <p class="m-0" style="font-size:12px;">$manufacturer</p>
                                <span class="badge bg-dark">$physical_adapter</span>
                                <span class="badge bg-dark">$adapter_type</span>
                            </div>
                            <div class="col-2"> $speedstr </div>
                            <div class="col-2">$net_connection_status</div>
                            <div class="col-2"><i class="bx bx-wifi"></i> $net_connection_id</div>
                            <div class="col-2">$mac_address</div>
                        </div>
                        <hr/>
                      
                EOD;

                $div_group .= $row;
            }
            $script = "<script>
            var netadapter = document.querySelectorAll('.netadapter');
            netadapter.forEach((t) => t.addEventListener('click',function(e){
            var adapter_id = this.getAttribute('data-int')
            console.log(adapter_id)
            var tab_4 = document.getElementById('tabs-4').children[0].children[1];
            var tab_4_body = document.getElementById('tabs-4').children[0].children[1].children[0];
            $.get('/device/" . $id . "/network/ip/'+adapter_id, function(data, status){
                 $(tab_4_body).addClass('d-none');
                 $(tab_4).append(data)
                });
                }));
                
            </script>";
            $div_group .= ' </tbody></table></div>';
            $div_group .= $script;
            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function getNetAdapterIp($id,  $intid)
    {
        $path = 'device/' . $id . '/network/ip/' . $intid;
        $div_group = '';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $result = $apihandler->fetch();
            $default_gateway = $result['default_gateway'];
            $dhcp_enabled = ($result['dhcp_enabled']) ? "True" : "False";
            $dhcp_lease_expires = $result['dhcp_lease_expires'];
            $dhcp_lease_obtained = $result['dhcp_lease_obtained'];
            $dhcp_server = $result['dhcp_server'];
            $ip_index = $result['ip_index'];
            $ip_v4 = '';
            $ip_v6 = '';
            foreach ($result['ip_v4'] as $ip) {
                $ip_v4 .= '<div>
                    <span> : ' . join(", ", $ip) . '</span>
                </div>';
            }
            foreach ($result['ip_v6'] as $ip) {
                $ip_v6 .= '<div>
                    <span> : ' . join(", ", $ip) . '</span>
                </div>';
            }
            $ip_connection_metric = $result['ip_connection_metric'];
            $ip_enabled = $result['ip_enabled'];

            if ($ip_enabled != 1) {
                $output = '<div class="card-body">
                    <div class="py-2 text-center">
                        There is no ip configured yet
                    </div>
                </div>';
            } else {
                $output = '
                <div class="card-body">
                <div class="py-2">
                
                    <div class="row my-1">
                        <div class="col-3 fw-bold">IPV4</div>
                        <div class="col-6">' . $ip_v4 . '</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3 fw-bold">IPV6</div>
                        <div class="col-6">' . $ip_v6 . '</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3 fw-bold">Default Gateway</div>
                        <div class="col-6"> : ' . $default_gateway . '</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3 fw-bold">DHCP Enabled</div>
                        <div class="col-6"> : ' . $dhcp_enabled . '</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3 fw-bold">DHCP Lease Obtained</div>
                        <div class="col-6"> : ' . $dhcp_lease_obtained . '</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3 fw-bold">DHCP Lease Expires</div>
                        <div class="col-6"> : ' . $dhcp_lease_expires . '</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3 fw-bold">DHCP Server</div>
                        <div class="col-6"> : ' . $dhcp_server . '</div>
                    </div>
                    <div class="row my-1">
                        <div class="col-3 fw-bold">IP Connection Metric</div>
                        <div class="col-6"> : ' . $ip_connection_metric . '</div>
                    </div>
                </div>
            </div>';
            }

            $row =  <<<EOD
                <div class="card my-2 text-dark" id="soft_info">
                <div class="card-header fw-bold h5">
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight"></div>
                    <div class="p-2 bd-highlight">
                    <a type="button" id="net_close" class="btn btn-dark p-2"><i class='bx bx-window-close' ></i> </i>Close</a>
                    </div>
                </div>
                </div>
                $output
            
            </div>
            <script>
            var soft_close = document.getElementById('net_close');
            var tab_4_body = document.getElementById('tabs-4').children[0].children[1].children[0];
            $(soft_close).click(function () { 
                $(tab_4_body).removeClass('d-none');
                $('#soft_info').remove();
            });
            </script>
            EOD;
            $div_group .= $row;
            return $div_group;
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function updateDevDb($id)
    {
        $path = 'device/' . $id . '/update/device/db';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $result = $apihandler->fetch();
            return response()->json($result, 200);
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }


    public function getServices($id)
    {
        $path = 'device/' . $id . '/services';
        
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            $i = 0;
            $div_group = '
            <div class="row mt-3">
            <div class="col-5 fw-bold ">Name</div>
            <div class="col-3 fw-bold ">Service Name</div>
            <div class="col-1 fw-bold text-center">PID</div>
            <div class="col-1 fw-bold text-center">Status</div>
            <div class="col-1 fw-bold text-center">State</div>
            <div class="col-1 fw-bold text-center">Start Mode</div>
            </div>
            <hr class="m-1"/>
            ';
            foreach ($results as $result) {
                $DisplayName = $result["DisplayName"];
                $Description = $result["Description"];
                $ServiceType = $result["ServiceType"];
                $StartMode = $result["StartMode"];
                $Name = $result["Name"];
                $ProcessId = $result["ProcessId"];
                $State = ($result['State'] == "Running") ?
                    "<span class='badge bg-success'>".$result['State']."</span>" : "<span class='badge bg-danger'>".$result['State']."</span>";
                $Started = ($result['Started'] == 1) ?
                    "<span class='badge bg-success'>Started</span>" : "<span class='badge bg-danger'>Stopped</span>";

                $row =  <<<EOD
                        
                        <div class="row my-2 py-1 " >
                            <div class="col-5">
                            <a  class="netadapter"> $DisplayName</a><br />
                            <p class="m-0" style="font-size:12px;">$Description</p>
                            <span class="badge bg-secondary">Service Type : $ServiceType</span>

                            </div>
                            <div class="col-3">  $Name </div>
                            <div class="col-1 text-center">  $ProcessId </div>
                            <div class="col-1 text-center">$Started</div>
                            <div class="col-1 text-center">$State</div>
                            <div class="col-1 text-center"> $StartMode</div>
                        </div>
                        <hr/>
                      
                EOD;

                $div_group .= $row;
            }
            // $script = "<script>
            // var netadapter = document.querySelectorAll('.netadapter');
            // netadapter.forEach((t) => t.addEventListener('click',function(e){
            // var adapter_id = this.getAttribute('data-int')
            // console.log(adapter_id)
            // var tab_4 = document.getElementById('tabs-4').children[0].children[1];
            // var tab_4_body = document.getElementById('tabs-4').children[0].children[1].children[0];
            // $.get('/device/" . $id . "/network/ip/'+adapter_id, function(data, status){
            //      $(tab_4_body).addClass('d-none');
            //      $(tab_4).append(data)
            //     });
            //     }));
                
            // </script>";
            $div_group .= ' </tbody></table></div>';
            // $div_group .= $script;
            return $div_group;

        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }


    public function getDevMgmt($id)
    {
        $path = 'device/' . $id . '/devicemanager';
        
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();

            $class_types = [];
            foreach ($results as $value) {
                $class_types[] = $value['ClassName'];
            }
            $class_types = array_unique($class_types);

            $i = 0;
            $div_group = '';
            foreach($class_types as $class ){
                $i++;
                $class = ($class == "")? "Unknown" :  $class;
                $class_group = '<div class="row"><p class="m-0">
                <a data-bs-toggle="collapse" href="#collapse'.$i.'" role="button" aria-expanded="false" aria-controls="collapse'.$i.'">
                <i class="bx bx-plus"></i> '.$class.'
                </a>
              </p>
              <div class="collapse w-100 " id="collapse'.$i.'"><div class="card card-body p-1 border-0 ">';

                foreach ($results as $result) {
                    
                if ($class == $result["ClassName"]) {
                    $Name = $result["Name"];
                    $row =  <<<EOD
                        <div class="col py-1 mx-5 h6" ><span>$Name </span></div>
                        
                    EOD;
                    $class_group .= $row;
    
                }

            }
            $class_group .= '</div> </div> </div>';
            $div_group .= $class_group;

            }

            // $script = "<script>
            // var netadapter = document.querySelectorAll('.netadapter');
            // netadapter.forEach((t) => t.addEventListener('click',function(e){
            // var adapter_id = this.getAttribute('data-int')
            // console.log(adapter_id)
            // var tab_4 = document.getElementById('tabs-4').children[0].children[1];
            // var tab_4_body = document.getElementById('tabs-4').children[0].children[1].children[0];
            // $.get('/device/" . $id . "/network/ip/'+adapter_id, function(data, status){
            //      $(tab_4_body).addClass('d-none');
            //      $(tab_4).append(data)
            //     });
            //     }));
                
            // </script>";
            $div_group .= ' </tbody></table></div>';
            // $div_group .= $script;
            return $div_group;


        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }



    public function getProcess($id)
    {
        $path = 'device/' . $id . '/processes';
        
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $results = $apihandler->fetch();
            $i = 0;
            $div_group = '
            <small class="fw-bold">Toatal number of running processes : '.count($results).'</small><br/>
            <div class="row mt-3">
            <div class="col-3 fw-bold">Process Name</div>
            <div class="col-1 fw-bold text-center ">Priority</div>
            <div class="col-2 fw-bold text-center">Session ID</div>
            <div class="col-2 fw-bold text-center">Parant PID</div>
            <div class="col-2 fw-bold text-center">PID</div>
            <div class="col-2 fw-bold text-center">Status</div>
            </div>
            <hr class="m-1"/>
            ';
            foreach ($results as $result) {
                $Name = $result["Name"];
                $Description = $result["Description"];
                $Priority = $result["Priority"];
                $SessionId = $result["SessionId"];
                $ProcessId = $result["ProcessId"];
                $ParentProcessId = $result["ParentProcessId"];
                
                $Status = ($result['Status'] == null) ?
                    "<span class='badge bg-dark'>Unknow</span>" : "<span class='badge bg-success'>".$result['Status']."</span>";
                    


                $row =  <<<EOD
                        
                        <div class="row my-2 py-1 " >
                            <div class="col-3">
                            <a  class="netadapter"> $Name</a><br />
                            <p class="m-0" style="font-size:12px;">$Description</p>

                            </div>
                            <div class="col-1 text-center">  $Priority </div>
                            <div class="col-2 text-center">  $SessionId </div>
                            <div class="col-2 text-center">  $ParentProcessId </div>
                            <div class="col-2 text-center">$ProcessId</div>
                            <div class="col-2 text-center">$Status</div>
                        </div>
                        <hr/>
                      
                EOD;

                $div_group .= $row;
            }
            // $script = "<script>
            // var netadapter = document.querySelectorAll('.netadapter');
            // netadapter.forEach((t) => t.addEventListener('click',function(e){
            // var adapter_id = this.getAttribute('data-int')
            // console.log(adapter_id)
            // var tab_4 = document.getElementById('tabs-4').children[0].children[1];
            // var tab_4_body = document.getElementById('tabs-4').children[0].children[1].children[0];
            // $.get('/device/" . $id . "/network/ip/'+adapter_id, function(data, status){
            //      $(tab_4_body).addClass('d-none');
            //      $(tab_4).append(data)
            //     });
            //     }));
                
            // </script>";
            $div_group .= ' </tbody></table></div>';
            // $div_group .= $script;
            return $div_group;

        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }


    public function shutdown($id)
    {
        $path = 'device/' . $id . '/shutdown';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $result = $apihandler->fetch();
            return response()->json($result, 200);
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

    public function reboot($id)
    {
        $path = 'device/' . $id . '/reboot';
        try {
            $apihandler = new ApiHandler();
            $apihandler->path = $path;
            $result = $apihandler->fetch();
            return response()->json($result, 200);
        } catch (ApiException $error) {
            return response()->json($error->getErrorMessage(), 404);
        }
    }

}
