<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #dfa974;, #fff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 50px;
            width: 400px;
            max-width: 100%;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 700;
            color: #333;
            text-align: center;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #ee7e0e;
        }

        .login-container button {
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background: #e6aa6f;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background: #f3881d;
        }

        .login-container .footer {
            text-align: center;
            margin-top: 15px;
        }

        .login-container .footer a {
            color: #f3881d;
            text-decoration: none;
            font-weight: 500;
        }

        .login-container .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>{{ __('message.login') }}</h2>

        {{-- @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success')}}</div>
        @endif --}}
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error')}}</div>
        @endif

        <form action="{{route('authenticate')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('message.email') }}</label>
                <input type="email" id="email" name="email" class="@error('email') is-invalid  @enderror" required>
                @error('email')
                    <p class="invalid-feedback">{{ $message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">{{ __('message.password') }}</label>
                <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror" required>
                @error('password')
                <p class="invalid-feedback">{{ $message}}</p>
            @enderror
            </div>
            <button type="submit">{{ __('message.login') }} </button>
        </form>
        <div class="footer">
            <p>{{ __('message.dont_have_an_account? ') }} <a href="{{route('register')}}">{{ __('message.register') }}</a></p>
        </div>
    </div>
</body>
</html>
