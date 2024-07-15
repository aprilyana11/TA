<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
    <link rel="stylesheet" href="{{ asset('css/style4.css') }}">
</head>

<body>
    <div class="container">
        <h1>Form Registrasi</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="/api/register" method="post" class="sign-in-form">
            @csrf
            <div class="main-user-info">
                <div class="user-input-box">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter Full Name" value="{{ old('fullname') }}" required>
                    @error('fullname')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="user-input-box">
                    <label for="username">Nama Pengguna</label>
                    <input type="text" id="username" name="username" placeholder="Enter Username" value="{{ old('username') }}" required>
                    @error('username')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="user-input-box">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="user-input-box">
                    <label for="phone_number">No Hp</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}" required>
                    @error('phone_number')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="user-input-box">
                    <label for="password">Katasandi</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="gender-details-box">
                <span class="gender-title">Jenis Kelamin</span>
                <div class="gender-category">
                    <input type="radio" name="gender" id="male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                    <label for="male">Male</label>
                    <input type="radio" name="gender" id="female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                    <label for="female">Female</label>
                    <input type="radio" name="gender" id="other" value="other" {{ old('gender') == 'other' ? 'checked' : '' }}>
                    <label for="other">Other</label>
                    @error('gender')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="weight-details-box">
                <span class="weight-title">Berat Badan</span>
                <div class="weight-category">
                    <input type="number" id="weight" name="weight" placeholder="kg" value="{{ old('weight') }}" required>
                    @error('weight')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-submit-btn">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
</body>

</html>