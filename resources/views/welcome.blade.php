<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Interna - SENAI Mauá</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; background-color: #f4f6f8; color: #333; }
        
        /* Navbar */
        header { background-color: #fff; padding: 20px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 5px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 100; border-top: 5px solid #FF5900; border-bottom: 1px solid #005DAA; }
        .logo { font-size: 1.5rem; font-weight: bold; color: #005DAA; }
        .logo span { color: #FF5900; font-weight: 900; }
        
        .area-botoes { display: flex; align-items: center; gap: 20px; }
        .btn-login { background-color: #fff; color: #005DAA; border: 2px solid #005DAA; padding: 8px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.2s; }
        .btn-login:hover { background-color: #005DAA; color: white; }
        
        .btn-painel { background-color: #FF5900; color: white; padding: 10px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.2s; border: none; box-shadow: 0 4px 0 #cc4700; }
        .btn-painel:hover { background-color: #cc4700; transform: translateY(2px); box-shadow: none; }

        /* User Dropdown */
        .user-dropdown { position: relative; display: inline-block; cursor: pointer; }
        .user-name { color: #005DAA; font-weight: bold; padding: 10px 0; }
        .dropdown-content { display: none; position: absolute; right: 0; background-color: white; min-width: 160px; box-shadow: 0px 8px 16px rgba(0,0,0,0.1); border-radius: 5px; z-index: 1; }
        .user-dropdown:hover .dropdown-content { display: block; }
        .dropdown-content button { width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; font-size: 0.95rem; color: #d32f2f; font-weight: bold; cursor: pointer; }
        .dropdown-content button:hover { background-color: #fef2f2; }

        /* Hero Section */
        .hero { background: linear-gradient(135deg, #ffffff 0%, #e6f0fa 100%); padding: 80px 20px; text-align: center; border-bottom: 1px solid #d1d9e0; }
        .hero h1 { font-size: 2.5rem; margin-bottom: 15px; color: #005DAA; }
        .hero p { font-size: 1.1rem; max-width: 800px; margin: 0 auto 30px auto; line-height: 1.6; color: #444; }
        
        /* Features */
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 60px 50px; max-width: 1100px; margin: auto; }
        .card-feature { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); border-top: 4px solid #FF5900; border-bottom: 2px solid #005DAA; transition: 0.3s; }
        .card-feature h3 { color: #005DAA; margin: 0 0 10px 0; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; }
        .card-feature p { color: #555; line-height: 1.5; font-size: 0.95rem; }

        /* Footer & Créditos */
        footer { background-color: #fff; padding: 40px 20px 20px; margin-top: 40px; border-top: 3px solid #005DAA; text-align: center; }
        .creditos-container h4 { color: #005DAA; margin-top: 0; margin-bottom: 10px; font-size: 1.1rem; }
        .creditos-container p { color: #666; font-size: 0.95rem; max-width: 700px; margin: 0 auto 25px; line-height: 1.5; }
        
        .social-links { display: flex; justify-content: center; gap: 15px; margin-bottom: 25px; }
        .btn-social { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.9rem; color: white; transition: 0.2s; }
        .btn-linkedin { background-color: #0077b5; }
        .btn-linkedin:hover { transform: scale(1.05); }
        .btn-github { background-color: #24292e; }
        .btn-github:hover { transform: scale(1.05); }
        .icon-svg { width: 18px; height: 18px; fill: currentColor; }

        .copyright { color: #999; font-size: 0.8rem; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>

    <header>
        <div class="logo">SENAI <span>Mauá</span></div>
        <div class="area-botoes">
            @auth
                <div class="user-dropdown">
                    <div class="user-name">{{ Auth::user()->name }} ▼</div>
                    <div class="dropdown-content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Sair do Sistema</button>
                        </form>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}" class="btn-painel">Acessar Painel</a>
            @else
                <a href="{{ route('login') }}" class="btn-login">Login Restrito</a>
            @endauth
        </div>
    </header>

    <section class="hero">
        <h1>Gestão Interna de Salas e Ativos</h1>
        <p>Esta plataforma foi desenvolvida para o uso restrito do <strong>SENAI Mauá</strong>, focada no monitoramento de ocupação, cruzamento de dados de infraestrutura e controle operacional diário dos laboratórios e salas de aula.</p>
    </section>

    <section class="features">
        <div class="card-feature">
            <h3>Indicadores Mensais</h3>
            <p>Métricas de taxa de ocupação, mapas de calor por turno e identificação de ociosidade em toda a unidade.</p>
        </div>
        <div class="card-feature">
            <h3>Raio-X de Infraestrutura</h3>
            <p>Cruzamento direto da lista de equipamentos com o uso real da sala, garantindo que recursos não fiquem parados.</p>
        </div>
        <div class="card-feature">
            <h3> Quadro Operacional</h3>
            <p>Visão em tempo real da disponibilidade de salas, turmas alocadas e instrutores para resolução rápida de problemas.</p>
        </div>
    </section>

    <footer>
        <div class="creditos-container">
            <h4>Sobre o Desenvolvimento</h4>
            <p>Esta plataforma de Gestão de Salas e Inteligência de Ativos foi idealizada, arquitetada e desenvolvida integralmente por <strong>Erick Fanka</strong>, com o objetivo de otimizar processos operacionais através de análises de dados.</p>
            
            <div class="social-links">
                <a href="https://www.linkedin.com/in/erick-fanka/" target="_blank" class="btn-social btn-linkedin">
                    <svg class="icon-svg" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    Conectar no LinkedIn
                </a>

                <a href="https://github.com/Erick-Fanka" target="_blank" class="btn-social btn-github">
                    <svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    Ver no GitHub
                </a>
            </div>
            
            <div class="copyright">
                &copy; {{ date('Y') }} SENAI Mauá - Uso Interno Restrito.
            </div>
        </div>
    </footer>

</body>
</html>