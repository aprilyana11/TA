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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelector('.sign-in-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Get form data
        let formData = new FormData(this);

        // Convert FormData to object for logging
        let formDataObject = {};
        formData.forEach((value, key) => {
          formDataObject[key] = value;
        });

        // Log form data to console
        console.log('Form Data:', formDataObject);

        // Send form data to the API using Axios
        axios.post('/api/login', formDataObject)
          .then(function(response) {
            console.log('API Response:', response.data);
            // Handle successful response here, e.g., redirect or show success message
            // Example:
            // window.location.href = '/dashboard';
          })
          .catch(function(error) {
            console.error('API Error:', error);
            // Handle error response here, e.g., show error message
            // Example:
            // alert('Login failed. Please try again.');
          });
      });
    });
  </script>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form method="POST" class="sign-in-form">
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
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
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