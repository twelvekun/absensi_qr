<?= view('layout/header', ['title' => 'Generate QR Code']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    .card { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .filter-box { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 15px; align-items: flex-end; border: 1px solid #ddd;}
    .form-group { display: flex; flex-direction: column; }
    .form-group label { font-size: 12px; font-weight: 600; color: #555; margin-bottom: 5px;}
    .filter-input { padding: 8px 12px; border: 1px solid #ccc; border-radius: 5px;}
    .btn-filter { background: #1e5631; color: white; border: none; padding: 9px 15px; border-radius: 5px; cursor: pointer;}
    table { width: 100%; border-collapse: collapse; font-size: 14px;}
    th, td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left;}
    th { background-color: #343a40; color: white;}
    .btn-generate { background: #007bff; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px;}
</style>

<div class="card">
    <h3 style="margin-top: 0;"><i class="fas fa-qrcode"></i> Pusat Pembuatan QR Code</h3>

    <form action="<?= base_url('generateqr') ?>" method="GET" class="filter-box">
        <div class="form-group">
            <label>Jenis Pengguna</label>
            <select name="jenis" id="jenis_select" class="filter-input" onchange="toggleKelas()">
                <option value="siswa" <?= ($jenis == 'siswa') ? 'selected' : '' ?>>Siswa</option>
                <option value="guru" <?= ($jenis == 'guru') ? 'selected' : '' ?>>Guru</option>
                <option value="staf" <?= ($jenis == 'staf') ? 'selected' : '' ?>>Staf</option>
            </select>
        </div>
        
        <div class="form-group" id="kelas_container" style="<?= ($jenis != 'siswa') ? 'display:none;' : '' ?>">
            <label>Filter Kelas</label>
            <select name="id_kelas" class="filter-input">
                <option value="">-- Semua Kelas --</option>
                <?php foreach($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>" <?= ($id_kelas == $k['id_kelas']) ? 'selected' : '' ?>>
                        <?= $k['tingkat'] ?> - <?= $k['nama_kelas'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Cari Data</button>
        </div>
    </form>

    <?php 
        // Logika untuk menentukan Label Header Tabel
        $label_identitas = 'NIS';
        $label_keterangan = 'Kelas';
        if ($jenis == 'guru') { $label_identitas = 'NUPTK'; $label_keterangan = 'Keterangan'; }
        if ($jenis == 'staf') { $label_identitas = 'NIP / ID'; $label_keterangan = 'Keterangan'; }
    ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th><?= $label_identitas ?></th>
                <th>Nama Lengkap</th>
                <th><?= $label_keterangan ?></th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach($data_list as $row): ?>
            
            <?php 
                // Logika pemetaan data agar HTML tetap bersih
                if ($jenis == 'siswa') {
                    $identitas = $row['nis'];
                    $nama = $row['nama_lengkap'];
                    $keterangan = $row['nama_kelas'];
                    $id_row = $row['id_siswa'];
                } elseif ($jenis == 'guru') {
                    $identitas = $row['nuptk'];
                    $nama = $row['nama_guru'];
                    $keterangan = 'Guru';
                    $id_row = $row['id_guru'];
                } elseif ($jenis == 'staf') {
                    // Pastikan nama kolom sesuai dengan di tabel staf database kamu
                    $identitas = $row['nip_staf']; 
                    $nama = $row['nama_staf'];
                    $keterangan = 'Staf Sekolah';
                    $id_row = $row['id_staf'];
                }
            ?>

            <tr>
                <td><?= $i++; ?></td>
                <td><?= $identitas ?></td>
                <td><strong><?= $nama ?></strong></td>
                <td><?= $keterangan ?></td>
                <td style="text-align: center;">
                    <a href="<?= base_url("generateqr/show/$jenis/$id_row") ?>" class="btn-generate">
                        <i class="fas fa-qrcode"></i> Generate QR
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php if(empty($data_list)): ?>
                <tr><td colspan="5" style="text-align: center;">Data tidak ditemukan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    // Fungsi untuk menyembunyikan dropdown kelas jika Guru/Staf dipilih
    function toggleKelas() {
        var jenis = document.getElementById('jenis_select').value;
        var kelasContainer = document.getElementById('kelas_container');
        if (jenis === 'siswa') {
            kelasContainer.style.display = 'block';
        } else {
            kelasContainer.style.display = 'none';
        }
    }
</script>

<?= view('layout/footer') ?>