<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RNH | Assistente Pessoal Inteligente</title>
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

        /* Hero Section */
        .hero {
            padding: 8rem 0 6rem;
            text-align: center;
            background: linear-gradient(to bottom, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
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

        .hero::after {
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

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.75rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--accent-cyan), var(--accent-blue), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.1;
            letter-spacing: -0.5px;
        }

        .hero p {
            font-size: 1.5rem;
            color: var(--text-secondary);
            max-width: 700px;
            margin: 0 auto 3rem;
            font-weight: 400;
        }

        .hero-demo {
            background: var(--bg-secondary);
            border-radius: var(--radius);
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 2;
        }

        .voice-command {
            display: flex;
            align-items: center;
            background: var(--bg-tertiary);
            border-radius: 50px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            position: relative;
        }

        .voice-command:focus-within {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(10, 132, 255, 0.2);
        }

        .voice-command i {
            color: var(--accent-blue);
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .voice-command input {
            flex: 1;
            border: none;
            background: transparent;
            font-size: 1.1rem;
            color: var(--text-primary);
            outline: none;
        }

        .voice-command button {
            background: var(--gradient);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: white;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .voice-command button:hover {
            transform: scale(1.05);
        }

        .command-examples {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.25rem;
            margin-top: 2rem;
        }

        .command-example {
            background: var(--bg-tertiary);
            padding: 1.5rem;
            border-radius: var(--radius);
            text-align: left;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .command-example::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient);
            opacity: 0;
            transition: var(--transition);
            z-index: 0;
        }

        .command-example:hover {
            transform: translateY(-5px);
            border-color: rgba(10, 132, 255, 0.3);
        }

        .command-example:hover::before {
            opacity: 0.1;
        }

        .command-example i {
            font-size: 1.5rem;
            color: var(--accent-blue);
            margin-bottom: 0.75rem;
            display: block;
            position: relative;
            z-index: 1;
        }

        .command-example p {
            color: var(--text-secondary);
            position: relative;
            z-index: 1;
            transition: var(--transition);
        }

        .command-example:hover p {
            color: var(--text-primary);
        }

        /* Features Section */
        .features {
            padding: 8rem 0;
            background: var(--bg-secondary);
            position: relative;
        }

        .features::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
        }

        .section-title {
            text-align: center;
            margin-bottom: 5rem;
        }

        .section-title h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .section-title p {
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
            font-size: 1.25rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
        }

        .feature {
            text-align: center;
            padding: 2.5rem 2rem;
            border-radius: var(--radius);
            transition: var(--transition);
            background: var(--bg-tertiary);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
            border-color: rgba(10, 132, 255, 0.2);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        .feature h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .feature p {
            color: var(--text-secondary);
            line-height: 1.7;
        }

        /* CTA Section */
        .cta {
            padding: 8rem 0;
            text-align: center;
            background: var(--bg-primary);
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
        }

        .cta h2 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .cta p {
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 3rem;
            font-size: 1.25rem;
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
            padding: 5rem 0 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            margin-bottom: 4rem;
        }

        .footer-column h3 {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 0.75rem;
        }

        .footer-column a {
            text-decoration: none;
            color: var(--text-secondary);
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .footer-column a:hover {
            color: var(--accent-blue);
        }

        .copyright {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Notificações */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: var(--radius);
            background: var(--bg-tertiary);
            color: var(--text-primary);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            border-left: 4px solid #4CAF50;
        }

        .notification.error {
            border-left: 4px solid #F44336;
        }

        .notification i {
            font-size: 1.2rem;
        }

        /* Loader */
        .loader {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Novos estilos para funcionalidade de voz */
        .recording-indicator {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(239, 68, 68, 0.9);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            z-index: 1000;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        .voice-input-container {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
        }

        .voice-mode-btn {
            position: absolute;
            right: 10px;
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 1.2rem;
            transition: var(--transition);
            z-index: 2;
        }

        .voice-mode-btn:hover {
            color: var(--accent-blue);
        }

        /* Ajuste para o input não ficar atrás do botão */
        .voice-input-container input {
            padding-right: 40px;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.75rem;
            }

            .hero p {
                font-size: 1.25rem;
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

            .hero-demo {
                padding: 1.75rem;
            }

            .section-title h2 {
                font-size: 2.25rem;
            }

            .cta h2 {
                font-size: 2.25rem;
            }
            
            .voice-mode-btn {
                right: 5px;
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
                <span>RNC</span>
            </a>
            <nav class="nav-links">
                <a href="#features">Funcionalidades</a>
                <a href="#demo">Experimentar</a>
                <a href="#about">Sobre</a>
                <a href="#contact">Contato</a>
            </nav>
        </div>
    </header>

    <div class="recording-indicator" id="recording-indicator">
        <i class="fas fa-microphone"></i> Gravando... Fale agora
    </div>

   <section class="hero">
        <div class="container hero-content">
            <h1>O futuro da interação digital</h1>
            <p>Comandos de voz que transformam suas intenções em ações automáticas</p>

            <div class="hero-demo">
                <div class="voice-command">
                    <!-- ÍCONE DE MICROFONE AGORA CLICÁVEL -->
                    <i class="fas fa-microphone" id="voice-toggle"></i>
                    <div class="voice-input-container">
                        <input type="text" id="voice-input" placeholder="Diga um comando... Ex: 'Poste no Twitter Olá mundo'">
                    </div>
                    <button id="action-btn">
                        <i class="fas fa-play"></i>
                    </button>
                </div>

                <div class="command-examples">
                    <div class="command-example" data-command="Poste no Twitter Estou testando a RNH!">
                        <i class="fab fa-twitter"></i>
                        <h3>Postar no Twitter</h3>
                        <p>"Poste no Twitter [sua mensagem]"</p>
                    </div>
                    <div class="command-example" data-command="Crie uma nota Reunião amanhã às 10h">
                        <i class="fas fa-sticky-note"></i>
                        <h3>Criar Nota</h3>
                        <p>"Crie uma nota [texto da nota]"</p>
                    </div>
                    <div class="command-example" data-command="Pesquise no Google Inteligência Artificial">
                        <i class="fab fa-google"></i>
                        <h3>Pesquisar</h3>
                        <p>"Pesquise no Google [termo de busca]"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="container">
            <div class="section-title">
                <h2>Funcionalidades</h2>
                <p>Descubra tudo que a Rede Neural Humana pode fazer por você</p>
            </div>

            <div class="features-grid">
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-microphone-alt"></i>
                    </div>
                    <h3>Comandos de Voz</h3>
                    <p>Interaja naturalmente com sua assistente pessoal através de comandos de voz intuitivos.</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fab fa-twitter"></i>
                    </div>
                    <h3>Postagens Automáticas</h3>
                    <p>Poste conteúdo no Twitter automaticamente através de comandos de voz.</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Processamento Inteligente</h3>
                    <p>Nossa IA entende o contexto e a intenção por trás de cada comando.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="cta">
        <div class="container">
            <h2>Pronto para experimentar o futuro?</h2>
            <p>Junte-se a nós e revolucione a forma como você interage com a tecnologia</p>
            <button class="btn" id="start-btn">Começar Agora</button>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>RNH</h3>
                    <ul>
                        <li><a href="#">Sobre nós</a></li>
                        <li><a href="#">Nossa missão</a></li>
                        <li><a href="#">Carreiras</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Recursos</h3>
                    <ul>
                        <li><a href="#">Documentação</a></li>
                        <li><a href="#">Tutoriais</a></li>
                        <li><a href="#">API</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Suporte</h3>
                    <ul>
                        <li><a href="#">Central de Ajuda</a></li>
                        <li><a href="#">Contato</a></li>
                        <li><a href="#">Status</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 RNH - Rede Neural Humana. Todos os direitos reservados | Leonardo George Dev. 62.358.912/0001-97</p>
            </div>
        </div>
    </footer>

    <div id="notification" class="notification">
        <i class="fas fa-info-circle"></i>
        <span id="notification-text"></span>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const actionBtn = document.getElementById('action-btn');
        const voiceToggle = document.getElementById('voice-toggle');
        const voiceInput = document.getElementById('voice-input');
        const startBtn = document.getElementById('start-btn');
        const notification = document.getElementById('notification');
        const notificationText = document.getElementById('notification-text');
        const commandExamples = document.querySelectorAll('.command-example');
        const recordingIndicator = document.getElementById('recording-indicator');
        
        // Configuração do CSRF Token para requisições AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Variáveis para controle de gravação
        let isRecording = false;
        let mediaRecorder = null;
        let audioChunks = [];
        let isVoiceMode = false;
        
        // Verificar suporte a gravação de áudio
        const isRecordingSupported = navigator.mediaDevices && navigator.mediaDevices.getUserMedia;
        
        // Alternar entre modos de entrada (texto/voz) ao clicar no ícone do microfone
        voiceToggle.addEventListener('click', () => {
            if (!isRecordingSupported) {
                showNotification('Seu navegador não suporta gravação de áudio.', 'error');
                return;
            }
            
            isVoiceMode = !isVoiceMode;
            
            if (isVoiceMode) {
                voiceToggle.classList.add('voice-active');
                voiceInput.placeholder = 'Clique no microfone e fale...';
                actionBtn.innerHTML = '<i class="fas fa-microphone"></i>';
                showNotification('Modo voz ativado. Clique no microfone para gravar.', 'success');
            } else {
                voiceToggle.classList.remove('voice-active');
                voiceInput.placeholder = 'Diga um comando... Ex: "Poste no Twitter Olá mundo"';
                actionBtn.innerHTML = '<i class="fas fa-play"></i>';
                showNotification('Modo texto ativado. Digite seu comando.', 'success');
            }
        });
        
        // Exemplo de comandos
        commandExamples.forEach(example => {
            example.addEventListener('click', () => {
                voiceInput.value = example.getAttribute('data-command');
                processCommand(voiceInput.value);
            });
        });
        
        // Botão de ação (gravar/executar)
        actionBtn.addEventListener('click', () => {
            if (isVoiceMode && isRecordingSupported) {
                // Modo voz: iniciar/parar gravação
                if (!isRecording) {
                    startRecording();
                } else {
                    stopRecording();
                }
            } else {
                // Modo texto: processar comando digitado
                if (voiceInput.value.trim() !== '') {
                    processCommand(voiceInput.value);
                } else {
                    showNotification('Por favor, digite um comando primeiro.', 'error');
                }
            }
        });
        
        // Botão de começar
        startBtn.addEventListener('click', () => {
            voiceInput.focus();
            showNotification('Digite ou clique em um comando de exemplo para começar.', 'success');
        });
        
        // Iniciar gravação
        async function startRecording() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];
                
                mediaRecorder.ondataavailable = (event) => {
                    audioChunks.push(event.data);
                };
                
                mediaRecorder.onstop = async () => {
                    const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    await sendAudioToServer(audioBlob);
                    stream.getTracks().forEach(track => track.stop());
                };
                
                mediaRecorder.start();
                isRecording = true;
                voiceToggle.classList.remove('voice-active');
                voiceToggle.classList.add('voice-listening');
                actionBtn.innerHTML = '<i class="fas fa-stop"></i>';
                recordingIndicator.style.display = 'block';
                
            } catch (error) {
                console.error('Erro ao acessar o microfone:', error);
                showNotification('Não foi possível acessar o microfone. Verifique as permissões.', 'error');
                isVoiceMode = false;
                voiceToggle.classList.remove('voice-active', 'voice-listening');
                actionBtn.innerHTML = '<i class="fas fa-play"></i>';
            }
        }
        
        // Parar gravação
        function stopRecording() {
            if (mediaRecorder && isRecording) {
                mediaRecorder.stop();
                isRecording = false;
                voiceToggle.classList.remove('voice-listening');
                actionBtn.innerHTML = '<i class="fas fa-microphone"></i>';
                recordingIndicator.style.display = 'none';
            }
        }
        
        // Enviar áudio para o servidor
        async function sendAudioToServer(audioBlob) {
            showNotification('Processando seu áudio...', 'success');
            
            const formData = new FormData();
            formData.append('audio', audioBlob, 'voice_command.webm');
            
            try {
                const response = await fetch('/api/voice/process', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                if (!response.ok) {
                    throw new Error('Erro na resposta do servidor: ' + response.status);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    voiceInput.value = data.transcribed_text || '';
                    
                    // Se temos texto transcrito, processar o comando
                    if (data.transcribed_text && data.transcribed_text.trim() !== '') {
                        processCommand(data.transcribed_text);
                    } else {
                        showNotification('Não foi possível entender o áudio. Tente novamente.', 'error');
                    }
                } else {
                    showNotification(data.message || 'Erro no processamento de áudio', 'error');
                }
            } catch (error) {
                console.error('Erro:', error);
                showNotification('Erro de conexão. Tente novamente.', 'error');
            }
        }
        
        // Processar comando
        function processCommand(command) {
            showNotification('Processando seu comando...', 'success');
            
            // Mudar ícone para indicar processamento
            const icon = actionBtn.querySelector('i');
            icon.className = 'loader';
            
            fetch('/api/voice-command', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ command: command })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta do servidor: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Restaurar ícone
                icon.className = isVoiceMode ? 'fas fa-microphone' : 'fas fa-play';
                
                if (data.status === 'success') {
                    showNotification(data.message, 'success');
                    voiceInput.value = '';
                } else {
                    showNotification(data.message || 'Erro desconhecido', 'error');
                }
            })
            .catch(error => {
                // Restaurar ícone em caso de erro
                icon.className = isVoiceMode ? 'fas fa-microphone' : 'fas fa-play';
                showNotification('Erro de conexão. Tente novamente.', 'error');
                console.error('Error:', error);
            });
        }
        
        // Mostrar notificação
        function showNotification(message, type) {
            notification.className = 'notification ' + type;
            notificationText.textContent = message;
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }
        
        // Permitir enviar comando com Enter (apenas no modo texto)
        voiceInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !isVoiceMode) {
                actionBtn.click();
            }
        });
    });
    </script>
</body>
</html>