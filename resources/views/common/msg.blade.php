@if($errors->any())
      <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
@endif
@if(Session::has('error'))
<div class="alert alert-danger">{{ Session::get("error") }} </div>
@endif
@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get("success") }} </div>
@endif