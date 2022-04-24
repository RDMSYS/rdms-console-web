
@extends('./layout/app')


@section('title',"Console | Hostes")

@section('body')
<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          <h2 class="h2">Create a new user</h2>
        </div>
        <div class="p-2 bd-highlight">
          <a href="{{route('hostes.index')}}"  type="button" class="btn btn-dark p-2"><i class='bx bx-arrow-back' style='color:#ffffff' ></i> </i>Back</a>
        </div>
      </div>
    </div>
    <section class="container" id="main_container" >
        <div class="container" >
            <div class="col-md-6">
                <div class="card my-5" >
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="fname">Full name : </label>
                                <input type="text" class="form-control" id="fname" name="fname" aria-datatype="name"  aria-required="true" placeholder="Enter full name">
                                <span class="form-text " >*Requierd</span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address:</label>
                                <input type="email" class="form-control" id="email"  name="email" aria-datatype="email" n aria-required="true" placeholder="Enter email">
                                <span class="form-text">*Requierd</span>
                            </div>
                            <div class="form-group">
                                <label for="uname">Username: </label>
                                <input type="text" class="form-control" autocomplete="false" aria-datatype="username" aria-required="true" id="uname" name="uname" placeholder="Enter username">
                                <span class="form-text ">*Requierd</span>
                            </div>
                            <div class="form-group mb-4">
                            <label for="usertype">User type: </label>
                            <select class="form-select" name="usertype" id="usertype" aria-required="true">
                                <option value="2" selected>Gust</option>
                                <option value="1">Admin</option>
                              </select>
                              <span class="form-text ">*Requierd</span>

                            </div>
                            <div class="form-group mb-4">
                                <label for="passwd">Password: </label>
                                <input type="password" class="form-control" aria-datatype="password" aria-required="true" id="passwd" Name='passwd' placeholder="Password">
                                <span class="form-text "></span><br/>
                                <label class="form-text " role="lowercase-char"><i class='bx bxs-check-circle' ></i> Must contain at least 1 lowercase alphabetical character</label>
                                <label class="form-text " role="uppercase-char"><i class='bx bxs-check-circle' ></i> Must contain at least 1 uppercase alphabetical character</label>
                                <label class="form-text " role="numeric-char"><i class='bx bxs-check-circle' ></i> Must contain at least 1 numeric character</label>
                                <label class="form-text " role="special-char"><i class='bx bxs-check-circle' ></i> Must contain at least one special character</label>
                                <label class="form-text " role="max-char"><i class='bx bxs-check-circle' ></i> Must be eight characters or longer</label>

                            </div>
                            <button type="submit" class="btn btn-primary my-3">Submit</button>
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
    </script>

@endsection