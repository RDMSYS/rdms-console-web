
@extends('./layout/app')


@section('title',"Console | Dashboard")
@section('body')
<?php 
$Hour = date('G');
if ( $Hour >= 5 && $Hour <= 11 ) {
    $greeting = "Good Morning";
} else if ( $Hour >= 12 && $Hour <= 18 ) {
  $greeting = "Good Afternoon";
} else if ( $Hour >= 19 || $Hour <= 4 ) {
    $greeting = "Good Evening";
}else {
  $greeting = "Welcome";
}

?>
<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          
        </div>
        <div class="p-2 bd-highlight">
         
        </div>
      </div>
    </div>
    <section class="container" id="dashboard">
      <h1 class="h1"> {!!$greeting!!} {!!session()->get('realname')!!}</h1>
      <h5 class="h5">Welcome to Console</h5>
    </section>

    @endsection

    @section('scripts')

    @endsection