<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion — ISI BURGER</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800;900&family=Instrument+Sans:wght@300;400;500;600&display=swap"
    rel="stylesheet">
  <style>
    :root {
      --ember: #FF4D1A;
      --ember-light: #FF7A52;
      --ember-glow: rgba(255, 77, 26, 0.35);
      --ember-soft: rgba(255, 77, 26, 0.12);
      --glass-bg: rgba(255, 255, 255, 0.065);
      --glass-bg-med: rgba(255, 255, 255, 0.10);
      --glass-bg-high: rgba(255, 255, 255, 0.16);
      --glass-border: rgba(255, 255, 255, 0.18);
      --glass-border-hi: rgba(255, 255, 255, 0.32);
      --glass-shadow-lg: 0 24px 64px rgba(0, 0, 0, 0.40), 0 1px 0 rgba(255, 255, 255, 0.12) inset;
      --tx-primary: rgba(255, 255, 255, 0.95);
      --tx-secondary: rgba(255, 255, 255, 0.60);
      --tx-tertiary: rgba(255, 255, 255, 0.35);
      --tx-muted: rgba(255, 255, 255, 0.20);
      --r-md: 16px;
      --r-lg: 22px;
      --r-xl: 30px;
      --r-2xl: 40px;
      --ease: cubic-bezier(0.23, 1, 0.32, 1);
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Instrument Sans', sans-serif;
      background: #0A0A0C;
      color: var(--tx-primary);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      -webkit-font-smoothing: antialiased;
    }

    .ambient {
      position: fixed;
      inset: 0;
      z-index: 0;
      pointer-events: none;
    }

    .ambient::before {
      content: '';
      position: absolute;
      top: -30%;
      left: -10%;
      width: 60vw;
      height: 60vw;
      background: radial-gradient(ellipse, rgba(255, 77, 26, 0.18) 0%, transparent 65%);
      animation: driftA 20s ease-in-out infinite alternate;
    }

    .ambient::after {
      content: '';
      position: absolute;
      bottom: -20%;
      right: -10%;
      width: 50vw;
      height: 50vw;
      background: radial-gradient(ellipse, rgba(255, 77, 26, 0.10) 0%, transparent 65%);
      animation: driftB 25s ease-in-out infinite alternate;
    }

    @keyframes driftA {
      from {
        transform: translate(0, 0)scale(1)
      }

      to {
        transform: translate(5vw, 5vh)scale(1.15)
      }
    }

    @keyframes driftB {
      from {
        transform: translate(0, 0)scale(1)
      }

      to {
        transform: translate(-6vw, -4vh)scale(1.1)
      }
    }

    .login-card {
      width: 100%;
      max-width: 420px;
      border-radius: var(--r-2xl);
      overflow: hidden;
      position: relative;
      z-index: 1;
      background: var(--glass-bg-high);
      backdrop-filter: blur(32px) saturate(200%);
      -webkit-backdrop-filter: blur(32px) saturate(200%);
      border: 1px solid var(--glass-border-hi);
      box-shadow: var(--glass-shadow-lg);
    }

    .login-top {
      padding: 36px 32px 28px;
      background: linear-gradient(160deg, rgba(255, 77, 26, 0.12), transparent 60%);
      border-bottom: 1px solid var(--glass-border);
      text-align: center;
    }

    .login-logo {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, var(--ember), var(--ember-light));
      border-radius: var(--r-lg);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px;
      box-shadow: 0 8px 24px var(--ember-glow);
    }

    .login-logo svg {
      width: 26px;
      height: 26px;
      fill: #fff;
    }

    .login-title {
      font-family: 'Syne', sans-serif;
      font-size: 22px;
      font-weight: 900;
      margin-bottom: 4px;
    }

    .login-sub {
      font-size: 13px;
      color: var(--tx-tertiary);
    }

    .login-body {
      padding: 28px 32px;
    }

    .field {
      width: 100%;
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      border-radius: var(--r-md);
      padding: 11px 16px;
      font-family: 'Instrument Sans', sans-serif;
      font-size: 13.5px;
      color: var(--tx-primary);
      outline: none;
      transition: all .2s var(--ease);
    }

    .field::placeholder {
      color: var(--tx-tertiary);
    }

    .field:focus {
      border-color: rgba(255, 77, 26, 0.5);
      background: var(--glass-bg-med);
      box-shadow: 0 0 0 3px rgba(255, 77, 26, 0.12);
    }

    .field-label {
      font-size: 11.5px;
      font-weight: 600;
      color: var(--tx-tertiary);
      letter-spacing: .06em;
      text-transform: uppercase;
      margin-bottom: 6px;
      display: block;
    }

    .field-group {
      margin-bottom: 16px;
    }

    .btn-ember {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      background: linear-gradient(135deg, var(--ember), var(--ember-light));
      color: #fff;
      border: none;
      border-radius: 14px;
      padding: 13px;
      font-family: 'Instrument Sans', sans-serif;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all .25s var(--ease);
      box-shadow: 0 4px 20px var(--ember-glow);
    }

    .btn-ember:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 32px var(--ember-glow);
    }

    .alert-danger {
      padding: 10px 14px;
      border-radius: var(--r-md);
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      background: rgba(255, 80, 80, 0.12);
      color: #FF6B6B;
      border: 1px solid rgba(255, 80, 80, 0.2);
    }
  </style>
</head>

<body>
  <div class="ambient"></div>
  <div class="login-card">
    <div class="login-top">
      <div class="login-logo">
        <svg viewBox="0 0 24 24">
          <path d="M4 6h16v2H4zm2 5h12v2H6zm3 5h6v2H9z" />
        </svg>
      </div>
      <div class="login-title">ISI BURGER</div>
      <div class="login-sub">Espace Administrateur</div>
    </div>
    <div class="login-body">
      @if(session('error'))
        <div class="alert-danger"><i class="bi bi-x-circle-fill"></i>{{ session('error') }}</div>
      @endif
      <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="field-group">
          <label class="field-label">Identifiant</label>
          <div style="position:relative;">
            <i class="bi bi-person"
              style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-tertiary);font-size:15px;"></i>
            <input class="field" name="username" placeholder="username" style="padding-left:40px;"
              autocomplete="username">
            @error('username')
              <span class="form-error">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="field-group">
          <label class="field-label">Mot de passe</label>
          <div style="position:relative;">
            <i class="bi bi-lock"
              style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-tertiary);font-size:15px;"></i>
            <input class="field" type="password" name="password" placeholder="••••••••"
              style="padding-left:40px;padding-right:40px;" autocomplete="current-password">
            <button type="button"
              onclick="this.previousElementSibling.type=this.previousElementSibling.type==='password'?'text':'password';this.querySelector('i').className='bi bi-eye'+(this.previousElementSibling.type==='password'?'':'-slash')"
              style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--tx-tertiary);cursor:pointer;"><i
                class="bi bi-eye"></i></button>
          </div>
          @error('password')
            <span class="form-error">{{ $message }}</span>
          @enderror
        </div>
        <button type="submit" class="btn-ember" style="margin-top:4px;">
          <i class="bi bi-arrow-right-circle-fill"></i> Se connecter
        </button>
      </form>
      <p style="text-align:center;margin-top:16px;font-size:11.5px;color:var(--tx-muted);">Accès réservé — ISI BURGER
        Admin</p>
    </div>
  </div>
</body>

</html>