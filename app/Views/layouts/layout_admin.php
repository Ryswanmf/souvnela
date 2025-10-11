<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Admin Panel | Souvnela' ?></title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #4f46e5;
      --bg: #f4f6fa;
      --text: #1e1e2f;
      --muted: #6b7280;
      --sidebar-bg: rgba(255, 255, 255, 0.8);
      --glass-blur: 18px;
    }

    body {
      font-family: 'Inter', 'Segoe UI', sans-serif;
      background-color: var(--bg);
      color: var(--text);
      overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      background: var(--sidebar-bg);
      backdrop-filter: blur(var(--glass-blur));
      border-right: 1px solid rgba(255, 255, 255, 0.2);
      padding: 2rem 1rem;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 15px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }

    .brand {
      font-weight: 700;
      font-size: 1.4rem;
      color: var(--primary);
      margin-bottom: 2rem;
      text-align: center;
      letter-spacing: -0.5px;
    }

    .nav-link {
      color: var(--muted);
      font-weight: 500;
      border-radius: 10px;
      padding: 0.65rem 0.9rem;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: 0.25s;
    }

    .nav-link:hover {
      background: rgba(79, 70, 229, 0.1);
      color: var(--primary);
      transform: translateX(3px);
    }

    .nav-link.active {
      background-color: var(--primary);
      color: #fff;
      box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    }

    /* Topbar */
    .topbar {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(var(--glass-blur));
      position: sticky;
      top: 0;
      left: 250px;
      z-index: 100;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.8rem 2rem;
      border-bottom: 1px solid rgba(0,0,0,0.05);
      transition: left 0.3s ease;
    }

    /* Main Content */
    main {
      margin-left: 250px;
      padding: 2rem;
      transition: margin-left 0.3s ease;
    }

    footer {
      text-align: center;
      color: var(--muted);
      padding: 1rem 0;
      font-size: 0.85rem;
    }

    /* Sidebar toggle (mobile) */
    @media (max-width: 991px) {
      .sidebar {
        transform: translateX(-100%);
      }
      .sidebar.show {
        transform: translateX(0);
      }
      .topbar {
        left: 0;
      }
      main {
        margin-left: 0;
      }
    }

    /* Avatar */
    .user img {
      border: 2px solid var(--primary);
      border-radius: 50%;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
  <div class="brand">
    <i class="bi bi-bag-heart-fill me-1"></i> Souvnela
  </div>

  <nav class="nav flex-column">
    <a href="<?= base_url('admin') ?>" class="nav-link <?= url_is('admin') ? 'active' : '' ?>">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="<?= base_url('admin/produk') ?>" class="nav-link <?= url_is('admin/produk*') ? 'active' : '' ?>">
      <i class="bi bi-box-seam"></i> Produk
    </a>
    <a href="<?= base_url('admin/pesanan') ?>" class="nav-link <?= url_is('admin/pesanan*') ? 'active' : '' ?>">
      <i class="bi bi-receipt"></i> Pesanan
    </a>
    <a href="<?= base_url('admin/blog') ?>" class="nav-link <?= url_is('admin/blog*') ? 'active' : '' ?>">
      <i class="bi bi-journal-text"></i> Blog
    </a>
    <a href="<?= base_url('admin/kontak') ?>" class="nav-link <?= url_is('admin/kontak*') ? 'active' : '' ?>">
      <i class="bi bi-envelope"></i> Kontak
    </a>
    <a href="<?= base_url('admin/pengguna') ?>" class="nav-link <?= url_is('admin/pengguna*') ? 'active' : '' ?>">
      <i class="bi bi-people"></i> Pengguna
    </a>
  </nav>
</aside>

<!-- Topbar -->
<div class="topbar">
  <button class="btn btn-outline-primary d-lg-none" id="toggleSidebar">
    <i class="bi bi-list"></i>
  </button>
  <h5 class="m-0 fw-semibold"><?= $pageTitle ?? 'Dashboard' ?></h5>
  <div class="user d-flex align-items-center gap-2">
    <img src="<?= base_url('assets/images/admin.png') ?>" alt="Admin" width="38" height="38">
    <span class="fw-medium">Admin</span>
  </div>
</div>

<!-- Content -->
<main>
  <?= $this->renderSection('content') ?>
</main>

<footer>
  © <?= date('Y') ?> <b>Souvnela</b> — Dashboard Admin
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('toggleSidebar').addEventListener('click', () => {
  document.getElementById('sidebar').classList.toggle('show');
});
</script>

</body>
</html>
