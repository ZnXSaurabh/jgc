@extends('layouts.web')

@section('content')
<section style="margin-top: 10%; margin-bottom:5%">
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <form method="POST" action="{{ url('customLogin') }}">
          @csrf
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
          </div>

          <div class="form-group">
          @if($errors->has('email'))
          <span class="error-message text-danger">{{ $errors->first('email') }}</span>
          @endif
         <button class="log-form" id="login_button" type="submit" style="color:white;background-color:#ed1b24">Login</button>
          </div>


          @if($errors->any() && !($errors->has('email') || $errors->has('password')))
            <div class="error-message">
              @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif
        </form>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</section>
@endsection
