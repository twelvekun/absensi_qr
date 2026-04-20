<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            <h3><?= isset($title) ? $title : 'Dashboard Admin'; ?></h3>
        </div>
        <div class="user-profile">
            <div class="user-info">
                <span class="name"><?= session()->get('nama'); ?></span>
                <span class="role"><?= session()->get('role'); ?></span>
            </div>
            <a href="<?= base_url('auth/logout') ?>" class="btn-logout" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <div class="content-wrapper">