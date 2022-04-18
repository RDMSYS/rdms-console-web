
@extends('./layout/app')


@section('title',"Console | Hostes")
@section('body')

<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          <h2 class="h2">Add Device</h2>
        </div>
        <div class="p-2 bd-highlight">
          <a href="{{ URL::previous() }}"  type="button" class="btn btn-dark p-2"><i class='bx bx-arrow-back' style='color:#ffffff' ></i> </i>Back</a>
        </div>
      </div>
    </div>
    <section class="container" id="hostes_holder">
      <div class="d-flex align-items-center light-blue-gradient" style="height: 100vh;">
        <div class="container" >
                <div class="col-md-6">
                    <div class="card " >
                        <div class="card-body">
                            <h3>Manally Create</h3>
                            <form>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hostname or IP: </label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter full name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address:</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username: </label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password: </label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirm Password:</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                </div>
            </div>

    </section>

    @endsection

    @section('scripts')
    <script src="{{asset('js/console_main.js')}}"></script>
    @endsection