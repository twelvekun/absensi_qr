<?= view('layout/header', ['title' => $title]) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    .card { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .header-action { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .btn-add { background: #1e5631; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-size: 14px; font-weight: 500;}
    table { width: 100%; border-collapse: collapse; font-size: 14px;}
    th, td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left; vertical-align: middle;}
    th { background-color: #343a40; color: white; font-weight: 600;}
    .badge-super { background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;}
    .badge-petugas { background: #007bff; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;}
    .btn-del { background: #dc3545; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none; font-size: 12px;}
    .btn-edit { background: rgba(198, 252, 2, 0.88); color: black; padding: 6px 10px; border-radius: 4px; text-decoration: none; font-size: 12px;}
</style>

<div class="card">
    <div class="header-action">
        <h3 style="margin: 0; color: #333;"><i class="fas fa-users-cog"></i> Daftar Admin & Petugas</h3>
        <a href="<?= base_url('admin/create') ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah Pengguna</a>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Lengkap</th>
                <th width="25%">Username</th>
                <th width="20%">Role Akses</th>
                <th width="20%" style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach($admin as $a): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><strong><?= $a['nama']; ?></strong></td>
                <td><?= $a['username']; ?></td>
                <td>
                    <?php if($a['role'] == 'Superadmin'): ?>
                        <span class="badge-super"><i class="fas fa-crown"></i> SUPERADMIN</span>
                    <?php else: ?>
                        <span class="badge-petugas"><i class="fas fa-user-shield"></i> PETUGAS</span>
                    <?php endif; ?>
                </td>
                <td style="text-align: center;">
                    <a href="<?= base_url('admin/edit/'.$a['id_pengguna']) ?>" class="btn-edit" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                    <a href="<?= base_url('admin/delete/'.$a['id_pengguna']) ?>" class="btn-del" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= view('layout/footer') ?>