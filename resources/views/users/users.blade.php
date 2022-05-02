
@extends('./layout/app')


@section('title',"Console | Users")
@section('body')
<div class="py-2 ">
      <div class="d-flex bd-highlight">
        <div class="p-2 flex-grow-1 bd-highlight">
          <h2 class="h2">Users</h2>
        </div>
        <div class="p-2 bd-highlight">
            <a href="{{route('user.create')}}"  type="button" class="btn btn-primary p-2"><i class='bx bxs-user-plus' ></i> Create a user</a>
        </div>
      </div>
    </div>
    <section class="container" id="users">
      <div class="row">
        <div class="col">

            @if(Session::get('fail'))
            <div class="alert alert-danger" role="alert">
              {{Session::get('fail')}}
            </div>
            @endif
            @if(Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
            @endif
        </div>
    </div>
      <table class="table table-bordered my-5">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col">Real Name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">User level</th>
            <th scope="col">Status</th>
            <th class="col-1" scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i= 0; ?>
          @foreach($results as $user)
          @if($user['user_id'] != session()->get('id'))
          <?php $i++; ?>
          <tr>
            <th scope="row">{{$i}}</th>
            <td>{!!$user['realname']!!}</td>
            <td>{!!$user['username']!!}</td>
            <td>{!!$user['email']!!}</td>
            <td>{!!$user['level']!!}</td>
            @if($user['is_enabled'] =="Enabled")
              <td><span class="badge bg-success">{!!$user['is_enabled']!!}</span></td>
            @else
              <td><span class="badge bg-danger">{!!$user['is_enabled']!!}</span></td>
            @endif
            <td>
              <form method="POST" class="delete_form" action="{{route('users.destroy',$user['user_id'])}}">
                {{ method_field('DELETE') }}
                {{  csrf_field() }}
                <button type="submit" class="btn btn-sm btn-danger p-1">{{ trans('Delete') }}</button>
                </form>
            </td>
          </tr>
          @endif
          
          @endforeach
        </tbody>
      </table>

    </section>

    @endsection

    @section('scripts')
    <script>
      $(document).ready(function(){
          $('.delete_form').on('submit', function(){
             if(confirm("Are you sure you want to delete it?"))
             {
                 return true;
             }
             else
             {
                 return false;
             }
          });

          
      });
    </script>
    @endsection