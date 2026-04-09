<?php
session_start();
include "config.php";

// Jika sudah login, langsung redirect
if (isset($_SESSION['user'])) {
    $r = $_SESSION['user']['role'];
    if ($r === 'admin')      redirect('dashboard_admin2.php');
    if ($r === 'pembimbing') redirect('dashboard_pembimbing.php');
    if ($r === 'wakasek')    redirect('dashboard_wakasekubin.php');
    if ($r === 'siswa')      redirect('dashboard.php');
}

// ---- Inisialisasi variabel ----
$error = "";

if (isset($_POST['login'])) {
    // Tangkap & amankan input (sesuai logika login.php asli)
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role     = mysqli_real_escape_string($conn, $_POST['role']);

    // Cek user di tabel users berdasarkan username + role
    $query  = "SELECT * FROM users WHERE username='$username' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // Cek password (plain-text sesuai database yang belum di-hash)
        if ($password == $data['password']) {

            // Simpan session
            $_SESSION['user'] = [
                'id_user'  => $data['id_users'],
                'username' => $data['username'],
                'role'     => $data['role']
            ];

            // Redirect sesuai role
            if ($role === 'admin')      redirect('dashboard_admin2.php');
            if ($role === 'pembimbing') redirect('dashboard_pembimbing.php');
            if ($role === 'wakasek')    redirect('dashboard_wakasekubin.php');
            if ($role === 'siswa')      redirect('dashboard.php');

        } else {
            $error = "Password yang Anda masukkan salah!";
        }
    } else {
        $error = "Username tidak ditemukan atau Role tidak sesuai!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — SIMPKL</title>
  <link rel="stylesheet" href="style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
  <style>
    /* Wrapper halaman login — tanpa header nav admin */
    body { background: #0f172a; }

    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      background:
        radial-gradient(ellipse at 15% 40%, rgba(255,255,255,0.03) 0%, transparent 55%),
        radial-gradient(ellipse at 85% 70%, rgba(255,255,255,0.02) 0%, transparent 55%),
        background: linear-gradient(to bottom, #1b1b46, #090913);;
    }

    .login-box {
      width: 100%;
      max-width: 440px;
      background: linear-gradient(to bottom, #1c1c52, #090913);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 20px;
      padding: 44px 40px;
      box-shadow: 0 30px 70px rgba(0,0,0,0.45);
      animation: fadeUp .5s ease both;
    }

    .login-brand {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 32px;
    }

    .login-brand .brand-icon {
      width: 48px; height: 48px;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem; color: #f1f5f9;
    }

    .login-brand .brand-text h1 {
      font-size: 1.2rem; font-weight: 700; color: #f1f5f9;
    }
    .login-brand .brand-text p {
      font-size: 0.75rem; color: #475569; margin: 0;
    }

    .login-box h2 {
      font-size: 1rem; font-weight: 600; color: #e2e8f0; margin-bottom: 4px;
    }
    .login-box .subtitle {
      font-size: 0.82rem; color: #475569; margin-bottom: 28px;
    }

    /* Input wrapper */
    .input-wrap { position: relative; }
    .input-wrap i.ico-left {
      position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
      color: #475569; font-size: 0.85rem; pointer-events: none;
    }
    .input-wrap .form-control { padding-left: 36px; }
    .input-wrap .eye-toggle {
      position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
      color: #475569; cursor: pointer; font-size: 0.9rem; transition: color .2s;
    }
    .input-wrap .eye-toggle:hover { color: #94a3b8; }

    /* Role pills */
    .role-label-title {
      font-size: 0.8rem; font-weight: 600; color: #64748b;
      margin-bottom: 10px; display: block; letter-spacing: .5px;
    }
    .role-selection { display: flex; flex-wrap: wrap; gap: 8px; }
    .role-selection input[type="radio"] { display: none; }
    .role-selection label {
      padding: 7px 16px;
      border-radius: 8px;
      border: 1px solid rgba(255,255,255,0.1);
      background: rgba(255,255,255,0.04);
      color: #64748b;
      font-size: 0.82rem;
      cursor: pointer;
      transition: all .2s;
      margin: 0;
      letter-spacing: 0;
      font-weight: 500;
    }
    .role-selection input[type="radio"]:checked + label {
      background: #ffffff;
      color: #0f172a;
      border-color: #ffffff;
      font-weight: 700;
    }

    /* Error box */
    .error-box {
      background: rgba(239,68,68,0.08);
      border: 1px solid rgba(239,68,68,0.2);
      color: #ef4444;
      padding: 11px 16px;
      border-radius: 10px;
      font-size: 0.83rem;
      margin-bottom: 20px;
      display: flex; align-items: center; gap: 8px;
    }

    .btn-login {
      width: 100%; padding: 13px;
      background: #ffffff; color: #0f172a;
      font-family: 'Poppins', sans-serif;
      font-size: 0.9rem; font-weight: 700;
      border: none; border-radius: 10px; cursor: pointer;
      transition: all .2s; margin-top: 6px;
    }
    .btn-login:hover {
      background: #f1f5f9;
      box-shadow: 0 6px 24px rgba(255,255,255,0.15);
      transform: translateY(-1px);
    }

    .register-link {
      text-align: center; margin-top: 22px;
      font-size: 0.82rem; color: #475569;
    }
    .register-link a { color: #e2e8f0; font-weight: 600; }
    .register-link a:hover { text-decoration: underline; }

    /* Divider */
    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 20px 0; color: #334155; font-size: .75rem;
    }
    .divider::before, .divider::after {
      content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.07);
    }
  </style>
</head>
<body>
<div class="login-wrapper">
  <div class="login-box">

    <!-- Brand -->
    <div class="login-brand">
      <div class="brand-icon"><i class="fas fa-graduation-cap"></i></div>
      <div class="brand-text">
        <h1>SIMPKL</h1>
        <p>Sistem Informasi Manajemen PKL</p>
      </div>
    </div>

    <h2>Masuk ke Akun</h2>
    <p class="subtitle">Selamat datang kembali! Silakan login untuk melanjutkan.</p>

    <!-- Error -->
    <?php if ($error !== ""): ?>
    <div class="error-box">
      <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <!-- Form -->
    <form action="" method="POST">

      <div class="form-group">
        <label for="username">Username</label>
        <div class="input-wrap">
          <i class="fas fa-user ico-left"></i>
          <input type="text" id="username" name="username" class="form-control"
                 required placeholder="Masukkan username"
                 value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                 autocomplete="username"/>
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrap">
          <i class="fas fa-lock ico-left"></i>
          <input type="password" id="password" name="password" class="form-control"
                 required placeholder="Masukkan password"
                 autocomplete="current-password"/>
          <span class="eye-toggle" onclick="togglePassword()" title="Tampilkan password">
            <i class="fas fa-eye" id="eyeIcon"></i>
          </span>
        </div>
      </div>

      <div class="form-group">
        <span class="role-label-title">Login Sebagai:</span>
        <div class="role-selection">
          <input type="radio" id="role-siswa"      name="role" value="siswa"      checked>
          <label for="role-siswa"><i class="fas fa-user-graduate" style="margin-right:5px;"></i>Siswa</label>

          <input type="radio" id="role-admin"      name="role" value="admin">
          <label for="role-admin"><i class="fas fa-shield-alt" style="margin-right:5px;"></i>Admin</label>

          <input type="radio" id="role-pembimbing" name="role" value="pembimbing">
          <label for="role-pembimbing"><i class="fas fa-chalkboard-teacher" style="margin-right:5px;"></i>Pembimbing</label>

          <input type="radio" id="role-wakasek"    name="role" value="wakasek">
          <label for="role-wakasek"><i class="fas fa-user-tie" style="margin-right:5px;"></i>Wakasek</label>
        </div>
      </div>

      <button type="submit" name="login" class="btn-login">
        <i class="fas fa-sign-in-alt" style="margin-right:8px;"></i>Masuk
      </button>

    </form>

    <p class="register-link">
      Belum punya akun? <a href="register.php">Daftar di sini</a>
    </p>

  </div>
</div>

<script>
function togglePassword() {
  const inp = document.getElementById('password');
  const ico = document.getElementById('eyeIcon');
  if (inp.type === 'password') {
    inp.type = 'text';
    ico.className = 'fas fa-eye-slash';
  } else {
    inp.type = 'password';
    ico.className = 'fas fa-eye';
  }
}
</script>
</body>
</html>
