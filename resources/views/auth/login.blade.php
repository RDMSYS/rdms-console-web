<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Console | Login</title>
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
    crossorigin="anonymous"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
  />
  <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/assist.css') }}" />
  @yield('headers')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"
  ></script>
<style>
    body{
        padding: 0px;
        margin:0px;
        box-sizing:border-box;
    }
    .background{
        background-color:#0077d3;
    }
    .forground{
        background-color:#ffffff;

    }
</style>
</head>
<body>
    <section class="vh-100 background">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center">
                <div class="col-4">

                    @if(Session::get('fail'))
                    <div class="alert alert-danger p-2">
                        {{Session::get('fail')}}
                    </div>
                    @endif
                    @if(Session::get('success'))
                    <div class="alert alert-success p-2">
                        {{Session::get('success')}}
                    </div>
                    @endif
                </div>
            </div>
          <div class="row d-flex justify-content-center">
           <div class="col-4 forground p-4 rounded shadow">
            <form id="loginfrm" action="{{route('auth.login')}}" method="post">
                @csrf
                <h1 class="h1 fw-bold my-2">Login.</h1>
                <div class="form-outline mb-3">
                  <label class="form-label" for="username">Username</label>
                  <input type="text" id="username" name="username" class="form-control" value="{{old('username')}}" />
                  <span style="font-size:13px" class="text-danger ">@error('username'){{$message}}@enderror</span>
                </div>
              

                <div class="form-outline">
                  <label class="form-label" for="passwd">Password</label>
                  <input type="password" id="passwd" name="passwd" class="form-control" />
                  <span style="font-size:13px" class="text-danger ">@error('passwd'){{$message}}@enderror</span>
                </div>
                <button type="submit" class="btn btn-primary btn-block my-4">Log in</button>
              </form>
           </div>
          </div>
        </div>
      </section>

      <script>
          var form =document.getElementById("loginfrm");
          form.addEventListener('submit',function(e){
            e.preventDefault();
            var username = document.forms['loginfrm']['username'];
            var password = document.forms['loginfrm']['passwd'];
            if( username.value.trim() == ""){
                username.nextElementSibling.innerHTML = "username field is required" 
            }
            if(password.value.trim()== ""){
                password.nextElementSibling.innerHTML = "password field is required" 
            }
            if(password.value.trim() != "" && username.value.trim() != ""){
                form.removeEventListener('submit', form.submit())
            }else{
                return false;
            }

          });
      </script>
</body>
</html>