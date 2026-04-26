<?= view('layout/header', ['title' => 'Ubah Data Absensi']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    .card-form { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #444; font-size: 14px;}
    .form-control { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; font-family: 'Poppins', sans-serif; box-sizing: border-box; font-size: 14px;}
    .form-control[readonly] { background-color: #e9ecef; cursor: not-allowed; }
    .btn-submit { background: #1e5631; color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; font-weight: 500;}
    .btn-cancel { background: #6c757d; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; margin-left: 10px;}
</style>

<div class="card-form">
    <h3 style="margin-top: 0; color: #333;"><i class="fas fa-edit"></i> Ubah Data Absensi</h3>
    <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 25px;">

    <?php 
        // Logika untuk menampilkan nama siapa yang sedang diedit
        $nama = '';
        if (!empty($absen['id_siswa'])) $nama = $absen['nama_siswa'] . ' (Siswa)';
        if (!empty($absen['id_guru']))  $nama = $absen['nama_guru'] . ' (Guru)';
        if (!empty($absen['idstaf']))   $nama = $absen['nama_staf'] . ' (Staf)';
    ?>

    <form action="<?= base_url('laporan/update/' . $absen['no_absen']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label>Identitas Pegawai / Siswa</label>
            <input type="text" class="form-control" value="<?= $nama ?>" readonly>
        </div>

        <div class="form-group">
            <label>Tanggal Absensi</label>
            <input type="text" class="form-control" value="<?= date('d F Y', strtotime($absen['tanggal'])) ?> (<?= $absen['hari'] ?>)" readonly>
        </div>

        <div style="display: flex; gap: 15px;">
            <div class="form-group" style="flex: 1;">
                <label>Jam Masuk</label>
                <input type="time" name="masuk" class="form-control" value="<?= $absen['masuk'] ?>">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Jam Pulang</label>
                <input type="time" name="pulang" class="form-control" value="<?= $absen['pulang'] ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Status Kehadiran</label>
            <select name="status_kehadiran" class="form-control" required>
                <option value="Hadir" <?= ($absen['status_kehadiran'] == 'Hadir') ? 'selected' : '' ?>>Hadir (Normal)</option>
                <option value="Sakit" <?= ($absen['status_kehadiran'] == 'Sakit') ? 'selected' : '' ?>>Sakit (Ada Surat)</option>
                <option value="Izin"  <?= ($absen['status_kehadiran'] == 'Izin') ? 'selected' : '' ?>>Izin (Acara Keluarga/Dinas)</option>
                <option value="Alpa"  <?= ($absen['status_kehadiran'] == 'Alpa') ? 'selected' : '' ?>>Alpa (Tanpa Keterangan)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Keterangan Tambahan (Opsional)</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Surat Sakit dari RS Siti Hajar nomor 123..."><?= $absen['keterangan'] ?></textarea>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="javascript:history.back()" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>

<?= view('layout/footer') ?>