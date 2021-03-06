
@extends('./layout/app')


@section('title',"Console | Hostes")
@section('headers')

@endsection
@section('body')
<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          {{-- <h2 class="h2">Devices</h2> --}}
        </div>
        <div class="p-2 bd-highlight">
          @if(Session::get('level') == "Admin")
          <a href="{{route('hostes.create')}}"  type="button" class="btn btn-success p-2"><i class='bx bxs-plus-circle' style='color:#ffffff' > </i> Add new host</a>

            @endif
           </div>
      </div>
    </div>
    <section>
      <div class="row text-center">
        <h1 class="h1">{!!$error['head']!!}</h1>
        <span>{!!$error['message']!!}</span>
      </div>
    </section>

    @endsection

 