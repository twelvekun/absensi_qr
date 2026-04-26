<?= view('layout/header', ['title' => 'Dashboard Utama']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    .welcome-card { background: linear-gradient(135deg, #1e5631 0%, #4c9a2a 100%); color: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .welcome-card h2 { margin-top: 0; }
    .welcome-card p { opacity: 0.9; line-height: 1.6; margin-bottom: 0; }

    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 25px; }
    
    .stat-card { background: #fff; padding: 20px; border-radius: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #ccc; transition: 0.3s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    
    /* Warna khusus untuk setiap kartu */
    .card-siswa { border-left-color: #17a2b8; }
    .card-guru { border-left-color: #fd7e14; }
    .card-staf { border-left-color: #6f42c1; }
    .card-absen { border-left-color: #28a745; }
    .card-persen { border-left-color: #e83e8c; }

    .stat-icon { font-size: 35px; margin-right: 20px; color: #666; opacity: 0.7;}
    .stat-details h4 { margin: 0; font-size: 24px; color: #333; font-weight: bold; }
    .stat-details span { font-size: 13px; color: #777; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;}
    
    /* Warna icon menyesuaikan kartu */
    .card-siswa .stat-icon { color: #17a2b8; }
    .card-guru .stat-icon { color: #fd7e14; }
    .card-staf .stat-icon { color: #6f42c1; }
    .card-absen .stat-icon { color: #28a745; }
    .card-persen .stat-icon { color: #e83e8c; }
</style>

<div class="welcome-card">
    <h2>Selamat Datang, <?= session()->get('nama') ?? 'Administrator'; ?>!</h2>
    <p>Anda berada di panel kontrol Sistem Absensi Berbasis QR Code menggunakan metode koreksi kesalahan Algoritma Reed-Solomon. Silakan kelola data kehadiran, master siswa, dan hasilkan QR Code melalui menu di sebelah kiri.</p>
</div>

<div class="stats-grid">
    <div class="stat-card card-siswa">
        <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-details">
            <h4><?= number_format($total_siswa) ?></h4>
            <span>Total Siswa</span>
        </div>
    </div>

    <div class="stat-card card-guru">
        <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="stat-details">
            <h4><?= number_format($total_guru) ?></h4>
            <span>Total Guru</span>
        </div>
    </div>

    <div class="stat-card card-staf">
        <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
        <div class="stat-details">
            <h4><?= number_format($total_staf) ?></h4>
            <span>Total Staf</span>
        </div>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
    <div class="stat-card card-absen">
        <div class="stat-icon"><i class="fas fa-clipboard-check"></i></div>
        <div class="stat-details">
            <h4><?= number_format($hadir_hari_ini) ?> <small style="font-size: 14px; color: #888;">Orang</small></h4>
            <span>Telah Absen Hari Ini (<?= date('d M Y') ?>)</span>
        </div>
    </div>

    <div class="stat-card card-persen">
        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        <div class="stat-details">
            <h4><?= $persentase_hadir ?>%</h4>
            <span>Tingkat Kehadiran Harian</span>
            <div style="background: #eee; height: 6px; border-radius: 3px; margin-top: 8px; width: 100%;">
                <div style="background: #e83e8c; height: 100%; border-radius: 3px; width: <?= $persentase_hadir ?>%;"></div>
            </div>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>