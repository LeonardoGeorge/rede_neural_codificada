<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RNH | Bem-vindo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-primary: #000000;
            --bg-secondary: #1D1D1F;
            --bg-tertiary: #2C2C2E;
            --text-primary: #F5F5F7;
            --text-secondary: #A1A1A6;
            --accent-blue: #0A84FF;
            --accent-purple: #BF5AF2;
            --accent-cyan: #64D2FF;
            --gradient: linear-gradient(45deg, var(--accent-blue), var(--accent-purple));
            --radius: 12px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header */
        header {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-primary);
            text-decoration: none;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--gradient);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.95rem;
            transition: var(--transition);
            position: relative;
        }

        .nav-links a:hover {
            color: var(--text-primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient);
            transition: var(--transition);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Main Content */
        .welcome-hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 0;
            text-align: center;
            background: linear-gradient(to bottom, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            position: relative;
            overflow: hidden;
        }

        .welcome-hero::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(10, 132, 255, 0.15) 0%, rgba(0, 0, 0, 0) 70%);
            z-index: 0;
        }

        .welcome-hero::after {
            content: '';
            position: absolute;
            bottom: -200px;
            left: -200px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(191, 90, 242, 0.15) 0%, rgba(0, 0, 0, 0) 70%);
            z-index: 0;
        }

        .welcome-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }

        .welcome-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--accent-cyan), var(--accent-blue), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.1;
            letter-spacing: -0.5px;
        }

        .welcome-content p {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }

        .definition-box {
            background: var(--bg-secondary);
            border-radius: var(--radius);
            padding: 2.5rem;
            margin: 2rem 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: left;
        }

        .definition-box h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .definition-box h2 i {
            color: var(--accent-blue);
        }

        .definition-box p {
            font-size: 1.1rem;
            margin-bottom: 0;
            color: var(--text-secondary);
        }

        .btn {
            display: inline-block;
            background: var(--gradient);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0));
            opacity: 0;
            transition: var(--transition);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .btn:hover::before {
            opacity: 1;
        }

        /* Footer */
        footer {
            background: var(--bg-secondary);
            padding: 2rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }

        .copyright {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .welcome-content h1 {
                font-size: 2.5rem;
            }

            .welcome-content p {
                font-size: 1.1rem;
            }

            .definition-box {
                padding: 1.5rem;
            }

            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-links {
                gap: 1.5rem;
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container nav-container">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <span>RNH</span>
            </a>
            <nav class="nav-links">
                <a href="#about">Sobre</a>
                <a href="#features">Funcionalidades</a>
                <a href="#contact">Contato</a>
            </nav>
        </div>
    </header>

    <main class="welcome-hero">
        <div class="container welcome-content">
            <h1>Rede Neural Humana</h1>
            <p>Revolucionando a forma como humanos e máquinas interagem</p>
            
            <div class="definition-box">
                <h2><i class="fas fa-brain"></i> O que é a RNH?</h2>
                <p>A Rede Neural Humana (RNH) é uma plataforma inteligente de assistência por comando de voz que utiliza processamento de linguagem natural e aprendizado de máquina para interpretar e executar tarefas complexas automaticamente.</p>
                <p>Através de comandos intuitivos, a RNH conecta-se a diversas APIs e serviços, transformando suas intenções em ações concretas no mundo digital.</p>
            </div>

            <a href="/rnh" class="btn">
                <i class="fas fa-rocket"></i> Experimentar Agora
            </a>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="copyright">
                <p>&copy; 2025 RNH - Rede Neural Humana. Todos os direitos reservados | Leonardo George Dev. 62.358.912/0001-97</p>
            </div>
        </div>
    </footer>
</body>

</html>
