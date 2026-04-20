<?= view('layout/header', ['title' => 'Dashboard Utama']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<div class="welcome-card">
    <h2>Selamat Datang, <?= session()->get('nama'); ?>!</h2>
    <p>Anda berada di panel kontrol Sistem Absensi Berbasis QR Code menggunakan metode koreksi kesalahan Algoritma Reed-Solomon. Silakan kelola data kehadiran, master siswa, dan hasilkan QR Code melalui menu di sebelah kiri.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-details">
            <h4>345</h4>
            <span>Total Siswa</span>
        </div>
    </div>
    </div>

<?= view('layout/footer') ?>