<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Estocai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">

    <style>
        * {
            
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .left {
            flex: 1;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left img {
            max-width: 80%;
            height: auto;
        }

        .right {
            flex: 1;
            background-color: #4f7df9;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border-top-left-radius: 1rem;
            border-bottom-left-radius: 1rem;
        }

        .form-container {
            max-width: 320px;
            width: 100%;
        }
        .form-container h1 {
        font-size: 50px;
        text-align: center;
        margin-bottom: 1rem;
        font-family: 'Poppins', sans-serif;
        }

        
        .logo{
            width: 300px;
        }

        .form-container h2 {
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }

        .form-container p {
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .form-container a {
            color: #ffaf3eff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"],
        input[type="password"] {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: none;
            border-radius: 0.4rem;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .actions input {
            margin-right: 0.3rem;
        }

        button {
            padding: 0.75rem;
            background-color: #FE9D17;
            border: none;
            color: white;
            border-radius: 0.4rem;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #FA8C0F;
        }

        .error {
            color: #ad0606ff;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left, .right {
                flex: none;
                width: 100%;
                border-radius: 0;
            }

            .right {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <img src="{{ asset('img/login.png') }}" alt="Illustration">
        </div>
        <div class="right">
            <div class="form-container">
                <div class="img-logo">
                  <img class="logo" src="{{ asset('img/logo.png') }}" alt="estocai">
                </div>
                <h2>Bem vindoa!</h2>
                <p>Não tem uma conta? <a href="#">Registre-se</a></p>

                @if ($errors->any())
                    <div class="error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Username" value="{{ old('email') }}" required>
                    <input type="password" name="password" placeholder="Password" required>

                    <div class="actions">
                        <label><input type="checkbox" name="remember"> Lembre-me</label>
                        <a href="#">Esqueceu a senha?</a>
                    </div>

                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
