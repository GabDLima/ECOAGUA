<!DOCTYPE html>
<html lang="pt-br">
<head>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      margin: 0;
      overflow: hidden;
      background: radial-gradient(circle, #1e3c72, #2a5298);
      height: 100vh;
      position: relative;
    }

    @keyframes rise {
      0% { bottom: -10px; opacity: 0; }
      50% { opacity: 1; }
      100% { bottom: 110vh; opacity: 0; }
    }

    @keyframes wave {
      0% { transform: translateX(0); }
      25% { transform: translateX(-15px); }
      50% { transform: translateX(15px); }
      75% { transform: translateX(-15px); }
      100% { transform: translateX(0); }
    }

    .bubble {
      position: absolute;
      background-color: rgba(255, 255, 255, 0.6);
      border-radius: 50%;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
      animation: rise linear infinite, wave ease-in-out infinite;
      z-index: 0;
    }

    .login-card,
    .cadastro-card,
    .reset-card,
    .set-password-card {
      width: 100%;
      max-width: 420px;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 1rem;
      backdrop-filter: blur(8px);
      z-index: 1;
    }

    .login-card .card-title,
    .cadastro-card .card-title,
    .reset-card .card-title,
    .set-password-card .card-title {
      font-weight: 600;
      color: #1e3c72;
    }

    .login-card .btn-primary,
    .cadastro-card .btn-primary,
    .reset-card .btn-primary,
    .set-password-card .btn-primary {
      background-color: #1e3c72;
      border-color: #1e3c72;
    }

    .login-card .btn-primary:hover,
    .cadastro-card .btn-primary:hover,
    .reset-card .btn-primary:hover,
    .set-password-card .btn-primary:hover {
      background-color: #163558;
      border-color: #163558;
    }

    .login-card a,
    .cadastro-card a,
    .reset-card a,
    .set-password-card a {
      color: #1e3c72;
    }

    .login-card a:hover,
    .cadastro-card a:hover,
    .reset-card a:hover,
    .set-password-card a:hover {
      text-decoration: underline;
    }
  </style>
</head>