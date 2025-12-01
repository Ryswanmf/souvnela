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
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="<?= base_url('admin') ?>" class="nav-link <?= url_is('admin') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/produk') ?>" class="nav-link <?= url_is('admin/produk*') ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i> Produk
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/kategori') ?>" class="nav-link <?= url_is('admin/kategori*') ? 'active' : '' ?>">
                <i class="bi bi-tags"></i> Kategori Produk
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/pesanan') ?>" class="nav-link <?= url_is('admin/pesanan*') ? 'active' : '' ?>">
                <i class="bi bi-receipt"></i> Pesanan
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/invoice') ?>" class="nav-link <?= url_is('admin/invoice*') ? 'active' : '' ?>">
                <i class="bi bi-receipt-cutoff"></i> Invoice
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/voucher') ?>" class="nav-link <?= url_is('admin/voucher*') ? 'active' : '' ?>">
                <i class="bi bi-ticket-perforated"></i> Voucher
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/midtrans') ?>" class="nav-link <?= url_is('admin/midtrans*') ? 'active' : '' ?>">
                <i class="bi bi-credit-card"></i> Midtrans
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/blog') ?>" class="nav-link <?= url_is('admin/blog*') ? 'active' : '' ?>">
                <i class="bi bi-journal-text"></i> Blog
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/kontak') ?>">
                <i class="bi bi-envelope"></i>
                <span>Kontak</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/info-pages') ?>" class="nav-link <?= url_is('admin/info-pages*') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text"></i> Halaman Informasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
            <div id="collapseSettings" class="collapse" aria-labelledby="headingSettings" data-bs-parent="#accordionSidebar">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/setting/hero') ?>"><i class="bi bi-aspect-ratio"></i> Hero</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/setting/features') ?>"><i class="bi bi-star"></i> Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/setting/about') ?>"><i class="bi bi-info-circle"></i> Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/setting/contact') ?>"><i class="bi bi-telephone"></i> Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/setting/general') ?>"><i class="bi bi-gear"></i> Umum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/testimonial') ?>"><i class="bi bi-chat-quote"></i> Testimoni</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/pengguna') ?>" class="nav-link <?= url_is('admin/pengguna*') ? 'active' : '' ?>">
                <i class="bi bi-people"></i> Pengguna
            </a>
        </li>
    </ul>
</nav>
</aside>

<!-- Topbar -->
<div class="topbar">
  <button class="btn btn-outline-primary d-lg-none" id="toggleSidebar">
    <i class="bi bi-list"></i>
  </button>
  <h5 class="m-0 fw-semibold"><?= $pageTitle ?? 'Dashboard' ?></h5>
  <div class="dropdown">
      <a href="#" class="user d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="<?= session()->get('foto_profil') ? base_url('uploads/' . session()->get('foto_profil')) : base_url('assets/images/default-avatar.png') ?>" alt="Admin" width="38" height="38">
          <span class="fw-medium text-dark"><?= esc(session()->get('nama_lengkap') ?? 'Admin') ?> <i class="bi bi-chevron-down small"></i></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm">
          <li><a class="dropdown-item" href="<?= base_url('/') ?>" target="_blank"><i class="bi bi-house me-2"></i>Lihat Situs</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
      </ul>
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
