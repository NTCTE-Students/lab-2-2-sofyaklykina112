<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="{{ route('login') }}">
    @csrf

    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ old('email') }}" required>
    @error('email') <div style="color:red">{{ $message }}</div> @enderror

    <label for="password">Password:</label>
    <input type="password" name="password" required>
    @error('password') <div style="color:red">{{ $message }}</div> @enderror

    <button type="submit">Login</button>
</form>
@if(session('error'))
    <div style="color:red">{{ session('error') }}</div>
@endif
    <div>
        <a href="{{ route('register') }}">Don't have an account? Register here</a>
    </div>
</body>
</html>
