
@extends('./layout/app')


@section('title',"Console | Hostes")
@section('body')

<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          <h2 class="h2">Hostes</h2>
        </div>
        <div class="p-2 bd-highlight">
          <button type="button" class="btn btn-primary">Add new host</button>
        </div>
      </div>
      <div class="d-flex bd-highlight">
        <div class="me-auto p-2 bd-highlight"></div>
        <div class="bd-highlight  rounded ">
          <button type="button" id="view_mode_grid" class="btn btn-sm btn-primary view_mode"><i class='bx bxs-grid' style="font-size:18px" ></i></button>
          <button type="button" class="btn btn-sm btn-light  view_mode" disabled><i class='bx bx-list-ul' style="font-size:18px" ></i></button> 

          </div>
      </div>
    </div>
    <div class="container">
      <h4>Main</h4>
      <div class="row">
        <div class="col" style="margin: 3px; padding: 0px">
          <div class="card-container">
            <div class="image-holder">
              <img src="assets/logo/win10-default.jpg" alt="" />
            </div>
            <div class="card-body text-end">
              <h5 class="text-light fw-bold">PC 1</h5>
              <span class="sub-h text-light"
                ><i class="bx bxs-square-rounded text-success"></i> online</span
              >
            </div>
          </div>
        </div>

        <div class="col" style="margin: 3px; padding: 0px">
          <div class="card-container">
            <div class="image-holder">
              <img src="assets/logo/win10-default.jpg" alt="" />
            </div>
            <div class="card-body text-end">
              <h5 class="text-light fw-bold">PC 1</h5>
              <span class="sub-h text-light"
                ><i class="bx bxs-square-rounded text-success"></i> online</span
              >
            </div>
          </div>
        </div>
        <div class="col" style="margin: 3px; padding: 0px">
          <div class="card-container">
            <div class="image-holder">
              <img src="assets/logo/win10-default.jpg" alt="" />
            </div>
            <div class="card-body text-end">
              <h5 class="text-light fw-bold">PC 1</h5>
              <span class="sub-h text-light"
                ><i class="bx bxs-square-rounded text-success"></i> online</span
              >
            </div>
          </div>
        </div>
        <div class="col" style="margin: 3px; padding: 0px">
          <div class="card-container">
            <div class="image-holder">
              <img src="assets/logo/win10-default.jpg" alt="" />
            </div>
            <div class="card-body text-end">
              <h5 class="text-light fw-bold">PC 1</h5>
              <span class="sub-h text-light"
                ><i class="bx bxs-square-rounded text-danger"></i> offline</span
              >
            </div>
          </div>
        </div>
      </div>
    </div>
    @endsection

    @section('scripts')
    <script>
      $( document ).ready(function() {
      var view_mode_grid = $("#view_mode_grid");
      view_mode_grid.click(() =>{
        $.ajax({
          url: 'url',
          context: document.body
        }).done(function() {
          $( this ).addClass( "done" );
        });
      })
    });
      
    </script>
    @endsection