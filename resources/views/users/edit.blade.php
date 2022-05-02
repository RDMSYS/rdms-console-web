
@extends('./layout/app')


@section('title',"Console | Hostes")

@section('body')
<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          <h2 class="h2">Create a new user</h2>
        </div>
        <div class="p-2 bd-highlight">
          <a href="{{route('settings.index')}}"  type="button" class="btn btn-dark p-2"><i class='bx bx-arrow-back' style='color:#ffffff' ></i> </i>Back</a>
        </div>
      </div>
    </div>
    <section class="container" id="main_container" >
        <div class="container" >
            <div class="col-md-6">
                <div class="card" >
                    <div class="card-body">
                        <form id="user_reg" action="{{route('user.change')}}" method="POST">
                            {{ method_field('PUT') }}
                {{          csrf_field() }}
                            <div class="form-group mb-4">
                                <label for="passwd">Old Password: </label>
                                <input type="password" class="form-control" aria-datatype="opassword" aria-required="true" id="oldpasswd" Name='oldpasswd' placeholder="Password">
                                <span class="form-text "></span><br/>
                           
                            </div>
                            <div class="form-group mb-4">
                                <label for="passwd">Password: </label>
                                <input type="password" class="form-control" aria-datatype="password" aria-required="true" id="passwd" Name='passwd' placeholder="Password">
                                <span class="form-text "></span><br/>
                                <label class="form-text " role="lowercase-char"><i class='bx bxs-check-circle' ></i> Must contain at least 1 lowercase alphabetical character</label><br/>
                                <label class="form-text " role="uppercase-char"><i class='bx bxs-check-circle' ></i> Must contain at least 1 uppercase alphabetical character</label><br/>
                                <label class="form-text " role="numeric-char"><i class='bx bxs-check-circle' ></i> Must contain at least 1 numeric character</label><br/>
                                <label class="form-text " role="special-char"><i class='bx bxs-check-circle' ></i> Must contain at least one special character</label><br/>
                                <label class="form-text " role="max-char"><i class='bx bxs-check-circle' ></i> Must be eight characters or longer</label><br/>

                            </div>
                            <button type="submit" class="btn btn-danger my-3">Chnage</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    </section>

    @endsection

    @section('scripts')
    <script>
        var form_elemet = document.querySelectorAll(".form-control");
        var formClass = new FormClass(form_elemet)
        formClass.validate()

        $("#user_reg").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    formClass.submit(
        formData,$(this).attr('action'),
        $(this).attr('method'),
        document.getElementById('main_container'),
        $(this))

});
    </script>

@endsection