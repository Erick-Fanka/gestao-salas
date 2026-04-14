<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SENAI Mauá</title>
    <style>
        /* Fundo com as curvas da imagem */
        body { 
            font-family: 'Segoe UI', sans-serif; 
            margin: 0; padding: 0; 
            background-image: url('{{ asset("image_6ce3a2.png") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex; justify-content: center; align-items: center; 
            height: 100vh; 
        }

        /* Card de Login Glassmorphism */
        .login-card { 
            background: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(10px);
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 100%; max-width: 380px; 
            border-top: 6px solid #FF5900; 
            border-bottom: 6px solid #005DAA;
            text-align: center;
        }

        .logo-text { font-size: 2rem; font-weight: bold; color: #005DAA; margin-bottom: 30px; display: block; text-decoration: none; }
        .logo-text span { color: #FF5900; }

        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; color: #005DAA; font-weight: bold; margin-bottom: 8px; }
        .form-group input { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; 
            box-sizing: border-box; font-size: 1rem; outline: none; transition: 0.3s;
        }
        .form-group input:focus { border-color: #005DAA; box-shadow: 0 0 8px rgba(0, 93, 170, 0.2); }

        .btn-entrar { 
            width: 100%; background: #FF5900; color: white; border: none; padding: 14px; 
            border-radius: 8px; font-size: 1.1rem; font-weight: bold; cursor: pointer; 
            transition: 0.2s; box-shadow: 0 4px 0 #cc4700;
        }
        .btn-entrar:hover { background: #cc4700; transform: translateY(2px); box-shadow: none; }

        .links-auxiliares { margin-top: 20px; font-size: 0.9rem; }
        .links-auxiliares a { color: #005DAA; text-decoration: none; font-weight: bold; }
        
        .erro-msg { color: #e74c3c; font-size: 0.85rem; margin-top: 5px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="login-card">
        <a href="/" class="logo-text">SENAI <span>Mauá</span></a>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>E-mail Corporativo</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="seu@email.com">
                @error('email') <span class="erro-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" required placeholder="••••••••">
                @error('password') <span class="erro-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-entrar">ENTRAR NO SISTEMA</button>

            <div class="links-auxiliares">
                <a href="/">← Voltar ao Início</a>
            </div>
        </form>
    </div>

</body>
</html>