<?= view('layout/header', ['title' => 'Laporan Absensi Guru']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    /* CSS SAMA SEPERTI DI ATAS */
    .card { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .header-action { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .filter-box { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 15px; align-items: flex-end; border: 1px solid #ddd;}
    .form-group { margin-bottom: 0; display: flex; flex-direction: column; }
    .form-group label { font-size: 12px; font-weight: 600; color: #555; margin-bottom: 5px;}
    .filter-input { padding: 8px 12px; border: 1px solid #ccc; border-radius: 5px; font-family: 'Poppins', sans-serif;}
    .btn-filter { background: #1e5631; color: white; border: none; padding: 9px 15px; border-radius: 5px; cursor: pointer; font-weight: 500;}
    .btn-reset { background: #6c757d; color: white; padding: 9px 15px; border-radius: 5px; text-decoration: none; font-size: 13px;}
    table { width: 100%; border-collapse: collapse; font-size: 14px;}
    th, td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left;}
    th { background-color: #fd7e14; color: white; font-weight: 600; text-transform: uppercase; font-size: 12px;}
    .time-badge { background: #e9ecef; padding: 4px 8px; border-radius: 4px; font-weight: bold; color: #333; font-family: monospace; font-size: 13px;}
</style>

<div class="card">
    <div class="header-action">
        <h3 style="margin: 0; color: #333;"><i class="fas fa-chalkboard-teacher"></i> Data Absensi Guru & Staf</h3>
        <button class="btn-filter" style="background: #4c9a2a;"><i class="fas fa-print"></i> Cetak PDF</button>
    </div>

    <form action="<?= base_url('laporan/guru') ?>" method="GET" class="filter-box">
        <div class="form-group">
            <label>Filter Tanggal</label>
            <input type="date" name="tanggal" class="filter-input" value="<?= $filter_tanggal ?>">
        </div>
        <div class="form-group">
            <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Tampilkan</button>
        </div>
        <?php if($filter_tanggal): ?>
            <div class="form-group">
                <a href="<?= base_url('laporan/guru') ?>" class="btn-reset"><i class="fas fa-sync"></i> Reset</a>
            </div>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal & Hari</th>
                <th>NUPTK / NIP</th>
                <th>Nama Pegawai</th>
                <th style="text-align: center;">Jam Masuk</th>
                <th style="text-align: center;">Jam Pulang</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach($laporan as $l): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><strong><?= date('d/m/Y', strtotime($l['tanggal'])); ?></strong><br><small><?= $l['hari']; ?></small></td>
                <td><?= $l['nuptk']; ?></td>
                <td><strong><?= $l['nama_guru']; ?></strong></td>
                <td style="text-align: center;"><span class="time-badge"><i class="fas fa-sign-in-alt" style="color: #28a745;"></i> <?= $l['masuk']; ?></span></td>
                <td style="text-align: center;">
                    <?= (!empty($l['pulang']) && $l['pulang'] != '00:00:00') ? '<span class="time-badge"><i class="fas fa-sign-out-alt" style="color: #dc3545;"></i> '.$l['pulang'].'</span>' : '<span style="color:#dc3545; font-size:12px;">Belum Pulang</span>'; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($laporan)): ?><tr><td colspan="6" style="text-align: center; padding: 20px;">Data tidak ditemukan.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<?= view('layout/footer') ?>