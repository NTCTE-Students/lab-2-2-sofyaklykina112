<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register new user</title>
</head>
<body>
    <h1>Register new user</h1>
    <form method="POST" action="{{ route('register') }}">
    @csrf

    <label for="name">Name:</label>
    <input type="text" name="name" value="{{ old('name') }}" required>
    @error('name') <div style="color:red">{{ $message }}</div> @enderror

    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ old('email') }}" required>
    @error('email') <div style="color:red">{{ $message }}</div> @enderror

    <label for="password">Password:</label>
    <input type="password" name="password" required>
    @error('password') <div style="color:red">{{ $message }}</div> @enderror

    <button type="submit">Register</button>
</form>
    <div>
        <a href="{{ route('login') }}">Already have an account? Login here</a>
    </div>
</body>
</html>
