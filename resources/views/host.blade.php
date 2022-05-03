
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
{{-- @dd($result) --}}
<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight ">
          <h5 class="h5 fw-bold">{!!$result['nickname']!!} ({!!$result['host_name']!!}) </h5>
          @if($result['is_online'] == 1)
            <span class="badge bg-success">Online</span>
          @else
          <span class="badge bg-danger">offline</span>
          @endif
          <p style="font-size:13px;font-style: italic; ">Last updated : {!!$result['updated_at']!!}</p>
        </div>
        <div class="p-2 bd-highlight">
         <div class="mx-2 d-inline"> <button type="button" class="btn btn-success" disabled><i class='bx bx-play' > </i> Start</button>
            <form class="shutdown d-inline" action="{{route('host.shutdown',$result['host_id'])}}" method="get">
              @csrf
            <button type="submit" class="btn  btn-danger"><i class='bx bx-power-off'> </i> Shutdown</button>
            </form>
            <form class="reboot d-inline" action="{{route('host.reboot',$result['host_id'])}}" method="get">
              @csrf
              <button type="submit" class="btn  btn-warning text-white"><i class='bx bx-refresh' ></i> Reboot</button>
            </form>
        </div>
          <a href="{{route('hostes.device.update',$result['host_id'])}}" id="update_db"  type="button" class="btn btn-primary p-2"><i class='bx bx-refresh' ></i> Update</a>
          <a href="{{route('hostes.index')}}"  type="button" class="btn btn-dark p-2"><i class='bx bx-arrow-back' style='color:#ffffff' ></i> Back</a>
        </div>
      </div>
    </div>
    
    <section class="container " id="main_container" >
       
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
                href="{{route('host.io.show',$result['host_id'])}}"
                  class="nav-link"
                  aria-controls="tabs-3"
                  >IO</a
                >
              </li>
              <li class="nav-item">
                <a href="{{route('host.adapters.show',$result['host_id'])}}"
                  class="nav-link"
                  aria-controls="tabs-4"
                  >Network Adapters</a
                >
              </li>
              <li class="nav-item">
                <a
                href="{{route('host.softwares.show',$result['host_id'])}}"
                  class="nav-link"
                  aria-controls="tabs-5"
                  >Softwares</a
                >
              </li>
              <li class="nav-item">
                <a href="{{route('host.useraccounts.show',$result['host_id'])}}"
                  class="nav-link"
                  aria-controls="tabs-6"
                  >User accounts</a
                >
              </li>
              <li class="nav-item">
                <a href="{{route('host.services.show',$result['host_id'])}}"
                  class="nav-link"
                  aria-controls="tabs-7"
                  >Services</a
                >
              </li>
              <li class="nav-item">
                <a href="{{route('host.devicemanager.show',$result['host_id'])}}"
                  class="nav-link"
                  aria-controls="tabs-8"
                  >Device Manager</a
                >
              </li>
              <li class="nav-item">
                <a href="{{route('host.process.show',$result['host_id'])}}"
                  class="nav-link"
                  aria-controls="tabs-7"
                  >Processes</a
                >
              </li>
           
          </ul>
        </div>
          <div class="tab-content" id="tab-content">
            <div
              class="tab-pane fade w-100 mb-3  show active"
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
            <div class="d-flex justify-content-between flex-md-row flex-column">
                <div class="col-6">
                    <div class="panel panel-default panel-condensed device-hardware ">
                        <div class="panel-heading py-2">
                            <span class="text-dark h4"><i class='bx bxs-chip'></i> Hardware</span>
                        </div>
                        <div class="panel-body text-dark">
                        <div class="sub_nav">
                            <ul class="nav nav-tabs mb-3" id="sub-ex1" role="tablist">
                                <li class="sub-nav-item" >
                                    <a  href="{{route('host.baseboard.show',$result['host_id'])}}"
                                      class="nav-link tab-active"
                                      aria-controls="sub-tabs-1"
                                      > Motherboard</a
                                    >
                                  </li>
                              <li class="sub-nav-item" >
                                <a
                                href="{{route('host.cpu.show',$result['host_id'])}}"
                                  class="nav-link"
                                  aria-controls="sub-tabs-2"
                                  > CPU</a
                                >
                              </li>
                              <li class="sub-nav-item">
                                <a
                                href="{{route('host.ram.primary.memory',$result['host_id'])}}"
                                  class="nav-link"
                                  aria-controls="sub-tabs-3"
                                  > RAM</a
                                >
                              </li>
                              <li class="sub-nav-item">
                                <a
                                href="{{route('host.os.show',$result['host_id'])}}"
                                  class="nav-link"
                                  aria-controls="sub-tabs-4"
                                  > OS</a
                                >
                              </li>
                              <li class="sub-nav-item">
                                <a
                                href="{{route('host.hdd.show',$result['host_id'])}}"
                                  class="nav-link"
                                  aria-controls="sub-tabs-5"
                                  > HDD</a
                                >
                              </li>
                              <li class="sub-nav-item">
                                <a
                                href="{{route('host.gpu.show',$result['host_id'])}}"
                                  class="nav-link"
                                  aria-controls="sub-tabs-6"
                                  > GPU</a
                                >
                              </li>
                            </ul>
                        </div>
                            <div class="tab-content" id="tab-content">
                        <div
                                class="tab-pane fade w-100 mb-3 show active" style="min-height:200px; position:relative"
                                id="sub-tabs-1"
                              >
                              
                              </div>
                            </div>
                        </div>
                </div>
                </div>
                <div class="col-5 ml-1">
                    <div class="panel panel-default panel-condensed my-5 " data-url="{{route('host.ldisk.show',$result['host_id'])}}" id="logical_drive">
                        <div class="panel-heading py-2">
                            <span class="text-dark h4"><i class='bx bxs-hdd'></i> Logical Drives</span>
                        </div>
                        <div class="panel-body text-dark mt-2 position-relative">

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
          <div class="tab-pane fade w-100 mb-3 " id="tabs-3"  >
            <div class="panel panel-default panel-condensed device-overview">
                <div class="panel-heading py-2">
                    <span class="text-dark h3"> IO Devices</span>
                </div>
                <div class="panel-body text-dark">
                    <div >
                    </div>
            </div>
          </div>
          </div>
          <div class="tab-pane fade w-100 mb-3" id="tabs-4"  >
            <div class="panel panel-default panel-condensed device-overview">
                <div class="panel-heading py-2">
                    <span class="text-dark h3"> Network Adapters</span>
                </div>
                <div class="panel-body text-dark  ">
                    <div>
                    </div>
            </div>
          </div>
          </div>
          <div class="tab-pane fade w-100 mb-3" id="tabs-5"  >
            <div class="panel panel-default panel-condensed device-overview">
                <div class="panel-heading py-2">
                    <span class="text-dark h3"> Softwares</span>
                </div>
                <div class="panel-body text-dark  ">
                    <div class="d-flex flex-wrap"></div>
            </div>
          </div>
          </div>
          <div class="tab-pane fade w-100 mb-3" id="tabs-6"  >
            <div class="panel panel-default panel-condensed device-overview">
                <div class="panel-heading py-2">
                    <span class="text-dark h3"> User accounts</span>
                </div>
                <div class="panel-body text-dark  ">
                    <div>
                        
                    </div>
            </div>
          </div>
          </div>
          <div class="tab-pane fade w-100 mb-3" id="tabs-7"  >
            <div class="panel panel-default panel-condensed device-overview">
                <div class="panel-heading py-2">
                    <span class="text-dark h3"> Services</span>
                </div>
                <div class="panel-body text-dark  ">
                    <div>
                        
                    </div>
            </div>
          </div>
          </div>

          <div class="tab-pane fade w-100 mb-3" id="tabs-8"  >
            <div class="panel panel-default panel-condensed device-overview">
                <div class="panel-heading py-2">
                    <span class="text-dark h3"> Device Manager</span>
                </div>
                <div class="panel-body text-dark  ">
                    <div>
                        
                    </div>
            </div>
          </div>
          </div>
        </div>
          </div>
      </section>
      
    @endsection

    @section('scripts')

    <script>

$(document).ready(function () {
    var ajax = new Ajax();
  var nav_item = document.querySelectorAll('.nav-item'); 

nav_item.forEach((t) => t.addEventListener('click',function(e){
    e.preventDefault();
if(nav_item){
nav_item.forEach((t) => {
  if(t.children[0].classList.contains('tab-active')){
    t.children[0].classList.remove('tab-active')

  }
  if(document.getElementById(t.children[0].getAttribute('aria-controls')).classList.contains('active')){
    document.getElementById(t.children[0].getAttribute('aria-controls')).classList.remove('active');
    document.getElementById(t.children[0].getAttribute('aria-controls')).classList.remove('show');
  }
});
  var tab_nav = this.children[0];
  var target = tab_nav.getAttribute('aria-controls')
  var tab = document.getElementById(target);
  

if (target != "tabs-1") {
    url=tab_nav.href;
    ajax.fetch(url,tab.children[0].children[1].children[0])
}


  tab_nav.classList.add('tab-active')
  tab.classList.add('active')
  tab.classList.add('show')
  

}
}));




var sub_nav_item = document.querySelectorAll('.sub-nav-item'); 

sub_nav_item.forEach((t) => t.addEventListener('click',function(e){
    e.preventDefault()
if(sub_nav_item){
sub_nav_item.forEach((t) => {
  if(t.children[0].classList.contains('tab-active')){
    t.children[0].classList.remove('tab-active')

  }
});

//   if(document.getElementById(t.children[0].getAttribute('aria-controls')).classList.contains('active')){
//     document.getElementById(t.children[0].getAttribute('aria-controls')).classList.remove('active');
//     document.getElementById(t.children[0].getAttribute('aria-controls')).classList.remove('show');
//   }
  var tab_nav = this.children[0];
  var target = tab_nav.getAttribute('aria-controls')
//   var tab = document.getElementById(target);
  var tab = document.getElementById("sub-tabs-1");
  
  tab_nav.classList.add('tab-active')

//   tab.classList.add('active')
//   tab.classList.add('show')


url=tab_nav.href;

ajax.fetch(url,tab)

  

}
}));


$('#update_db').click(function (e) { 
  e.preventDefault();
  var href = this.href;
  ajax.action(href)
});

$(".shutdown").submit(function (e){
  e.preventDefault();
  if(confirm("Are you sure you want to shutdown?"))
  {
    var href = this.action
    ajax.action(href)
  }else{
    return false;
  }

})
$(".reboot").submit(function (e){
  e.preventDefault();
  if(confirm("Are you sure you want to reboot?"))
  {
    var href = this.action
    ajax.action(href)
  }else{
    return false;
  }

})

ajax.fetch(
    document.getElementById('sub-ex1').children[0].children[0].href,
    document.getElementById("sub-tabs-1")
    )
    const ldisk_container = document.getElementById('logical_drive')
ajax.fetch(
    ldisk_container.getAttribute('data-url'),
    ldisk_container.children[1]
)



      });
     
    </script>
    @endsection