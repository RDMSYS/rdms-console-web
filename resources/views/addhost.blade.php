
@extends('./layout/app')


@section('title',"Console | Hostes")

@section('body')
<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          <h2 class="h2">Add Device</h2>
        </div>
        <div class="p-2 bd-highlight">
          <a href="{{route('hostes.index')}}"  type="button" class="btn btn-dark p-2"><i class='bx bx-arrow-back' style='color:#ffffff' ></i> </i>Back</a>
        </div>
      </div>
    </div>




    <section class="container" id="main_container" >
      <div class="sub_nav">
        <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
          <li class="nav-item" >
            <a
              class="nav-link tab-active"
              aria-controls="tabs-1"
              >Auto discovery</a
            >
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              aria-controls="tabs-2"
              >Manual add device</a
            >
          </li>
         
        </ul>
     
        <div class="tab-content" id="tab-content">
          <div
            class="tab-pane fade show active"
            id="tabs-1"
          >
            Tab 1 content
          </div>
          <div class="tab-pane fade w-100 mb-3" id="tabs-2"  >
            <div class="d-flex align-items-center " >
              <div class="container text-dark" >
                      <div class="col-md-5">
                          <div class="card " >
                              <div class="card-body">
                                  <h3>Manual add</h3>
                                  <form action="{{route('hostes.store')}}"  method="POST" id="add_dev">
                                    @csrf
                                      <div class="form-group my-1">
                                          <label for="hostname">Hostname or IP </label>
                                          <input type="text" class="form-control " id="hostname" aria-datatype="alpha_num" name="hostname" aria-required="true"  placeholder="Hostname or IP">
                                          <span style="font-size:13px">*Requierd</span>
                                        </div>
                                      <div class="form-group my-1">
                                        <label for="serialno">Serial number </label>
                                        <input type="text" class="form-control" id="serialno" name="serialno" aria-datatype="serial_key" aria-required="true" placeholder="Serial number">
                                        <span style="font-size:13px">*Requierd</span>
                                      </div>
                                      <div class="form-group my-1">
                                        <label for="group">Group </label>
                                        <input type="text" list="grouplist" class="form-control" id="group" aria-datatype="alpha_num" name="group" aria-required="true" placeholder="Group">
                                        <span style="font-size:13px">*Requierd</span>
                                        <datalist id="grouplist">
                                          @foreach($groups as $group)
                                            <option value={{$group}}>
                                          @endforeach
                                          
                                        </datalist>
                                      </div>
                                      <div class="form-group my-1">
                                        <label for="comstring">Community String </label>
                                        <input type="text" class="form-control" id="comstring" name="comstring" aria-datatype="alpha_num" aria-required="true" placeholder="Community String">
                                        <span style="font-size:13px">*Requierd</span>
                                      </div>
                                      <div class="my-4">
                                        <button type="submit" class="btn btn-primary">Add device</button>
                                      </div>
                                  </form>
                              </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    @endsection

    @section('scripts')
    <script src="{{asset('js/console_main.js')}}"></script>

    <script>

$(document).ready(function () {
  var nav_item = document.querySelectorAll('.nav-item'); 

nav_item.forEach((t) => t.addEventListener('click',tab_changer));

function tab_changer(){
if(nav_item){
nav_item.forEach((t) => {
  if(t.children[0].classList.contains('tab-active')){
    t.children[0].classList.remove('tab-active')

  }
  if(document.getElementById(t.children[0].getAttribute('aria-controls')).classList.contains('active')){
    document.getElementById(t.children[0].getAttribute('aria-controls')).classList.remove('active');
    document.getElementById(t.children[0].getAttribute('aria-controls')).classList.remove('show');
  }
  var tab_nav = this.children[0];
  var target = tab_nav.getAttribute('aria-controls')
  var tab = document.getElementById(target);
  
  tab_nav.classList.add('tab-active')
  tab.classList.add('active')
  tab.classList.add('show')
  
});
}
}
var form_elemet = document.querySelectorAll(".form-control");

// form validation
var formClass = new FormClass(form_elemet)
formClass.validate()

$("#add_dev").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    formClass.submit(formData,$(this).attr('action'),$(this).attr('method'),document.getElementById('main_container'),$(this))

});

      });
     
    </script>
    @endsection