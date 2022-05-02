
@extends('./layout/app')


@section('title',"Console | Settings")

@section('body')
<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          <h2 class="h2">Settings</h2>
        </div>
        <div class="p-2 bd-highlight">
        </div>
      </div>
    </div>




    <section class="container" id="main_container" >
      <div class="sub_nav">
        <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
          <li class="nav-item" >
            <a href ="{{route('user.show')}}"
              class="nav-link tab-active"
              aria-controls="tabs-1"
              >Profile</a
            >
          </li>
          {{-- <li class="nav-item">
            <a
              class="nav-link"
              aria-controls="tabs-2"
              >Configrations</a
            >
          </li> --}}
         
        </ul>
     
        <div class="tab-content " id="tab-content">
            <div class="tab-pane fade w-100 mb-3 active show text-dark" id="tabs-1"  >
                
              </div>
              
          {{-- <div class="tab-pane fade w-100 mb-3" id="tabs-2"  >
            Tab 2 content
          </div> --}}

        </div>
      </div>
    </section>

    @endsection

    @section('scripts')
    <script src="{{asset('js/console_main.js')}}"></script>

    <script>

$(document).ready(function () {
  var nav_item = document.querySelectorAll('.nav-item'); 
  var ajax = new Ajax();
var nav_item = document.querySelectorAll('.nav-item'); 
nav_item.forEach((t) => t.addEventListener('click',function(e){
    e.preventDefault()
if(nav_item){
    nav_item.forEach((t) => {
  if(t.children[0].classList.contains('tab-active')){
    t.children[0].classList.remove('tab-active')

  }
});

  var tab_nav = this.children[0];
  var target = tab_nav.getAttribute('aria-controls')
  var tab = document.getElementById("tabs-1");
  
  tab_nav.classList.add('tab-active')


url=tab_nav.href;

ajax.fetch(url,tab)

  

}
}));

ajax.fetch(
    document.getElementById('ex1').children[0].children[0].href,
    document.getElementById("tabs-1")
    )
      });
     
    </script>
    @endsection