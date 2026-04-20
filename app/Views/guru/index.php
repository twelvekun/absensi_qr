<?= view('layout/header', ['title' => 'Data Guru']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    .card { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .header-action { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; font-size: 14px;}
    th, td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left; }
    th { background-color: #f8f9fa; color: #333; font-weight: 600; }
    tr:hover { background-color: #f1f1f1; transition: 0.2s;}
    
    .btn { padding: 8px 15px; border-radius: 6px; text-decoration: none; color: white; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 5px; transition: 0.2s;}
    .btn-add { background-color: #4c9a2a; }
    .btn-add:hover { background-color: #3d7a22; }
    .btn-info { background-color: #17a2b8; }
    .btn-info:hover { background-color: #138496; }
    .btn-danger { background-color: #dc3545; }
    .btn-danger:hover { background-color: #c82333; }
    .btn-warning { background-color: #ffc107; color: #212529; }
    .btn-warning:hover { background-color: #e0a800; color: #212 }
    
    .alert { background: #d4edda; color: #155724; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb;}
</style>

<div class="card">
    <div class="header-action">
        <h3 style="margin: 0;">Manajemen Data Guru</h3>
        <a href="<?= base_url('guru/create') ?>" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Guru</a>
    </div>

    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="alert"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NUPTK / NIP</th>
                <th>Nama Guru</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach($guru as $g): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><strong><?= $g['nuptk']; ?></strong></td>
                <td><?= $g['nama_guru']; ?></td>
                <td style="text-align: center; gap: 5px; display: flex; justify-content: center;">
                    <a href="<?= base_url('guru/show/'.$g['id_guru']) ?>" class="btn btn-info" title="Lihat Detail"><i class="fas fa-eye"></i> Detail</a>
                    <a href="<?= base_url('guru/edit/'.$g['id_guru']) ?>" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                    <a href="<?= base_url('guru/delete/'.$g['id_guru']) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data guru ini?')" title="Hapus"><i class="fas fa-trash"></i> Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php if(empty($guru)): ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px; color: #777;">Belum ada data guru. Silakan tambah data baru.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= view('layout/footer') ?>