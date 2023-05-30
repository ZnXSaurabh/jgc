@extends('layouts.web')

@section('content')
<section style="margin-top: 10%; margin-bottom:5%">
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <form id="login-form" method="POST" action="{{ url('customLogin') }}">
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
            <div class="g-recaptcha" data-sitekey="6LeE2TsmAAAAAGgM4VzY7RUsyrMows9exNl01c2V"></div>
            <p id="checkCaptcha" style="color:red;font-size:15px;"></p>
          </div><br>

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
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
  document.getElementById('login-form').addEventListener('submit', function(event) {
    var response = grecaptcha.getResponse();
    if (response.length === 0) {
      event.preventDefault(); // Prevent form submission
      document.getElementById('checkCaptcha').textContent = 'Please check the reCAPTCHA.';
    }
  });
</script>
@endsection
