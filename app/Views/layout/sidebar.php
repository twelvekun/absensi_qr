<div class="sidebar">
    <div class="sidebar-header">
        <img src="<?= base_url('assets/img/logo-sekolah.jpeg') ?>" alt="Logo Sekolah" style="width: 80px;">
        <h2>Absensi Digital</h2>
        <p>SMP Hasyim Asy'ari</p>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?= base_url('dashboard') ?>" class="<?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>">
                <i class="fas fa-home"></i> <span>Dashboard</span>
            </a>
        </li>
        
        <div class="menu-label">Data Master</div>
        <li>
            <a href="<?= base_url('siswa') ?>" class="<?= (uri_string() == 'siswa') ? 'active' : '' ?>">
                <i class="fas fa-users"></i> <span>Data Siswa</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('guru') ?>" class="<?= (uri_string() == 'guru') ? 'active' : '' ?>">
                <i class="fas fa-chalkboard-teacher"></i> <span>Data Guru</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('staf') ?>" class="<?= (uri_string() == 'staf') ? 'active' : '' ?>">
                <i class="fas fa-user-tie"></i> <span>Data Staf</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('kelas') ?>" class="<?= (uri_string() == 'kelas') ? 'active' : '' ?>">
                <i class="fas fa-school"></i> <span>Data Kelas</span>
            </a>
        </li>

        <div class="menu-label">Fitur Absensi</div>
        <li>
            <a href="<?= base_url('generateqr') ?>" class="<?= (strpos(uri_string(), 'generateqr') !== false) ? 'active' : '' ?>">
                <i class="fas fa-qrcode"></i> <span>Generate QR Code</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('scan') ?>" class="<?= (uri_string() == 'scan') ? 'active' : '' ?>">
                <i class="fas fa-camera"></i> <span>Scan Kehadiran</span>
            </a>
        </li>

        <div class="menu-label">Laporan</div>
<li>
    <a href="<?= base_url('laporan/siswa') ?>" class="<?= (uri_string() == 'laporan/siswa') ? 'active' : '' ?>">
        <i class="fas fa-user-graduate"></i> <span>Absensi Siswa</span>
    </a>
</li>
<li>
    <a href="<?= base_url('laporan/guru') ?>" class="<?= (uri_string() == 'laporan/guru') ? 'active' : '' ?>">
        <i class="fas fa-chalkboard-teacher"></i> <span>Absensi Guru & Staf</span>
    </a>
</li>
        <li>
            <a href="#">
                <i class="fas fa-user-shield"></i> <span>Manajemen Admin</span>
            </a>
        </li>
    </ul>
</div>