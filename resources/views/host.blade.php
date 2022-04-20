
@extends('./layout/app')


@section('title',"Console | Device")

@section('headers')
<style>
    .remote_view{
        width: 100%;
        height: 250px;
        background-color:#000;
        position: relative
    } 
 .remote_view .playbtn{
        position: absolute;
        top: 50%;
        left:50%;
        transform:translate(-50%,-50%)

    }
    .remote_view .playbtn i{
        font-size: 90px;

    }
    .hr-primary{
        margin :6px 0 6px 0;
  background-image: -webkit-linear-gradient(left, #0077d3, #0078d3e9, rgba(0,0,0,0));
}

</style>
@endsection

@section('body')
{{-- @dd($result['host_name']) --}}
<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          <h2 class="h2">Add Device</h2>
        </div>
        <div class="p-2 bd-highlight">
          <a href="{{route('hostes.index')}}"  type="button" class="btn btn-dark p-2"><i class='bx bx-arrow-back' style='color:#ffffff' ></i> </i>Back</a>
        </div>
      </div>
    </div>

    <section class="container" id="main_container" >
        <div class="sub_nav">
          <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
            <li class="nav-item" >
              <a
                class="nav-link tab-active"
                aria-controls="tabs-1"
                ><i class='bx bxs-info-circle'></i> Overview</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                aria-controls="tabs-2"
                >Network</a
              >
            </li>
           
          </ul>
        </div>
          <div class="tab-content" id="tab-content">
            <div
              class="tab-pane fade w-100 mb-3 show active"
              id="tabs-1"
            >
            <div class="d-flex justify-content-between flex-md-row flex-column">
                <div class="col-12 col-md-6">
                    <div class="remote_view">
                        
                        <div class="playbtn text-center">
                            <i class='bx bx-play text-white'></i>
                            <div class="h6 text-muted">Not implemented</div>
                        </span>
                        
                    </div>
                </div>
                <hr class="hr-primary" />
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-sm btn-success"><i class='bx bx-play' > </i> Start</button>
                        <button type="button" class="btn btn-sm btn-danger"><i class='bx bx-power-off'> </i> Shutdown</button>
                        <button type="button" class="btn btn-sm  btn-warning text-white"><i class='bx bx-refresh' ></i> Reboot</button>
                    </div>
                </div>
                
                </div>
                <div class="col-12 col-md-6 mx-md-2 mx-2 ">
                    <div class="col-md-12 border border-light shaodw">
                        <div class="panel panel-default panel-condensed device-overview">
                            {{-- <div class="panel-heading py-2">
                                <span class="text-dark h3"><i class='bx bxs-info-circle'></i> Overview</span>
                            </div> --}}
                            <div class="panel-body text-dark">
                                <h4 class="h4"> <i class='bx bxs-microchip'></i> Basic info</h4>
                                <hr class="hr-primary" />
                                <div class="row">
                                    <div class="col-sm-4">System Name</div>
                                    <div class="col-sm-8">{!!$result['host_name']!!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">System primery IP</div>
                                    <div class="col-sm-8">127.0.0.1</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">Domain</div>
                                    <div class="col-sm-8">{!!$result['domain']!!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">workgroup</div>
                                    <div class="col-sm-8">{!!$result['workgroup']!!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">Primary Owner</div>
                                    <div class="col-sm-8">{!!$result['primary_owner']!!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">System Family</div>
                                    <div class="col-sm-8">{!!$result['system_family']!!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">System SKU Number</div>
                                    <div class="col-sm-8">{!!$result['system_sku_number']!!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">System Type</div>
                                    <div class="col-sm-8">{!!$result['system_type']!!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">User Name</div>
                                    <div class="col-sm-8">{!!$result['user_name']!!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">Last Boot at</div>
                                    <div class="col-sm-8">{!!$result['os_last_boot_up_time']!!}</div>
                                </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="panel panel-default panel-condensed device-hardware  mt-4">
                        <div class="panel-heading py-2">
                            <span class="text-dark h4"><i class='bx bxs-chip'></i> Hardware</span>
                        </div>
                        <div class="panel-body text-dark">
                        <div class="sub_nav">
                            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                <li class="sub-nav-item">
                                    <a
                                      class="nav-link tab-active"
                                      aria-controls="sub-tabs-1"
                                      ><i class='bx bxs-microchip'></i> Motherboard</a
                                    >
                                  </li>
                              <li class="sub-nav-item" >
                                <a
                                  class="nav-link"
                                  aria-controls="sub-tabs-2"
                                  ><i class='bx bxs-chip'></i> CPU</a
                                >
                              </li>
                              <li class="sub-nav-item">
                                <a
                                  class="nav-link"
                                  aria-controls="sub-tabs-3"
                                  ><i class='bx bxs-microchip'></i> RAM</a
                                >
                              </li>
                              <li class="sub-nav-item">
                                <a
                                  class="nav-link"
                                  aria-controls="sub-tabs-4"
                                  ><i class='bx bx-desktop' ></i> OS</a
                                >
                              </li>
                              <li class="sub-nav-item">
                                <a
                                  class="nav-link"
                                  aria-controls="sub-tabs-5"
                                  ><i class='bx bxs-hdd' ></i> HDD</a
                                >
                              </li>
                              <li class="sub-nav-item">
                                <a
                                  class="nav-link"
                                  aria-controls="sub-tabs-6"
                                  ><i class='bx bx-chip' ></i> GPU</a
                                >
                              </li>
                            </ul>
                        </div>
                            <div class="tab-content" id="tab-content">
                        <div
                                class="tab-pane fade w-100 mb-3 show active"
                                id="sub-tabs-1"
                              >
                              <div class="panel panel-default panel-condensed device-overview">
                                <div class="panel-body text-dark">
                                    <div class="row">
                                        <div class="col-sm-4">Manufacturer</div>
                                        <div class="col-sm-8">LENOVO</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">Product</div>
                                        <div class="col-sm-8">20YDCTO1WW</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">Serial Number</div>
                                        <div class="col-sm-8">L1HF19S02KY</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">Version</div>
                                        <div class="col-sm-8">Not Defined</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">BIOS</div>
                                        <div class="col-sm-8">['LENOVO - 1070', 'R1OET28W (1.07 )', 'Lenovo - 1070']</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">BIOS Serial Number</div>
                                        <div class="col-sm-8">PF2RDSTX</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">BIOS Build Number</div>
                                        <div class="col-sm-8">None</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">BIOS Release Date</div>
                                        <div class="col-sm-8">20210715000000.000000+000</div>
                                    </div>
                                </div>
                              </div>
                              </div>
                                
                              <div
                                class="tab-pane fade w-100 mb-3 "
                                id="sub-tabs-2"
                              >
                              <div class="panel panel-default panel-condensed device-overview">
                                <div class="panel-body text-dark">
                                    <div>
                                        <h3>CPU0</h3>
                                        <hr class="hr-primary"/>
                                        <div class="row">
                                            <div class="col-sm-4">Manufacturer</div>
                                            <div class="col-sm-8">AuthenticAMD</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">CPU</div>
                                            <div class="col-sm-8">AMD Ryzen 7 5700U with Radeon Graphics</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">CPU Description</div>
                                            <div class="col-sm-8">AMD64 Family 23 Model 104 Stepping 1</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Family</div>
                                            <div class="col-sm-8">107</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Address Width</div>
                                            <div class="col-sm-8">64</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Architecture</div>
                                            <div class="col-sm-8">x64</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Number of Cores</div>
                                            <div class="col-sm-8">8</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Number of Logical Cores</div>
                                            <div class="col-sm-8">16</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Current Clock Speed</div>
                                            <div class="col-sm-8">1801MHz</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Maximum Clock Speed</div>
                                            <div class="col-sm-8">1801MHz</div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-4">L2 Cache</div>
                                            <div class="col-sm-8">4.0MB</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">L3 Cache</div>
                                            <div class="col-sm-8">8.0MB</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Status</div>
                                            <div class="col-sm-8">OK</div>
                                        </div>
                                        
                                    </div>
                                </div>
                              </div>
                              </div>
                                
                                
                              <div class="tab-pane fade w-100 mb-3" id="sub-tabs-3"  >
                                <div class="panel panel-default panel-condensed device-overview">
                                    <div class="panel-body text-dark">
                                        <div>
                                            <h3>Physical Memory 0</h3>
                                            <div class="row">
                                                <div class="col-sm-4">Manufacturer</div>
                                                <div class="col-sm-8">Kingston</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">Part Number</div>
                                                <div class="col-sm-8">KF3200C20S4/8G</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">Serial Number</div>
                                                <div class="col-sm-8">C786CCC1</div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-sm-4">Capacity</div>
                                                <div class="col-sm-8">8192MB</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">Clock Speed</div>
                                                <div class="col-sm-8">3200</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">Data Width</div>
                                                <div class="col-sm-8">64</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">Device Locator</div>
                                                <div class="col-sm-8">DIMM 0</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">Maximum voltage</div>
                                                <div class="col-sm-8">1200 mV</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">Minimum voltage</div>
                                                <div class="col-sm-8">1200 mV</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">Memory Type</div>
                                                <div class="col-sm-8">Unknown</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">Form Factor</div>
                                                <div class="col-sm-8">SODIMM</div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade w-100 mb-3" id="sub-tabs-4"  >
                                <div class="panel panel-default panel-condensed device-overview">
                                <div class="panel-body text-dark">
                                <div class="row">
                                    <div class="col-sm-3">OS Name</div>
                                    <div class="col-sm-9">Microsoft Windows 10 Pro 10.0.19044</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">OS Architecture</div>
                                    <div class="col-sm-9">64-bit</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">OS Serial Number</div>
                                    <div class="col-sm-9">00331-20310-57201-AA136</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">OS Installed at</div>
                                    <div class="col-sm-9">20211125060109.000000+330</div>
                                </div>
                              </div>
                                </div>
                        </div>



                        <div class="tab-pane fade w-100 mb-3" id="sub-tabs-5"  >
                            <div class="panel panel-default panel-condensed device-overview">
                                <div class="panel-body text-dark">
                                    <div>
                                        <h3>HDD 0</h3>
                                        <div class="row">
                                            <div class="col-sm-4">Name</div>
                                            <div class="col-sm-8">SKHynix_HFM512GD3HX015N</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Size</div>
                                            <div class="col-sm-8">512GB</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Avaliabale Size</div>
                                            <div class="col-sm-8">477GB</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Capability</div>
                                            <div class="col-sm-8">Random Access, Supports Writing</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Media Type</div>
                                            <div class="col-sm-8">Fixed hard disk media</div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-sm-4">Model</div>
                                            <div class="col-sm-8">SKHynix_HFM512GD3HX015N</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Manufacturer</div>
                                            <div class="col-sm-8">(Standard disk drives) </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Partitions</div>
                                            <div class="col-sm-8">6</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Interface Type</div>
                                            <div class="col-sm-8">SCSI</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Device ID</div>
                                            <div class="col-sm-8">SCSI\DISK&VEN_NVME&PROD_SKHYNIX_HFM512GD\5&23E6B24D&0&000000</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Serial Number</div>
                                            <div class="col-sm-8">ACE4_2E00_1A35_3BB3_2EE4_AC00_0000_0001</div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                          </div>

                          <div class="tab-pane fade w-100 mb-3" id="sub-tabs-6"  >
                            <div class="panel panel-default panel-condensed device-overview">
                                <div class="panel-body text-dark">
                                    <div>
                                        <h3>VideoController1</h3>
                                        <div class="row">
                                            <div class="col-sm-4">Name</div>
                                            <div class="col-sm-8">AMD Radeon(TM) Graphics</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Video Processor</div>
                                            <div class="col-sm-8">AMD Radeon Graphics Processor (0x164C)</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Manufacturer</div>
                                            <div class="col-sm-8">Advanced Micro Devices, Inc</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Description</div>
                                            <div class="col-sm-8">AMD Radeon(TM) Graphics</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Adapter RAM</div>
                                            <div class="col-sm-8">1073741824</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Resulution</div>
                                            <div class="col-sm-8">1920 x 1080 x 4294967296 colors</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Current Refresh Rate</div>
                                            <div class="col-sm-8">60</div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-sm-4">Maximum Refresh Rate</div>
                                            <div class="col-sm-8">60</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">minimum Refresh Rate</div>
                                            <div class="col-sm-8">60</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Driver Date</div>
                                            <div class="col-sm-8">20211209000000.000000-000</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Driver Version</div>
                                            <div class="col-sm-8">(Standard disk drives) </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Status</div>
                                            <div class="col-sm-8">OK</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Video Architecture</div>
                                            <div class="col-sm-8">5</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Video Memor Type</div>
                                            <div class="col-sm-8">Unknown</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">Video Mode</div>
                                            <div class="col-sm-8">None</div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                          </div>
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade w-100 mb-3" id="tabs-2"  >
            <h1 class="text-dark">Tab 2 content</h1>
          </div>
        </div>
          </div>
      </section>

    @endsection

    @section('scripts')

    <script>

$(document).ready(function () {
  var nav_item = document.querySelectorAll('.nav-item'); 

nav_item.forEach((t) => t.addEventListener('click',function(){
if(nav_item){
nav_item.forEach((t) => {
  if(t.children[0].classList.contains('tab-active')){
    t.children[0].classList.remove('tab-active')

  }
  if(document.getElementById(t.children[0].getAttribute('aria-controls')).classList.contains('active')){
    document.getElementById(t.children[0].getAttribute('aria-controls')).classList.remove('active');
    document.getElementById(t.children[0].getAttribute('aria-controls')).classList.remove('show');
  }
  var tab_nav = this.children[0];
  var target = tab_nav.getAttribute('aria-controls')
  var tab = document.getElementById(target);
  
  tab_nav.classList.add('tab-active')
  tab.classList.add('active')
  tab.classList.add('show')
  
});
}
}));




var sub_nav_item = document.querySelectorAll('.sub-nav-item'); 

sub_nav_item.forEach((t) => t.addEventListener('click',function(){
if(sub_nav_item){
sub_nav_item.forEach((t) => {
  if(t.children[0].classList.contains('tab-active')){
    t.children[0].classList.remove('tab-active')

  }
  if(document.getElementById(t.children[0].getAttribute('aria-controls')).classList.contains('active')){
    document.getElementById(t.children[0].getAttribute('aria-controls')).classList.remove('active');
    document.getElementById(t.children[0].getAttribute('aria-controls')).classList.remove('show');
  }
  var tab_nav = this.children[0];
  var target = tab_nav.getAttribute('aria-controls')
  var tab = document.getElementById(target);
  
  tab_nav.classList.add('tab-active')
  tab.classList.add('active')
  tab.classList.add('show')
  
});
}
}));

// function tab_changer

      });
     
    </script>
    @endsection