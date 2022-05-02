
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
          <a href="{{route('hostes.index')}}"  type="button" class="btn btn-dark p-2"><i class='bx bx-arrow-back' style='color:#ffffff' ></i> </i>Back</a>
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

 