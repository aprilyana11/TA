<!-- resources/views/login.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="myscript.js" type="module"></script>
  <script src="app.js"></script>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
      @if(session('error'))
            <div class="alert alert-danger">
                <b>Opps!</b> {{session('error')}}
            </div>
            @endif
        <form action="{{ route('actionlogin') }}" method="post">
          @csrf
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" id="username" name="username" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" id="password" name="password" required />
          </div>
          <input type="submit" value="login" class="btn solid" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Welcome Back!</h3>
          <p>To keep connected with us please login with your personal info</p>
        </div>
        <img src="img/log.svg" class="image" alt="" />
      </div>
    </div>
  </div>
</body>

</html>