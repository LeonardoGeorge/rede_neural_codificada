# 🚀 RNH — Rapid Notification Handler para X (Twitter)

![Node](https://img.shields.io/badge/Node.js-%3E%3D14-green)
![Laravel](https://img.shields.io/badge/Laravel-ready-red)
![Status](https://img.shields.io/badge/status-active-success)
![License](https://img.shields.io/badge/license-MIT-blue)

> **RNH** é o motor que conecta sua aplicação ao mundo real via **X (Twitter)**.
> Esqueça processos manuais, planilhas e cópias/colas: aqui tudo é **automático, rápido e escalável**.

---

## ✨ O que é o RNH?

O **RNH (Rapid Notification Handler)** nasceu para ser **um disparador universal de mensagens**.
No contexto atual, ele está integrado ao **X (antigo Twitter)**, mas pode ser expandido para outras redes e canais.

👉 Ele resolve um problema simples, mas poderoso: **como automatizar postagens, agendamentos e interações no X sem dor de cabeça**.

Se você já pensou em:

- 💬 **Postar automaticamente** quando algo acontece na sua base de dados
- ⏰ **Agendar tweets** para horários estratégicos
- 🎞️ **Publicar mídia** (imagens, vídeos) junto com mensagens
- 🔁 **Fazer retweets automáticos** de contas ou hashtags monitoradas
- 📊 **Monitorar entregas e falhas** de forma centralizada

… então o **RNH é a peça que faltava no seu stack**.

---

## 🛠️ Tecnologias por trás

- **Node.js / Laravel** → Core do sistema (API e Jobs)
- **Banco de dados** (PostgreSQL ou MySQL) → Armazena posts, logs e agendamentos
- **Redis** (opcional) → Gerencia filas, reintentos e rate-limiting
- **Docker** → Facilita deploy em qualquer ambiente
- **API do X (Twitter)** → Canal de comunicação oficial

---

## ⚡ Funcionalidades principais

✔️ Postagem imediata (texto + mídia)
✔️ Agendamento de tweets com precisão de minutos
✔️ Upload de mídia direto para o X
✔️ Retry automático em caso de falha (com backoff configurável)
✔️ Webhook listener (opcional) para feedbacks e callbacks
✔️ Integração simples via REST API ou SDK interno

---

## 📦 Instalação rápida

```bash
git clone https://github.com/<seu-usuario>/rnh.git
cd rnh
npm install
cp .env.example .env
```
