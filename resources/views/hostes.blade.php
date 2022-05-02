
@extends('./layout/app')


@section('title',"Console | Hostes")
@section('headers')

@endsection
@section('body')

<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          <h2 class="h2">Devices</h2>
        </div>
        <div class="p-2 bd-highlight">
          @if(Session::get('level') == "Admin")
          <a href="{{route('hostes.create')}}"  type="button" class="btn btn-success p-2"><i class='bx bxs-plus-circle' style='color:#ffffff' > </i> Add new host</a>

            @endif
        </div>
      </div>
      <div class="d-flex bd-highlight">
        <div class="me-auto p-2 bd-highlight"></div>
        <div class="bd-highlight mx-2  rounded ">
          <button type="button" class="btn btn-sm btn-primary  " id="view_mode_refresh">
            <i class='bx bx-refresh'  style="font-size:20px"  ></i>
          </div>
        <div class="bd-highlight mx-2 rounded ">
          <button type="button" class="btn btn-sm btn-light  view_mode" id="view_mode_grid" ><i class='bx bxs-grid' style="font-size:20px" ></i></button>
          <button type="button"  class="btn btn-sm  btn-primary  view_mode" id="view_mode_list" ><i class='bx bx-list-ul' style="font-size:20px" ></i></button> 
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col">

          @if(Session::get('fail'))
          <div class="alert alert-danger" role="alert">
            {{Session::get('fail')}}
          </div>
          @endif
          @if(Session::get('success'))
          <div class="alert alert-success" role="alert">
              {{Session::get('success')}}
          </div>
          @endif
      </div>
  </div>
    <section id="hostes_holder">
      {{-- @dd($results) --}}
      <div class="gird_view d-none">
        <div class="d-flex flex-wrap justify-content-start">
          @foreach($results as $result)
          <?php
           $host_status = (int)($result['is_online']) ? "online" : 'offline';
          $status_color = (int)($result['is_online']) ? "success" : 'danger';
          $host_status_discr = (int)($result['is_online']) ? '<i class="bx bxs-square-rounded text-success"></i>' : '<i class="bx bxs-square-rounded text-danger"></i>';
            
          ?>
          <div   style="margin: 4px; padding: 0px; width:24.0%">
            <a href="{{route('hostes.show',$result['id'])}}">
                <div class="card-container">
                  <div class="image-holder">
                    <img src="assets/logo/win10-default.jpg" />
                  </div>
                  <div class="card-body text-start">
                    <div><h5 class="text-light fw-bold">{{$result['host']}}</h5>
                    <h5 class="text-light fw-bold">{{$result['group']}}</h5>
                    </div>
                    <div>
                    <div class="card-body text-end">
                    <span class="sub-h text-light"
                      >{!!$host_status_discr!!} {!!$host_status !!}</span
                    >
                  </div></div>
                  </div>
                  
                </div>
                </a>
              </div>
  
          @endforeach
        </div>
      </div>
      <div class="list_view ">
        <div class="bd-highlight">
          @foreach($results as $result)
          <?php
          $host_status = (int)($result['is_online']) ? "online" : 'offline';
          $status_color = (int)($result['is_online']) ? "success" : 'danger';
          $host_status_discr = (int)($result['is_online']) ? '<i class="bx bxs-square-rounded text-success"></i>' : '<i class="bx bxs-square-rounded text-danger"></i>';
            
          ?>
          <div class="row">
            <div class="p-2 flex-fill bd-highlight " style="width:10%">
              <div class="image-holder">
              <img src="assets/logo/win10-default.jpg" />
              </div>
              </div>
              <div class="p-4 flex-fill bd-highlight " style="width:40%">
              <a href="{{route('hostes.show',$result['id'])}}"> {{$result['host']}}</a><br />
              <p class="m-0" style="font-size:12px;">{{$result['group']}}</p>
              </div>
              <div style="width:20%" class="p-4 flex-fill bd-highlight"><span class="badge bg-{!!$status_color!!}">{!!$host_status!!}</span></div>
              <div style="width:20%" class="p-4 flex-fill bd-highlight d-flex">
                @if(Session::get('level') == "Admin")
                <form method="POST" class="delete_form mx-1" action="{{route('host.distroy',$result['id'])}}">
                  {{ method_field('DELETE') }}
                  {{  csrf_field() }}
                  <button type="submit" class="btn btn-sm btn-danger p-1">{{ trans('Delete') }}</button>
                  </form>
                  <form method="GET" class="edit_form mx-1" action="{{route('host.edit',$result['id'])}}">
                    {{  csrf_field() }}
                    <button type="submit" class="btn btn-sm btn-secondary p-1">{{ trans('Edit') }}</button>
                    </form>
            @endif
                
            </div>
          </div>
  <hr/>

          @endforeach
         
      </div>

      </div>
    </section>

    @endsection

    @section('scripts')
    <script>
    $(document).ready(function () {
    let origin = location.origin;

    var grid = $(".gird_view")
    var list = $(".list_view")

    var view_mode_grid = $("#view_mode_grid");
    var view_mode_list = $("#view_mode_list");
    
    view_mode_grid.click(function () {
        // hostListApi("grid", "all");
        view_mode_grid.attr("disabled", true);
        view_mode_list.attr("disabled", false);
        toggle(grid) 


    });
    view_mode_list.click(function () {
        // hostListApi("list", "all");
        view_mode_list.attr("disabled", true);
        view_mode_grid.attr("disabled", false);
        toggle(list)
         

    });

    
    view_mode_list.attr("disabled", true);
    view_mode_grid.attr("disabled", false);
    // hostListApi("list", "all");

    function toggle (mode){
      list.toggleClass('d-none')
      grid.toggleClass('d-none')
    }

          $('.delete_form').on('submit', function(){
             if(confirm("Are you sure you want to delete it?"))
             {
                 return true;
             }
             else
             {
                 return false;
             }
          });

  
});

  </script>
    

    @endsection