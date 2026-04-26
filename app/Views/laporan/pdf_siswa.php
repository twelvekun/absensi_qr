<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak PDF Laporan Absensi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .kop-surat { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h2, .kop-surat h3, .kop-surat p { margin: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #e9ecef; }
        .text-left { text-align: left; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>SMP HASYIM ASY'ARI</h2>
        <h3>Laporan Rekapitulasi Kehadiran Siswa</h3>
        <p>Tanggal Laporan: <?= !empty($tanggal) ? date('d-m-Y', strtotime($tanggal)) : 'Semua Waktu' ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach($laporan as $l): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= date('d/m/Y', strtotime($l['tanggal'])); ?></td>
                <td><?= $l['nis']; ?></td>
                <td class="text-left"><?= $l['nama_siswa']; ?></td>
                <td><?= $l['nama_kelas']; ?></td>
                <td><?= $l['masuk']; ?></td>
                <td><?= (!empty($l['pulang']) && $l['pulang'] != '00:00:00') ? $l['pulang'] : '-'; ?></td>
                <td><?= $l['status_kehadiran'] ?? 'Hadir'; ?></td>
                <td><?= !empty($l['keterangan']) ? $l['keterangan'] : '-'; ?></td>
            </tr>
            <?php endforeach; ?>
            
            <?php if(empty($laporan)): ?>
            <tr>
                <td colspan="9">Tidak ada data absensi pada pencarian ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>