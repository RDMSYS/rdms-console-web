
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
          <a href="{{route('hostes.create')}}"  type="button" class="btn btn-success p-2"><i class='bx bxs-plus-circle' style='color:#ffffff' > </i> Add new host</a>
        </div>
      </div>
      <div class="d-flex bd-highlight">
        <div class="me-auto p-2 bd-highlight"></div>
        <div class="bd-highlight mx-2  rounded ">
          <button type="button" class="btn btn-sm btn-primary  " id="view_mode_refresh">
            <i class='bx bx-refresh'  style="font-size:20px"  ></i>
          </div>
        <div class="bd-highlight mx-2 rounded ">
          <button type="button" class="btn btn-sm btn-primary  view_mode" id="view_mode_grid"><i class='bx bxs-grid' style="font-size:20px" ></i></button>
          <button type="button" class="btn btn-sm btn-light  view_mode" id="view_mode_list"  ><i class='bx bx-list-ul' style="font-size:20px" ></i></button> 
          </div>
      </div>
    </div>
    <section id="hostes_holder">

    </section>

    @endsection

    @section('scripts')
    <script>
    $(document).ready(function () {
    let origin = location.origin;

    var view_mode_grid = $("#view_mode_grid");
    var view_mode_list = $("#view_mode_list");
    
    view_mode_grid.click(function () {
        hostListApi("grid", "all");
        view_mode_grid.attr("disabled", true);
        view_mode_list.attr("disabled", false);
    });
    view_mode_list.click(function () {
        hostListApi("list", "all");
        view_mode_list.attr("disabled", true);
        view_mode_grid.attr("disabled", false);
    });

    var hostListApi = (viewMode, datatype) => {
        var hostes_holder = $("#hostes_holder");
        var preloader = new PreLoader(hostes_holder[0]);
        $.ajax({
            url: `${origin}/devices/${viewMode}/${datatype}`,
            type: "GET",
            beforeSend: function () {
                preloader.start()
            },
            success: function (result) {
                hostes_holder.html(result);
            },
            error: function (e) {
                // var alertBox = new AlertBox({head:e.responseJSON.head,message:e.responseJSON.message,code:e.responseJSON.code,age:3000});
                hostes_holder.html(`
                <div><h1 class="h4 text-center">${e.responseJSON.head}</h1><div>
                <p class="text-center">${e.responseJSON.message}</p>
                `);
                // alertBox.error()
                // preloader.stop()
            },
            cache: false,
            contentType: false,
            processData: false,
        });
        return;
    };

    hostListApi("grid", "all");
});

  </script>
    

    @endsection